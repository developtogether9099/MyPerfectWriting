<?php

namespace App\Http\Controllers\Seller;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CPU\Helpers;
use App\Model\Category;

use App\Model\Color;
use Brian2694\Toastr\Facades\Toastr;
use App\Model\Order;
use App\Model\Coupon;
use App\User;
use App\Model\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\CPU\BackEndHelper;
use App\Model\Shop;
use App\Model\BusinessSetting;
use App\SellerProducts;
use Rap2hpoutre\FastExcel\FastExcel;

class POSController extends Controller
{
  public function order_list(Request $request)
  {
    $seller = auth('seller')->user();
    $seller_pos = BusinessSetting::where('type', 'seller_pos')->first()->value;
    if ($seller->pos_status == 0 || $seller_pos == 0) {
      Toastr::warning(\App\CPU\translate('access_denied!!'));
      return back();
    }


    $search = $request['search'];
    $from = $request['from'];
    $to = $request['to'];

    $orders = Order::with(['customer'])->where(['seller_is' => 'seller'])->where(['seller_id' => \auth('seller')->id()])->where('order_status', 'delivered');

    $key = $request['search'] ? explode(' ', $request['search']) : '';
    $orders = $orders->when($request->has('search') && $search != null, function ($q) use ($key) {
      $q->where(function ($qq) use ($key) {
        foreach ($key as $value) {
          $qq->where('id', 'like', "%{$value}%")
            ->orWhere('order_status', 'like', "%{$value}%")
            ->orWhere('transaction_ref', 'like', "%{$value}%");
        }
      });
    })->when($from != null, function ($dateQuery) use ($from, $to) {
      $dateQuery->whereDate('created_at', '>=', $from)
        ->whereDate('created_at', '<=', $to);
    });

    $orders = $orders->where('order_type', 'POS')->orderBy('id', 'desc')->paginate(Helpers::pagination_limit())->appends(['search' => $request['search'], 'from' => $request['from'], 'to' => $request['to']]);

    return view('seller-views.pos.order.list', compact('orders', 'search', 'from', 'to'));
  }

  public function bulk_export_data(Request $request)
  {
    $from   = $request['from'];
    $to     = $request['to'];

    $orders = Order::with(['customer'])
      ->where('order_type', 'POS')
      ->where(['seller_id' => \auth('seller')->id()])
      ->where(['seller_is' => 'seller'])
      ->where('order_status', 'delivered')
      ->when(!empty($from) && !empty($to), function ($query) use ($from, $to) {
        $query->whereDate('created_at', '>=', $from)
          ->whereDate('created_at', '<=', $to);
      })->latest()->get();


    $posData = array();
    $cust = User::where('name', session('cus_name'))->first();
    foreach ($orders as $order) {
      $posData[] = array(
        'Order ID'      => $order->id,
        'Date'          => date('d M Y', strtotime($order->created_at)),
        'Customer Name' => $order->customer ? $cust->f_name . ' ' . $cust->l_name : \App\CPU\translate('invalid_customer_data'),
        'Status'        => $order->payment_status == 'paid' ? 'paid' : 'unpaid',
        'Total'         => \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($order->order_amount)),
        'Order Status'  => $order->order_status ?? '',
      );
    }

    return (new FastExcel($posData))->download('POS_Order_All_data.xlsx');
  }

  public function order_details($id)
  {
    $seller = auth('seller')->user();
    $seller_pos = BusinessSetting::where('type', 'seller_pos')->first()->value;
    if ($seller->pos_status == 0 || $seller_pos == 0) {
      Toastr::warning(\App\CPU\translate('access_denied!!'));
      return back();
    }

    $order = Order::with('details', 'shipping', 'seller')->where(['id' => $id])->first();

    return view('seller-views.pos.order.order-details', compact('order'));
  }

  /*
     *  Digital file upload after sell
     */
  public function digital_file_upload_after_sell(Request $request)
  {
    $request->validate([
      'digital_file_after_sell'    => 'required|mimes:jpg,jpeg,png,gif,zip,pdf'
    ], [
      'digital_file_after_sell.required' => 'Digital file upload after sell is required',
      'digital_file_after_sell.mimes' => 'Digital file upload after sell upload must be a file of type: pdf, zip, jpg, jpeg, png, gif.',
    ]);

    $order_details = OrderDetail::find($request->order_id);
    $order_details->digital_file_after_sell = ImageManager::update('product/digital-product/', $order_details->digital_file_after_sell, $request->digital_file_after_sell->getClientOriginalExtension(), $request->file('digital_file_after_sell'));

    if ($order_details->save()) {
      Toastr::success('Digital file upload successfully!');
    } else {
      Toastr::error('Digital file upload failed!');
    }
    return back();
  }

  public function index(Request $request)
  {
    $seller = auth('seller')->user();
    $seller_pos = BusinessSetting::where('type', 'seller_pos')->first()->value;
    if ($seller->pos_status == 0 || $seller_pos == 0) {
      Toastr::warning(\App\CPU\translate('access_denied!!'));
      return back();
    }

    $category = $request->query('category_id', 0);
    $keyword = $request->query('search', false);
    $categories = Category::where('position', 0)->latest()->get();

    $shop = Shop::where(['seller_id' => $seller->id])->first();

    $key = explode(' ', $keyword);
    $products = DB::table('seller_products')->where('seller_id', auth('seller')->id())->where('current_stock', '!=', 0)
      ->where('status', 1)
      ->when($request->has('category_id') && $request['category_id'] != 0, function ($query) use ($request) {
        $query->whereJsonContains('category_ids', [['id' => (string)$request['category_id']]]);
      })
      ->when($keyword, function ($query) use ($key) {
        return $query->where(function ($q) use ($key) {
          foreach ($key as $value) {
            $q->orWhere('name', 'like', "%{$value}%");
          }
        });
      })
      ->latest()->paginate(Helpers::pagination_limit());

    $cart_id = 'wc-' . rand(10, 1000);

    if (!session()->has('current_user')) {
      session()->put('current_user', $cart_id);
    }

    if (!session()->has('cart_name')) {
      if (!in_array($cart_id, session('cart_name') ?? [])) {
        session()->push('cart_name', $cart_id);
      }
    }

    return view('seller-views.pos.index', compact('categories', 'cart_id', 'category', 'keyword', 'products', 'shop'));
  }
  public function search_product(Request $request)
  {

    $request->validate([
      'name' => 'required',
    ], [
      'name.required' => 'Product name is required',
    ]);

    $key = explode(' ', $request['name']);
    $products = DB::table('seller_products')->where(['seller_id' => \auth('seller')->id()])
      ->where('status', 1)
      ->when($request->has('category_id') && $request['category_id'] != 0, function ($query) use ($request) {
        $query->whereJsonContains('category_ids', [[['id' => (string)$request['category_id']]]]);
      })->where(function ($q) use ($key) {
        foreach ($key as $value) {
          $q->where('name', 'like', "%{$value}%");
        }
      })->paginate(6);

    $count_p = $products->count();
    $count_p = $products->count();

    if ($count_p > 0) {
      return response()->json([
        'count' => $count_p,
        'id' => $products[0]->id,
        'result' => view('admin-views.pos._search-result', compact('products'))->render(),
      ]);
    } else {
      return response()->json([
        'count' => $count_p,
        'result' => view('admin-views.pos._search-result', compact('products'))->render(),
      ]);
    }
  }

  public function quick_view(Request $request)
  {
    $product = DB::table('seller_products')->where('id',$request->product_id)->first();

    return response()->json([
      'success' => 1,
      'view' => view('seller-views.pos._quick-view-data', compact('product'))->render(),
    ]);
  }
  public function variant_price(Request $request)
  {
    $product = DB::table('seller_products')->where('id',$request->id)->first();
    $str = '';
    $quantity = 0;
    $price = 0;

    if ($request->has('color')) {
      $str = Color::where('code', $request['color'])->first()->name;
    }

    foreach (json_decode(DB::table('seller_products')->where('id',$request->id)->first()->choice_options) as $key => $choice) {
      if ($str != null) {
        $str .= '-' . str_replace(' ', '', $request[$choice->name]);
      } else {
        $str .= str_replace(' ', '', $request[$choice->name]);
      }
    }

    if ($str != null) {
      $count = count(json_decode($product->variation));
      for ($i = 0; $i < $count; $i++) {
        if (json_decode($product->variation)[$i]->type == $str) {
          $tax = Helpers::tax_calculation(json_decode($product->variation)[$i]->price, $product['tax'], $product['tax_type']);
          $discount = Helpers::get_product_discount($product, json_decode($product->variation)[$i]->price);
          $price = json_decode($product->variation)[$i]->price - $discount + $tax;
          $quantity = json_decode($product->variation)[$i]->qty;
        }
      }
    } else {
      $tax = Helpers::tax_calculation($product->unit_price, $product->tax, $product->tax_type);
      $discount = Helpers::get_product_discount($product, $product->unit_price);
      $price = $product->unit_price - $discount + $tax;
      $quantity = $product->current_stock;
    }

    return [
      'price' => \App\CPU\Helpers::currency_converter($price * $request->quantity),
      'discount' => \App\CPU\Helpers::currency_converter($discount),
      'tax' => \App\CPU\Helpers::currency_converter($tax),
      'quantity' => $quantity
    ];
  }
  public function addToCart(Request $request)
  {
    $cart_id = session('current_user');
    $user_id = 0;
    $user_type = 'wc';
    if (Str::contains(session('current_user'), 'sc')) {
      $user_id = explode('-', session('current_user'))[1];
      $user_type = 'sc';
    }

    $product = DB::table('seller_products')->where('id',$request->id)->first();

    $data = array();
    $data['id'] = $product->id;
    $str = '';
    $variations = [];
    $price = 0;
    $p_qty = 0;
    $current_qty = 0;

    //check the color enabled or disabled for the product
    if ($request->has('color')) {
      $str = Color::where('code', $request['color'])->first()->name;
      $variations['color'] = $str;
    }
    //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
    foreach (json_decode($product->choice_options) as $key => $choice) {
      $data[$choice->name] = $request[$choice->name];
      $variations[$choice->title] = $request[$choice->name];
      if ($str != null) {
        $str .= '-' . str_replace(' ', '', $request[$choice->name]);
      } else {
        $str .= str_replace(' ', '', $request[$choice->name]);
      }
    }

    $data['variations'] = $variations;
    $data['variant'] = $str;
    $cart = session($cart_id);
    if (session()->has($cart_id) && count($cart) > 0) {

      foreach ($cart as $key => $cartItem) {
        if (is_array($cartItem) && $cartItem['id'] == $request['id'] && $cartItem['variant'] == $str) {
          return response()->json([
            'data' => 1,
            'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
          ]);
        }
      }
    }

    //Check the string and decreases quantity for the stock
    if ($str != null) {

      $count = count(json_decode($product->variation));
      for ($i = 0; $i < $count; $i++) {

        if (json_decode($product->variation)[$i]->type == $str) {
          $p_qty = json_decode($product->variation)[$i]->qty;
          $current_qty = $p_qty - $request['quantity'];
          if ($current_qty < 0) {
            return response()->json([
              'data' => 0,
              'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
            ]);
          }

          $price = json_decode($product->variation)[$i]->price;
        }
      }
    } else {
      $p_qty = $product->current_stock;
      $current_qty = $p_qty - $request['quantity'];
      if ($product->product_type == 'physical' && $current_qty < 0) {
        return response()->json([
          'data' => 0,
          'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
        ]);
      }
      $price = $product->unit_price;
    }

    $data['quantity'] = $request['quantity'];
    $data['price'] = $price;
    $data['name'] = $product->name;
    $data['discount'] = Helpers::get_product_discount($product, $price);
    $data['image'] = $product->thumbnail;


    if (session()->has($cart_id)) {
      $keeper = [];
      foreach (session($cart_id) as $item) {
        array_push($keeper, $item);
      }
      array_push($keeper, $data);
      session()->put($cart_id, $keeper);
    } else {
      session()->put($cart_id, [$data]);
    }

    return response()->json([
      'data' => $data,
      'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
    ]);
  }

  public function cart_items()
  {
    return view('seller-views.pos._cart');
  }

  public function emptyCart(Request $request)
  {
    $cart_id = session('current_user');
    $user_id = 0;
    $user_type = 'wc';
    if (Str::contains(session('current_user'), 'sc')) {
      $user_id = explode('-', session('current_user'))[1];
      $user_type = 'sc';
    }
    session()->forget($cart_id);
    return response()->json([
      'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
    ], 200);
  }
  public function removeFromCart(Request $request)
  {
    $cart_id = session('current_user');
    $user_id = 0;
    $user_type = 'wc';

    if (Str::contains(session('current_user'), 'sc')) {
      $user_id = explode('-', session('current_user'))[1];
      $user_type = 'sc';
    }

    $cart = session($cart_id);
    $cart_keeper = [];

    if (session()->has($cart_id) && count($cart) > 0) {
      foreach ($cart as $key => $cartItem) {
        if ($key != $request['key']) {
          array_push($cart_keeper, $cartItem);
        }
      }
    }
    session()->put($cart_id, $cart_keeper);

    return response()->json(['view' => view('seller-views.pos._cart', compact('cart_id'))->render()], 200);
  }
  public function updateQuantity(Request $request)
  {
    $cart_id = session('current_user');
    $user_id = 0;
    $user_type = 'wc';
    if (Str::contains(session('current_user'), 'sc')) {
      $user_id = explode('-', session('current_user'))[1];
      $user_type = 'sc';
    }

    if ($request->quantity > 0) {

      $product = DB::table('seller_products')->where('id',$request->key)->first();
      $product_qty = 0;
      $cart = session($cart_id);
      $keeper = [];

      foreach ($cart as $item) {

        if (is_array($item)) {
          $variant_check = false;
          if (!empty($item['variant']) && ($item['variant'] == $request->variant) && ($item['id'] == $request->key)) {
            $variant_check = true;
          } elseif (empty($request->variant) && $item['id'] == $request->key) {
            $variant_check = true;
          }

          if ($variant_check) {
            $str = '';
            if ($item['variations']) {
              foreach ($item['variations'] as $v) {
                if ($str != null) {
                  $str .= '-' . str_replace(' ', '', $v);
                } else {
                  $str .= str_replace(' ', '', $v);
                }
              }
            }

            if ($str != null) {

              $count = count(json_decode($product->variation));
              for ($i = 0; $i < $count; $i++) {

                if (json_decode($product->variation)[$i]->type == $str) {

                  $product_qty = json_decode($product->variation)[$i]->qty;
                }
              }
            } else {
              $product_qty = $product->current_stock;
            }

            $qty = $product_qty - $request->quantity;

            if ($product->product_type == 'physical' && $qty < 0) {
              return response()->json([
                'qty' => $qty,
                'product_type' => $product->product_type,
                'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
              ]);
            }
            $item['quantity'] = $request->quantity;
          }
          array_push($keeper, $item);
        }
      }
      session()->put($cart_id, $keeper);

      return response()->json([
        'qty_update' => 1,
        'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
      ], 200);
    } else {
      return response()->json([
        'upQty' => 'zeroNegative',
        'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
      ]);
    }
  }
  public function extra_dis_calculate($cart, $price)
  {

    if ($cart['ext_discount_type'] == 'percent') {
      $price_discount = ($price / 100) * $cart['ext_discount'];
    } else {
      $price_discount = $cart['ext_discount'];
    }

    return $price_discount;
  }
  public function coupon_discount(Request $request)
  {
    $cart_id = session('current_user');
    $user_id = 0;
    $user_type = 'wc';
    if (Str::contains(session('current_user'), 'sc')) {
      $user_id = explode('-', session('current_user'))[1];
      $user_type = 'sc';
    }
    if ($user_id != 0) {
      $couponLimit = Order::where('customer_id', $user_id)
        ->where('customer_type', 'customer')
        ->where('coupon_code', $request['coupon_code'])->count();

      $coupon = Coupon::where(['code' => $request['coupon_code']])
        ->where('limit', '>', $couponLimit)
        ->where('status', '=', 1)
        ->whereDate('start_date', '<=', now())
        ->whereDate('expire_date', '>=', now())->first();
    } else {
      $coupon = Coupon::where(['code' => $request['coupon_code']])
        ->where('status', '=', 1)
        ->whereDate('start_date', '<=', now())
        ->whereDate('expire_date', '>=', now())->first();
    }

    $carts = session($cart_id);
    $total_product_price = 0;
    $product_discount = 0;
    $product_tax = 0;
    $ext_discount = 0;

    if ($coupon != null) {
      if ($carts != null) {
        foreach ($carts as $cart) {
          if (is_array($cart)) {
            $product = DB::table('seller_products')->where('id',$cart['id'])->first();
            $total_product_price += $cart['price'] * $cart['quantity'];
            $product_discount += $cart['discount'] * $cart['quantity'];
            $product_tax += Helpers::tax_calculation($cart['price'], $product['tax'], $product['tax_type']) * $cart['quantity'];
          }
        }
        if ($total_product_price >= $coupon['min_purchase']) {
          if ($coupon['discount_type'] == 'percentage') {

            $discount = (($total_product_price / 100) * $coupon['discount']) > $coupon['max_discount'] ? $coupon['max_discount'] : (($total_product_price / 100) * $coupon['discount']);
          } else {
            $discount = $coupon['discount'];
          }
          if (isset($carts['ext_discount_type'])) {
            $ext_discount = $this->extra_dis_calculate($carts, $total_product_price);
          }
          $total = $total_product_price - $product_discount + $product_tax - $discount - $ext_discount;
          //return $total;
          if ($total < 0) {
            return response()->json([
              'coupon' => "amount_low",
              'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
            ]);
          }

          $cart = session($cart_id, collect([]));
          $cart['coupon_code'] = $request['coupon_code'];
          $cart['coupon_discount'] = $discount;
          $cart['coupon_title'] = $coupon->title;
          $request->session()->put($cart_id, $cart);

          return response()->json([
            'coupon' => 'success',
            'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
          ]);
        }
      } else {
        return response()->json([
          'coupon' => 'cart_empty',
          'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
        ]);
      }

      return response()->json([
        'coupon' => 'coupon_invalid',
        'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
      ]);
    }

    return response()->json([
      'coupon' => 'coupon_invalid',
      'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
    ]);
  }
  public function update_discount(Request $request)
  {
    $cart_id = session('current_user');
    if ($request->type == 'percent' && $request->discount < 0) {
      Toastr::error(\App\CPU\translate('Extra_discount_can_not_be_less_than_0_percent'));
      return response()->json([
        'extra_discount' => "amount_low",
        'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
      ]);
    } elseif ($request->type == 'percent' && $request->discount > 100) {
      Toastr::error(\App\CPU\translate('Extra_discount_can_not_be_more_than_100_percent'));
      return response()->json([
        'extra_discount' => "amount_low",
        'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
      ]);
    }


    $user_id = 0;
    $user_type = 'wc';
    if (Str::contains(session('current_user'), 'sc')) {
      $user_id = explode('-', session('current_user'))[1];
      $user_type = 'sc';
    }

    $cart = session($cart_id, collect([]));
    if ($cart != null) {
      $total_product_price = 0;
      $product_discount = 0;
      $product_tax = 0;
      $ext_discount = 0;
      $coupon_discount = $cart['coupon_discount'] ?? 0;

      foreach ($cart as $ct) {
        if (is_array($ct)) {
          $product = DB::table('seller_products')->where('id',$ct['id'])->first();
          $total_product_price += $ct['price'] * $ct['quantity'];
          $product_discount += $ct['discount'] * $ct['quantity'];
          $product_tax += Helpers::tax_calculation($ct['price'], $product['tax'], $product['tax_type']) * $ct['quantity'];
        }
      }
      
      if ($request->type == 'percent') {
        $ext_discount = ($total_product_price / 100) * $request->discount;
      } else {
        $ext_discount = $request->discount;
      }
      $total = $total_product_price - $product_discount + $product_tax - $coupon_discount - $ext_discount;
      if ($total < 0) {
        return response()->json([
          'extra_discount' => "amount_low",
          'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
        ]);
      } else {
        $cart['ext_discount'] = $request->type == 'percent' ? $request->discount : BackEndHelper::currency_to_usd($request->discount);
        $cart['ext_discount_type'] = $request->type;
        session()->put($cart_id, $cart);

        return response()->json([
          'extra_discount' => "success",
          'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
        ]);
      }
    } else {
      return response()->json([
        'extra_discount' => "empty",
        'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
      ]);
    }
  }
  public function get_customers(Request $request)
  {
    $key = explode(' ', $request['q']);
    $data = DB::table('users')
      ->where(function ($q) use ($key) {
        foreach ($key as $value) {
          $q->orWhere('f_name', 'like', "%{$value}%")
            ->orWhere('l_name', 'like', "%{$value}%")
            ->orWhere('phone', 'like', "%{$value}%");
        }
      })
      ->whereNotNull(['f_name', 'l_name', 'phone'])
      ->limit(8)
      ->get([DB::raw('id,IF(id <> "0", CONCAT(f_name, " ", l_name, " (", phone ,")"),CONCAT(f_name, " ", l_name)) as text')]);

    //$data[] = (object)['id' => false, 'text' => 'walk_in_customer'];

    return response()->json($data);
  }

  public function place_order(Request $request)
  {
    $seller_id = auth('seller')->user()->id;
    $amount = $request->amount;
    $cart_id = session('current_user');
    $user_id = 0;
    $user_type = 'wc';
    if (Str::contains(session('current_user'), 'sc')) {
      $user_id = explode('-', session('current_user'))[1];
      $user_type = 'sc';
    }
    if (session()->has($cart_id)) {
      if (count(session()->get($cart_id)) < 1) {
        Toastr::error(\App\CPU\translate('cart_empty_warning'));
        return back();
      }
    } else {
      Toastr::error(\App\CPU\translate('cart_empty_warning'));
      return back();
    }
    if ($amount <= 0) {
      Toastr::error(\App\CPU\translate('cart_empty_warning'));
      return back();
    }

    $cart = session($cart_id);
    $total_tax_amount = 0;
    $product_price = 0;
    $order_details = [];

    $order_id = 100000 + Order::all()->count() + 1;
    if (Order::find($order_id)) {
      $order_id = Order::orderBy('id', 'DESC')->first()->id + 1;
    }

    $product_subtotal = 0;


    $gpv = 0;
    $gbv = 0;
    $g_store_bonus = 0;
    $g_ref_bonus = 0;
    $g_store_ref = 0;

    foreach ($cart as $c) {


      $product = DB::table('seller_products')->where('id',$c['id'])->first();


      $gpv += ($product->pv * $c['quantity']);
      $gbv += ($product->bv * $c['quantity']);
      $g_store_bonus += ($product->store_bonus * $c['quantity']);
      $g_ref_bonus += ($product->reference_bonus * $c['quantity']);
      $g_store_ref += ($product->store_reference * $c['quantity']);
    }



    //update pv and bv of customer
    $cus = DB::connection('mysql2')->table('users')->where('username', session('cus_name'))->first();
    $total_pv = $cus->pv += $gpv;
    $total_bv = $cus->bv += $gbv;
    DB::connection('mysql2')->table('users')->where('username', session('cus_name'))->update([
      'pv' => $total_pv,
      'bv' => $total_bv,
    ]);

	$seller = auth('seller')->user();
    $franchise = DB::connection('mysql2')->table('users')
    ->where('membership_id', 2)
    ->where('username', $seller->dds_username)
    ->first();
	  
    if(!$franchise){
		//update store bonus of store
		$get_store = DB::connection('mysql')->table('sellers')->where('id', $seller_id)->first();
		$get_store_ = DB::connection('mysql2')->table('users')->where('email', $get_store->email)->first();
		$total_store_bonus =  $get_store_->store_bonus + $g_store_bonus;
		DB::connection('mysql2')->table('users')->where('email', $get_store->email)->update([
		  'store_bonus' => $total_store_bonus
		]);



		//update store reference bonus 
		$u = DB::connection('mysql2')->table('users')->where('id', $get_store_->ref_id)->first();
		$total_store_ref = $u->store_reference += $g_store_ref;
		DB::connection('mysql2')->table('users')->where('id', $get_store_->ref_id)->update([
		  'store_reference' => $total_store_ref
		]);

	}

    //update customer reference bonus
    $cus_ref = DB::connection('mysql2')->table('users')->where('id', $cus->ref_id)->first();
    $total_ref_bouns = $cus_ref->reference_bonus += $g_ref_bonus;
    DB::connection('mysql2')->table('users')->where('id', $cus->ref_id)->update([
      'reference_bonus' => $total_ref_bouns
    ]);





    //update currrent balance
    $this->update_customer_balance($cus, $gbv);
    $store_name_ = DB::connection('mysql')->table('shops')->where('seller_id', $seller_id)->first();
    $this->update_cus_ref_balance($cus, $g_ref_bonus, $store_name_);
    $this->cus_ref_statements($cus, $cus_ref, $gpv, $gbv, $g_ref_bonus, $store_name_);

  
    if(!$franchise){

      $this->update_store_balance($get_store_, $g_store_bonus);
      $this->update_store_ref_balance($get_store_, $g_store_ref, $store_name_);
      $this->store_ref_statements($get_store_, $store_name_, $g_store_bonus, $g_store_ref);
    }



    // generate statements 


    $u_id = User::where('name', session('cus_name'))->first();
    $city_ref = 0;
    $shipping_expense = 0;
    $office_expense = 0;
    $event_expense = 0;
    $fb = 0;
    $frb = 0;
    foreach ($cart as $c) {
      if (is_array($c)) {
        $discount_on_product = 0;
        $product_subtotal = ($c['price']) * $c['quantity'];
        $discount_on_product += ($c['discount'] * $c['quantity']);

        $product = DB::table('seller_products')->where('id',$c['id'])->first();
        $city_ref += ($product->city_ref_bonus*$c['quantity']);
        $shipping_expense += ($product->shipping_expense*$c['quantity']);
        $office_expense += ($product->office_expense*$c['quantity']);
        $event_expense += ($product->event_expense*$c['quantity']);
        $fb += ($product->franchise_bonus*$c['quantity']);
        $frb += ($product->franchise_ref_bonus*$c['quantity']);
     
        $promo = 0;
        if ($product) {
          if($product->user_promo != 0){
            if($product->user_promo_expiry >= date('Y-m-d')){
              $promo = $product->user_promo;
              $main_uer = DB::connection('mysql2')->table('users')->where('username', session('cus_name'))->first();
              DB::connection('mysql2')->table('users')->where('username', session('cus_name'))->update([
                'promo' => $main_uer->promo += ($product->user_promo * $c['quantity']),
                'balance' => $main_uer->balance += ($product->user_promo * $c['quantity']),
              ]);
              DB::connection('mysql2')->table('transactions')->insert([
                'user_id' => $main_uer->id,
                'amount' => ($product->user_promo * $c['quantity']),
                'trx_type' => '+',
                'post_balance' => $main_uer->balance,
                'remark' =>'user_promo',
                'details' =>  ($product->user_promo * $c['quantity']) . ' PKR Promo has been credited into your ' . $cus->username . ' account because of purchasing "'.$product->name.'"'
              ]);
            }
          }

          $price = $c['price'];
          $product = SellerProducts::find($c['id']);

          //$product = Helpers::product_data_formatting($product);
          $or_d = [
            'order_id' => $order_id,
            'product_id' => $product->product_id,
            'product_details' => $product,
            'qty' => $c['quantity'],
            'price' => $price,
            'seller_id' => $product->seller_id,
            'tax' => Helpers::tax_calculation($price, $product->tax, $product->tax_type) * $c['quantity'],
            'discount' => $c['discount'] * $c['quantity'],
            'discount_type' => 'discount_on_product',
            'delivery_status' => 'delivered',
            'payment_status' => 'paid',
            'variant' => $c['variant'],
            'variation' => json_encode($c['variations']),
            'created_at' => now(),
            'updated_at' => now(),
            'promo' => $promo
          ];
          $total_tax_amount += $or_d['tax'] * $c['quantity'];
          $product_price += $product_subtotal - $discount_on_product;
          $order_details[] = $or_d;

          if ($c['variant'] != null) {
            $type = $c['variant'];
            $var_store = [];

            foreach (json_decode($product->variation, true) as $var) {
              if ($type == $var['type']) {
                $var['qty'] -= $c['quantity'];
              }
              array_push($var_store, $var);
            }
            DB::table('seller_products')->where(['id' => $product->id])->update([
              'variation' => json_encode($var_store),
            ]);
          }

          if ($product->product_type == 'physical') {
            DB::table('seller_products')->where(['id' => $product->id])->update([
              'current_stock' => $product->current_stock - $c['quantity']
            ]);
          }

          DB::table('order_details')->insert($or_d);
        }
      }
    }
    


    $total_price = $product_price;
    if (isset($cart['ext_discount'])) {
      $extra_discount = $cart['ext_discount_type'] == 'percent' && $cart['ext_discount'] > 0 ? (($total_price * $cart['ext_discount']) / 100) : $cart['ext_discount'];
      $total_price -= $extra_discount;
    }
    $or = [
      'id' => $order_id,
      'customer_id' => $u_id->id,
      'customer_type' => 'customer',
      'payment_status' => 'paid',
      'order_status' => 'delivered',
      'seller_id' => auth('seller')->id(),
      'seller_is' => 'seller',
      'payment_method' => $request->type,
      'order_type' => 'POS',
      'checked' => 1,
      'extra_discount' => $cart['ext_discount'] ?? 0,
      'extra_discount_type' => $cart['ext_discount_type'] ?? null,
      'order_amount' => BackEndHelper::currency_to_usd($request->amount),
      'discount_amount' => $cart['coupon_discount'] ?? 0,
      'coupon_code' => $cart['coupon_code'] ?? null,
      'created_at' => now(),
      'updated_at' => now(),
    ];
    DB::table('orders')->insertGetId($or);


    
    
    //generate city referernce with statement
    $this->city_reference($city_ref,$store_name_, $seller_id);

    //franchise_bonus with statement
    if($franchise) {
      $this->franchise($franchise,$seller,$fb,$frb, $store_name_, $seller_id);
    }
    
    //generate purchase statement
    $this->purchase_statement($order_id, $cus->id, $store_name_);
 

    $aw = DB::connection('mysql2')->table('admin_wallets')->where('id', 1)->first();
    DB::connection('mysql2')->table('admin_wallets')->where('id', 1)->update([
      'shipping_expense' => $aw->shipping_expense+=$shipping_expense,
      'office_expense' => $aw->office_expense+=$office_expense,
      'event_expense' => $aw->event_expense+=$event_expense,
    ]);
    session()->forget($cart_id);
    session()->forget('cus_name');

    session(['last_order' => $order_id]);
    Toastr::success(\App\CPU\translate('order_placed_successfully'));

    return back();
  }

  private function city_reference($city_ref, $store_name_, $seller_id){
    $user = DB::connection('mysql')->table('users')->where('id', auth('customer')->id())->first();
    $main_user = DB::connection('mysql2')->table('users')->where('username', $user->name)->first();
    $frenchises = DB::connection('mysql2')->table('users')->where('membership_id', 2)->get();
    
    if($main_user->membership_id == 1){
    foreach ($frenchises as $frenchise) { 
      $array = json_decode(($frenchise->address), true);
      $city = $array['city'];
      if($user->city == $city){
        DB::connection('mysql2')->table('users')->where('id', $frenchise->id)->update([
          'city_reference' => $frenchise->city_reference+=$city_ref,
          'balance' => $frenchise->balance+=$city_ref
        ]);
		if($city_ref != 0){
			DB::connection('mysql2')->table('transactions')->insert([
			  'user_id' => $frenchise->id,
			  'amount' => $city_ref,
			  'trx_type' => '+',
			  'remark' => 'city_reference',
			  'post_balance' => $frenchise->balance,
			  'details' =>  $city_ref . ' PKR City Reference bonus has been credited into your ' . $frenchise->username . ' account from ' . $store_name_->name . ' - store id: ' . $seller_id
			]);
		  }
      } else {
        $aw = DB::connection('mysql2')->table('admin_wallets')->where('id', 1)->first();
        DB::connection('mysql2')->table('admin_wallets')->where('id', 1)->update([
          'city_ref' => $aw->city_ref+=$city_ref,
        ]);
      }}
    }
  }

  private function franchise($franchise,$seller,$fb,$frb, $store_name_, $seller_id){
    if($franchise) {
      $franchise_ref = DB::connection('mysql2')->table('users')
      ->where('id', $franchise->ref_id)
      ->first();
      $dsp_check = DB::connection('mysql2')->table('users')->where('id', $franchise_ref->id)->where('username', 'like', '%dsp%')->first();
   
      
      DB::connection('mysql2')->table('users')
      ->where('membership_id', 2)
      ->where('username', $seller->dds_username)
      ->update([
        'franchise_bonus'=>$franchise->franchise_bonus+=$fb,
        'balance' => $franchise->balance+=$fb
      ]);

		if($fb != 0){
      DB::connection('mysql2')->table('transactions')->insert([
        'user_id' => $franchise->id,
        'amount' => $fb,
        'trx_type' => '+',
        'remark' => 'franchise_bonus',
        'post_balance' => $franchise->balance,
        'details' =>  $fb . ' PKR franchise bonus has been credited into your ' . $franchise->username . ' account from ' . $store_name_->name . ' - franchise id: ' . $seller_id
      ]);
		}

      if(!$dsp_check) {
        DB::connection('mysql2')->table('users')
        ->where('id', $franchise->ref_id)
        ->update([
          'franchise_ref_bonus'=>$franchise_ref->franchise_ref_bonus+=$frb,
          'balance' => $franchise_ref->balance+=$frb
        ]);
if($frb != 0){
        DB::connection('mysql2')->table('transactions')->insert([
          'user_id' => $franchise_ref->id,
          'amount' => $frb,
          'trx_type' => '+',
          'remark' => 'franchise_ref_bonus',
          'post_balance' => $franchise_ref->balance,
          'details' =>  $frb . ' PKR franchise ref bonus has been credited into your ' . $franchise->username . ' account from ' . $store_name_->name . ' - franchise id: ' . $seller_id
        ]);
}
      } else {
        $dsp_user = DB::connection('mysql2')->table('users')->where('id', $dsp_check->ref_id)->first();
      
        DB::connection('mysql2')->table('users')
        ->where('id', $dsp_user->id)
        ->update([
          'franchise_ref_bonus'=>$dsp_user->franchise_ref_bonus+=$fb,
          'balance' => $dsp_user->balance+=$frb
        ]);
if($frb != 0){
        DB::connection('mysql2')->table('transactions')->insert([
          'user_id' => $dsp_user->id,
          'amount' => $frb,
          'trx_type' => '+',
          'remark' => 'franchise_ref_bonus',
          'post_balance' => $dsp_user->balance,
          'details' =>  $frb . ' PKR franchise ref bonus has been credited into your ' . $franchise->username . ' account from ' . $store_name_->name . ' - franchise id: ' . $seller_id
        ]);
      } }
    }
  }

  private function update_customer_balance($cus, $gbv)
  {
    $update_cus_bal = $cus->balance += $gbv;
    DB::connection('mysql2')->table('users')->where('username', session('cus_name'))->update([
      'balance' => $update_cus_bal
    ]);
  }

  private function update_cus_ref_balance($cus, $g_ref_bonus, $store)
  {
    $dsp_cus_ref = DB::connection('mysql2')->table('users')->where('id', $cus->ref_id)->where('username', 'like', '%dsp%')->first();
    if (!empty($dsp_cus_ref)) {

      //update balance of ref_id of dsp
      $cus_reff = DB::connection('mysql2')->table('users')->where('id', $dsp_cus_ref->ref_id)->first();
      $cus_ref_bal = $cus_reff->balance += $g_ref_bonus;
      DB::connection('mysql2')->table('users')->where('id', $dsp_cus_ref->ref_id)->update([
        'balance' => $cus_ref_bal
      ]);
    } else {
      //update reference balance
      $cus_reff = DB::connection('mysql2')->table('users')->where('id', $cus->ref_id)->first();
      $update_cus_ref = $cus_reff->balance += $g_ref_bonus;
      DB::connection('mysql2')->table('users')->where('id', $cus->ref_id)->update([
        'balance' => $update_cus_ref
      ]);
    }
  }

  private function update_store_balance($store, $g_store_bonus)
  {
    $update_store_bonus = $store->balance += $g_store_bonus;
    DB::connection('mysql2')->table('users')->where('email', $store->email)->update([
      'balance' => $update_store_bonus
    ]);
  }

  private function update_store_ref_balance($gStore, $g_store_ref, $store)
  {
    $dsp_store_ref = DB::connection('mysql2')->table('users')->where('id', $gStore->ref_id)->where('username', 'like', '%dsp%')->first();

    if (!empty($dsp_store_ref)) {
      //move dsp balance to its ref_id
      $store_reff = DB::connection('mysql2')->table('users')->where('id', $dsp_store_ref->ref_id)->first();
      $store_ref_bal = $store_reff->balance += $g_store_ref;

      DB::connection('mysql2')->table('users')->where('id', $dsp_store_ref->ref_id)->update([
        'balance' => $store_ref_bal
      ]);
    } else {
      //update store ref_id balance 
      $store_reff = DB::connection('mysql2')->table('users')->where('id', $gStore->ref_id)->first();
      $store_ref_bal = $store_reff->balance += $g_store_ref;
      DB::connection('mysql2')->table('users')->where('id', $gStore->ref_id)->update([
        'balance' => $store_ref_bal
      ]);
    }
  }

  private function cus_ref_statements($cus, $cus_ref, $gpv, $gbv, $g_ref_bonus, $store)
  {


    DB::connection('mysql2')->table('transactions')->insert([
      'user_id' => $cus->id,
      'trx_type' => '+',
      'remark' => 'pv_bonus',
      'details' => $gpv . ' PV bonus has been credited into your ' . $cus->username . ' account from ' . $store->name . ' - store id: ' . $store->seller_id
    ]);

    DB::connection('mysql2')->table('transactions')->insert([
      'user_id' => $cus->id,
      'amount' => $gbv,
      'trx_type' => '+',
      'remark' => 'bv_bonus',
      'post_balance' => $cus->balance,
      'details' =>  $gbv . ' PKR BV bonus has been credited into your ' . $cus->username . ' account from ' . $store->name . ' - store id: ' . $store->seller_id
    ]);



    $array = json_decode(($cus->address), true);
    $city = $array['city'];


    $dsp_check = DB::connection('mysql2')->table('users')->where('id', $cus->ref_id)->where('username', 'like', '%dsp%')->first();
    $dsp_user = DB::connection('mysql2')->table('users')->where('id', $cus_ref->ref_id)->first();
    if (!empty($dsp_check)) {
      DB::connection('mysql2')->table('transactions')->where('username', session('cus_name'))->insert([
        'user_id' => $cus_ref->ref_id,
        'amount' => $g_ref_bonus,
        'trx_type' => '+',
        'remark' => 'reference_bonus',
        'post_balance' => $dsp_user->balance,
        'details' => 'Your team member ' . $cus->firstname . ' ' . $cus->lastname . ' "' . $cus->username . '" has made a purchase from ' . $store->name . ' Store ID: "' . $store->seller_id . '" in "City": ' . $city . ' city, from which you have received ' . $g_ref_bonus . ' PKR Reference bonus in your wallet.'

     
      ]);
    } else {
      DB::connection('mysql2')->table('transactions')->where('username', session('cus_name'))->insert([
        'user_id' => $cus->ref_id,
        'amount' => $g_ref_bonus,
        'trx_type' => '+',
        'post_balance' => $cus_ref->balance + $g_ref_bonus,

        'remark' => 'reference_bonus',
        'details' => 'Your team member ' . $cus->firstname . ' ' . $cus->lastname . ' "' . $cus->username . '" has made a purchase from ' . $store->name . ' Store ID: "' . $store->seller_id . '" in "City": ' . $city . ' city, from which you have received ' . $g_ref_bonus . ' PKR Reference bonus in your wallet.'


      ]);
    }
  }

  private function store_ref_statements($store, $store_name_, $g_store_bonus, $g_store_ref)
  {

    

    DB::connection('mysql2')->table('transactions')->where('email', $store->email)->insert([
      'user_id' => $store->id,
      'amount' => $g_store_bonus,
      'trx_type' => '+',
      'post_balance' => $store->balance,
      'remark' => 'store_bonus',
      'details' => $g_store_bonus . ' PKR Store bonus has been credited into your ' . $store->username . ' account from ' . $store_name_->name . ' - store id: ' . $store_name_->seller_id

    ]);

    $dsp_store_ref = DB::connection('mysql2')->table('users')->where('id', $store->ref_id)->where('username', 'like', '%dsp%')->first();
    
    if (!empty($dsp_store_ref)) {
      //$store_r = DB::connection('mysql2')->table('users')->where('id', $store->ref_id)->first();
      $store_reff = DB::connection('mysql2')->table('users')->where('id', $dsp_store_ref->ref_id)->first();
     
      $array = json_decode(($store_reff->address), true);
      $city = $array['city'];
      DB::connection('mysql2')->table('transactions')->insert([
        'user_id' => $store_reff->id,
        'amount' => $g_store_ref,
        'trx_type' => '+',
        'post_balance' => $store_reff->balance,
        'remark' => 'store_reference',
        'details' => 'Your team member ' . $store->firstname . ' ' . $store->lastname . ' "' . $store->username . '" has ' . $store_name_->name . ' Store ID: "' . $store_name_->seller_id . '" in "City": ' . $city . ' city, from which you have received ' . $g_store_ref . ' PKR Store Reference bonus in your wallet.'

      ]);
    } else {
      $store_r = DB::connection('mysql2')->table('users')->where('id', $store->ref_id)->first();
      $array = json_decode(($store_r->address), true);
      $city = $array['city'];
      DB::connection('mysql2')->table('transactions')->insert([
        'user_id' => $store_r->id,
        'amount' => $g_store_ref,
        'trx_type' => '+',
        'post_balance' => $store_r->balance,
        'remark' => 'store_reference',
        'details' => 'Your team member ' . $store->firstname . ' ' . $store->lastname . ' "' . $store->username . '" has ' . $store_name_->name . ' Store ID: "' . $store_name_->seller_id . '" in "City": ' . $city . ' city, from which you have received ' . $g_store_ref . ' PKR Store Reference bonus in your wallet.'
  
     ]);
    } 
  }

  private function purchase_statement($order_id, $cus_id, $store)
  {
    $o = Order::where('id', $order_id)->first();
    DB::connection('mysql2')->table('transactions')->insert([
      'user_id' => $cus_id,
      'amount' => $o->order_amount,
      'trx_type' => '-',
      'remark' => 'customer_order_generated',
      'details' => 'You have purchased ' . $o->order_amount . ' PKR of products from ' . $store->name . ' - store id: ' . $store->seller_id . ' and your order no. is ' . $o->id

    ]);
  }


  public function store_keys(Request $request)
  {
    session()->put($request['key'], $request['value']);
    return response()->json('', 200);
  }
  public function get_cart_ids(Request $request)
  {
    $cart_id = session('current_user');
    $user_id = 0;
    $user_type = 'wc';
    if (Str::contains(session('current_user'), 'sc')) {
      $user_id = explode('-', session('current_user'))[1];
      $user_type = 'sc';
    }
    $cart = session($cart_id);
    $cart_keeper = [];
    if (session()->has($cart_id) && count($cart) > 0) {
      foreach ($cart as $cartItem) {
        array_push($cart_keeper, $cartItem);
      }
    }
    session()->put(session('current_user'), $cart_keeper);
    $user_id = explode('-', session('current_user'))[1];
    $current_customer = '';
    //if(explode('-',session('current_user'))[0]=='wc')
    //{
    //    $current_customer = 'Walking Customer_';
    //}else{
    //$current =User::where('id',$user_id)->first();
    $current = DB::connection('mysql2')->table('users')->where('username', session('cus_name'))->first();
    $current_customer = $current->firstname . ' ' . $current->lastname . ' (' . $current->mobile . ')';
    session()->put('name', $current->firstname . ' ' . $current->lastname);
    session()->put('phone', $current->mobile);
    //}
    return response()->json([
      'current_user' => session('current_user'), 'cart_nam' => session('cart_name') ?? '',
      'current_customer' => $current_customer,
      'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
    ]);
  }
  public function clear_cart_ids()
  {
    session()->forget('cart_name');
    session()->forget(session('current_user'));
    session()->forget('current_user');

    return redirect()->route('seller.pos.index');
  }
  public function remove_discount(Request $request)
  {
    $cart_id = ($request->user_id != 0 ? 'sc-' . $request->user_id : 'wc-' . rand(10, 1000));
    if (!in_array($cart_id, session('cart_name') ?? [])) {
      session()->push('cart_name', $cart_id);
    }

    $cart = session(session('current_user'));

    $cart_keeper = [];
    if (session()->has(session('current_user')) && count($cart) > 0) {
      foreach ($cart as $cartItem) {

        array_push($cart_keeper, $cartItem);
      }
    }
    if (session('current_user') != $cart_id) {
      $temp_cart_name = [];
      foreach (session('cart_name') as $cart_name) {
        if ($cart_name != session('current_user')) {
          array_push($temp_cart_name, $cart_name);
        }
      }
      session()->put('cart_name', $temp_cart_name);
    }
    session()->put('cart_name', $temp_cart_name);
    session()->forget(session('current_user'));
    session()->put($cart_id, $cart_keeper);
    session()->put('current_user', $cart_id);
    $user_id = explode('-', session('current_user'))[1];
    $current_customer = '';
    if (explode('-', session('current_user'))[0] == 'wc') {
      $current_customer = 'Walking Customer';
    } else {
      $current = User::where('id', $user_id)->first();
      $current_customer = $current->f_name . ' ' . $current->l_name . ' (' . $current->phone . ')';
    }

    return response()->json([
      'cart_nam' => session('cart_name'),
      'current_user' => session('current_user'),
      'current_customer' => $current_customer,
      'view' => view('seller-views.pos._cart', compact('cart_id'))->render()
    ]);
  }
  public function new_cart_id(Request $request)
  {
    $cart_id = 'wc-' . rand(10, 1000);
    session()->put('current_user', $cart_id);
    if (!in_array($cart_id, session('cart_name') ?? [])) {
      session()->push('cart_name', $cart_id);
    }

    return redirect()->route('seller.pos.index');
  }
  public function change_cart(Request $request)
  {

    session()->put('current_user', $request->cart_id);

    return redirect()->route('seller.pos.index');
  }
  public function customer_store(Request $request)
  {
    session()->forget('name');
    session()->forget('phone');
    $request->validate([
      'dds_username' => 'required',
    ]);
    $main_check = DB::connection('mysql2')->table('users')->where('username', $request->dds_username)->first();

    if (!empty($main_check)) {
      $check = DB::connection('mysql')->table('users')->where('name', $request->dds_username)->first();
      if (empty($check)) {

        //return 0;
        $user = DB::connection('mysql')->table('users')->insert([
          'name' => $request->dds_username,
          'f_name' => $main_check->firstname,
          'l_name' => $main_check->lastname,
          'email' => $main_check->email,
          'password' => $main_check->password,
          'phone' => $main_check->mobile,

        ]);
        Toastr::success(\App\CPU\translate('customer added successfully'));
        return back();
      } else {
        Toastr::success(\App\CPU\translate('customer found successfully'));
        return back();
      }
    }
  }

  public function dds_search(Request $request)
  {
    //return $request;

    session()->forget('cus_name');
    $user = new User;
    $user->setConnection('mysql2');
    $dds_user = $user->where('username', $request->dds_name)->first();
    if (!$dds_user) {
      return 1;
    } else {
      session()->put(['cus_name' => $request->dds_name]);
      return $dds_user;
    }
  }
}
