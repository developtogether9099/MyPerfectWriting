<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\PaymentPlatform;
use App\Models\Promocode;
use Zorb\Promocodes\Facades\Promocodes;
use Zorb\Promocodes\Exceptions\PromocodeAlreadyUsedByUserException;
use Zorb\Promocodes\Exceptions\PromocodeDoesNotExistException;
use Zorb\Promocodes\Exceptions\PromocodeExpiredException;
use Zorb\Promocodes\Exceptions\PromocodeNoUsagesLeftException;
use App\Models\User;
use App\Models\Admin\Order;
use DataTables;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Models\PrepaidPlan;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use App\Mail\PlaceOrder;
use App\Mail\UpdateOrder;
use App\Mail\CompleteOrder;
use Storage;

class OrderController extends Controller
{
    protected $apiContext;
    private $client;

    public function __construct()
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $paypalConfig = config('paypal');
        //$this->apiContext = new ApiContext(
           // new OAuthTokenCredential(
            //    $paypalConfig['client_id'],
              //  $paypalConfig['secret']
            //)
        //);/

        // $this->client = new PayPalHttpClient($this->environment());
    }

    private function environment()
    {
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_SECRET');

        return new SandboxEnvironment($clientId, $clientSecret);
    }

    public function place_order(Request $request)
    {
        session()->forget('total_amount');
        $orders = DB::table('orders')->count();
        $number = $orders;
        $number += 1;
        $service = DB::table('services')->where('name', $request->service_id)->first();
        $f = array();
        $p = array();




        $premium = 0.00;

        $price = format_amount($service->price)['amount'];
        if ($request->planType == 'premium') {
            $package = DB::table('packages')->where('cost', '<>', 0)->where('status', 1)->first();
            $premium = format_amount($package->cost)['amount'];
            $price = format_amount($package->cost)['amount'];
        } else {
            $package = DB::table('packages')->where('cost', 0)->where('status', 1)->first();
        }

        DB::table('orders')->insert([
            'number' => 'ORD-' . sprintf("%06d", $number),
            'title' => $request->title,
            'formatting' => $request->formatting2 == 'other' ? $request->formatting : $request->formatting2,
            'instruction' => $request->specifications,
            'customer_id' => auth()->user()->id,
            'service_id' => $service->id,
            'work_level_id' => $request->work_level_id,
            'urgency_id' => 1,
            'dead_line' => $request->deadline_date,
            'deadline_time' => date("h:i A", strtotime($request->deadline_time)),
            'unit_name' => 'Pages',
            'base_price' => $price,
            'work_level_price' => 0,
            'urgency_price' => 0,
            'unit_price' => $price,
            'quantity' => $request->qty,
            'amount' => $price * $request->qty,
            'sub_total' => $price * $request->qty,
            'discount' => 0,
            'total' => $price * $request->qty,
            'staff_payment_amount' => 1,
            'time_format' => $request->urgency_id,
            'package' => $package->name,
            'package_amount' => $premium,
            'spacing_type' => 'double',
            'work_level_percentage' => 0,
            'urgency_percentage' => 0,
            'staff_id' => 0,
            'order_status_id' => 1,
            'currency' => currency(),
            'file' => 0,
            'file_path' => 0,
            'course' => $request->course,
            'sources' => $request->sources,
            'created_at' => $request->today
        ]);

        $order = DB::table('orders')->where('customer_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            $path = 'user_files'; // Relative path to the storage directory

            foreach ($files as $file) {
                if ($file->isValid()) {
                    $filenameWithExt = $file->getClientOriginalName();
                    $file->storeAs($path, $filenameWithExt, 'public'); // Store the file in the public disk under the specified path

                   $filePath = $filenameWithExt;
                    $f[] = $filenameWithExt;
                    $p[] = $filePath;
                    DB::table('attachments')->insert([
                        'order_id' => $order->id,
                        'uploader_id' => auth()->user()->id,
                        'file' => $filenameWithExt,
                       'file_path' => 'https://portal.myperfectwriting.co.uk/public/user_files/' . $filePath,
                    ]);
                }
            }
        }
        $data['total'] = $order->total;
        session(['total_amount' => $data['total']]);
        session(['OID' => $order->id]);

        $sservice = DB::table('services')->where('id', $order->service_id)->first();
        $swork_level = DB::table('work_levels')->where('id', $order->work_level_id)->first();

		$user = auth()->user();
		$order_id = $order->id;
        //Mail::to(request('email'))->cc(auth()->user()->email)->send(new PlaceOrder($user, $order_id));
        //return ['status' => 200, 'order' => $order, 'total' => session('total_amount')];

        return response()->json([
            'status' => 200,
            'total' => $order->total,
            'title' => $order->title,
            'qty' => $order->quantity,
            'course' => $order->course,
            'sources' => $order->sources,
            'instruction' => $order->instruction,
            'formatting' => $order->formatting,
            'posted' => date('Y-m-d', strtotime($order->created_at)),
            'deadline_date' => $order->dead_line,
            'deadline_time' => $order->deadline_time,
            'service' => $sservice->name,
            'work_level' => $swork_level->name,
            'plan_type' => $package->name,
            'file_name' => $f,
            'file_path' => $p,
            'o_id' => $order->id
        ]);

        toastr()->success(__('Order has been successfully submitted, Please Select a Payment Gateway for Payment'));
        return view('user.checkout.select_payment_method', compact('order', 'data'));
    }

    public function order_details(Request $request)
    {
        session()->forget('OID');
        $order = DB::table('orders')->where('id', $request->id)->where('customer_id', auth()->user()->id)->first();
        $comments = DB::table('comments')->where('order_id', $order->id)->get();
        session(['total_amount' => $order->total]);
        session(['OID' => $order->id]);
        $conversations =  DB::table('conversations')->where('order_id', $order->id)->get();
        $sw =  DB::table('submitted_works')->where('order_id', $order->id)->get();
        $attachments =  DB::table('attachments')->where('order_id', $order->id)->get();
        return view('user.orders.order_details', compact('order', 'comments','attachments','conversations'));
    }

    protected function get_urgency_date($type, $value, $format = 'D, M j, Y')
    {
        $now = \Carbon\Carbon::now();

        $now = ($type == 'hours') ? $now->addHours($value) : $now->addDays($value);

        return $now->format($format);
    }

    public function my_orders(Request $request)
    {


        if ($request->ajax()) {
            $data = Order::where('customer_id', auth()->user()->id)
                ->where('payment_status', 1)
                ->latest()
                ->get();


            return Datatables::of($data)

                ->addColumn('order_id', function ($row) {
                    $order_id = '<a class="text-primary" href="' . route('user.order_details') . '?id=' . $row['id'] . '">' . ($row["id"]) . '</a>';
                    return $order_id;
                })
                ->addColumn('service', function ($row) {
                    $srvc = DB::table('services')->where('id', $row["service_id"])->first();
                    $service = $srvc->name;
                    return $service;
                })
                ->addColumn('posted', function ($row) {
                    $posted = '<span class="font-weight-bold">' . date('Y-m-d', strtotime($row['created_at'])) . '</span>'; //$row["created_at"];
                    return $posted;
                })
                ->addColumn('deadline', function ($row) {
                    $deadline = '<span class="font-weight-bold">' . date('Y-m-d', strtotime($row['dead_line'])) . ' ' . date('h:i:A', strtotime($row['deadline_time']))



                        . '</span>'; //$row["cred_at"];
                    return $deadline;
                })
                ->addColumn('status', function ($row) {
                    $status = DB::table('order_statuses')->where('id', $row["order_status_id"])->first();
                    if ($status) {

                        return $status->name;
                    } else {
                        return '';
                    }
                })
                ->addColumn('assigned', function ($row) {
                    $assigned = DB::table('writers')->where('id', $row["staff_id"])->first();
                    if ($assigned) {

                        return $assigned->name;
                    } else {
                        return 'unassigned';
                    }
                })

                ->rawColumns(['order_id', 'service', 'posted', 'deadline', 'status', 'assigned'])
                ->make(true);
        }


        return view('user.orders.my_orders');
    }


    public function my_completed_orders(Request $request)
    {


        if ($request->ajax()) {

            $data = Order::where('customer_id', auth()->user()->id)
                ->where('payment_status', 1)
                ->where('order_status_id', 5)
                ->latest()
                ->get();

            return Datatables::of($data)

                ->addColumn('order_id', function ($row) {
                    $order_id = '<a class="text-primary" href="' . route('user.order_details') . '?id=' . $row['id'] . '">' . ($row["id"]) . '</a>';
                    return $order_id;
                })
                ->addColumn('service', function ($row) {
                    $srvc = DB::table('services')->where('id', $row["service_id"])->first();
                    $service = $srvc->name;
                    return $service;
                })
                ->addColumn('posted', function ($row) {
                    $posted = '<span class="font-weight-bold">' . date('Y-m-d', strtotime($row['created_at'])) . '</span>'; //$row["created_at"];
                    return $posted;
                })
                ->addColumn('deadline', function ($row) {
                    $deadline = '<span class="font-weight-bold">' . date('Y-m-d', strtotime($row['dead_line'])) . ' ' . date('h:i:A', strtotime($row['deadline_time']))



                        . '</span>'; //$row["cred_at"];
                    return $deadline;
                })
                ->addColumn('status', function ($row) {
                    $status = DB::table('order_statuses')->where('id', $row["order_status_id"])->first();
                    if ($status) {

                        return $status->name;
                    } else {
                        return '';
                    }
                })
                ->addColumn('assigned', function ($row) {
                    $assigned = DB::table('writers')->where('id', $row["staff_id"])->first();
                    if ($assigned) {

                        return $assigned->name;
                    } else {
                        return 'unassigned';
                    }
                })

                ->rawColumns(['order_id', 'service', 'posted', 'deadline', 'status', 'assigned'])
                ->make(true);
        }
        return view('user.orders.my_orders');
    }


    public function my_inProcess_orders(Request $request)
    {


        if ($request->ajax()) {

            $data = Order::where('customer_id', auth()->user()->id)
                ->where('payment_status', 1)
                ->whereIn('order_status_id', [2, 3])
                ->latest()
                ->get();

            return Datatables::of($data)

                ->addColumn('order_id', function ($row) {
                    $order_id = '<a class="text-primary" href="' . route('user.order_details') . '?id=' . $row['id'] . '">' . ($row["id"]) . '</a>';
                    return $order_id;
                })
                ->addColumn('service', function ($row) {
                    $srvc = DB::table('services')->where('id', $row["service_id"])->first();
                    $service = $srvc->name;
                    return $service;
                })
                ->addColumn('posted', function ($row) {
                    $posted = '<span class="font-weight-bold">' . date('Y-m-d', strtotime($row['created_at'])) . '</span>'; //$row["created_at"];
                    return $posted;
                })
                ->addColumn('deadline', function ($row) {
                    $deadline = '<span class="font-weight-bold">' . date('Y-m-d', strtotime($row['dead_line'])) . ' ' . date('h:i:A', strtotime($row['deadline_time']))



                        . '</span>'; //$row["cred_at"];
                    return $deadline;
                })
                ->addColumn('status', function ($row) {
                    $status = DB::table('order_statuses')->where('id', $row["order_status_id"])->first();
                    if ($status) {

                        return $status->name;
                    } else {
                        return '';
                    }
                })
                ->addColumn('assigned', function ($row) {
                    $assigned = DB::table('writers')->where('id', $row["staff_id"])->first();
                    if ($assigned) {

                        return $assigned->name;
                    } else {
                        return 'unassigned';
                    }
                })

                ->rawColumns(['order_id', 'service', 'posted', 'deadline', 'status', 'assigned'])
                ->make(true);
        }


        return view('user.orders.my_orders');
    }

    public function my_requestedForRevision_orders(Request $request)
    {
        if ($request->ajax()) {

            $data = Order::where('customer_id', auth()->user()->id)
                ->where('payment_status', 1)
                ->where('order_status_id', 4)
                ->latest()
                ->get();

            return Datatables::of($data)

                ->addColumn('order_id', function ($row) {
                    $order_id = '<a class="text-primary" href="' . route('user.order_details') . '?id=' . $row['id'] . '">' . ($row["id"]) . '</a>';
                    return $order_id;
                })
                ->addColumn('service', function ($row) {
                    $srvc = DB::table('services')->where('id', $row["service_id"])->first();
                    $service = $srvc->name;
                    return $service;
                })
                ->addColumn('posted', function ($row) {
                    $posted = '<span class="font-weight-bold">' . date('Y-m-d', strtotime($row['created_at'])) . '</span>'; //$row["created_at"];
                    return $posted;
                })
                ->addColumn('deadline', function ($row) {
                    $deadline = '<span class="font-weight-bold">' . date('Y-m-d', strtotime($row['dead_line'])) . ' ' . date('h:i:A', strtotime($row['deadline_time']))



                        . '</span>'; //$row["cred_at"];
                    return $deadline;
                })
                ->addColumn('status', function ($row) {
                    $status = DB::table('order_statuses')->where('id', $row["order_status_id"])->first();
                    if ($status) {

                        return $status->name;
                    } else {
                        return '';
                    }
                })
                ->addColumn('assigned', function ($row) {
                    $assigned = DB::table('writers')->where('id', $row["staff_id"])->first();
                    if ($assigned) {

                        return $assigned->name;
                    } else {
                        return 'unassigned';
                    }
                })

                ->rawColumns(['order_id', 'service', 'posted', 'deadline', 'status', 'assigned'])
                ->make(true);
        }


        return view('user.orders.my_orders');
    }

	
	
    public function unpaid_orders(Request $request)
    {
        $orders = Order::where('customer_id', auth()->user()->id)->where('dead_line', '<>', null)->where('payment_status', 0)->orderBy('id', 'DESC')->paginate(10);

       

        return view('user.orders.unpaid_orders', compact('orders'));
    }

    public function edit_unpaid_order($id)
    {
        $order = DB::table('orders')->where('id', $id)->where('customer_id', auth()->user()->id)->where('payment_status', 0)->first();
	
        $services = DB::table('services')->where('id', '<>', $order->service_id)->get();
        $work_levels = DB::table('work_levels')->where('id', '<>', $order->work_level_id)->get();

        $packages = DB::table('packages')->where('status', 1)->get();
        $subjects = DB::table('subjects')->where('name', '<>', $order->course)->where('status', 1)->get();
        $citations = DB::table('citations')->where('name', '<>', $order->formatting)->where('status', 1)->get();

        $sservice = DB::table('services')->where('id', $order->service_id)->first();
        $swork_level = DB::table('work_levels')->where('id', $order->work_level_id)->first();
        $data['total'] = $order->total;
        session(['total_amount' => $data['total']]);
        session(['OID' => $order->id]);

        return view('user.orders.edit', compact('order', 'services', 'work_levels', 'sservice', 'swork_level', 'subjects', 'citations', 'packages'));
    }

    public function pay_now(Request $request)
    {
        $order = DB::table('orders')->where('customer_id', auth()->user()->id)->where('id', $request->id)->first();

        $sservice = DB::table('services')->where('id', $order->service_id)->first();
        $swork_level = DB::table('work_levels')->where('id', $order->work_level_id)->first();
        $data['total'] = $order->total;
        session(['total_amount' => $data['total']]);
        session(['OID' => $order->id]);

        $data['gateway_name'] = 'stripe';
        $data['publishable_key'] = env('STRIPE_KEY');
        return view('user.orders.pay_now', compact('order', 'data', 'sservice', 'swork_level'));
    }
    public function comment(Request $request)
    {
        $f = '';
        $p = '';
        if ($request->hasFile('file')) {
            $path = public_path('/user_files');

            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $f = $filenameWithExt;
            $p = asset('/user_files') . '/' . $filenameWithExt;
            $request->file->move($path, $filenameWithExt);
        }
        DB::table('comments')->insert([
            'order_id' => $request->o_id,
            'body' => $request->message,
            'user_id' => auth()->user()->id,
            'file' => $f,
            'file_path' => $p,
        ]);
        DB::table('orders')->where('id', $request->o_id)->update([
            'order_status_id' => 4,

        ]);
        toastr()->success(__('Message Sent successfully'));
        return redirect()->back();
    }



    public function apply_promo(Request $request)
    {
        if ($request->id != null) {
            $order = DB::table('orders')->where('id', $request->id)->first();
            session(['OID' => $order->id]);
        } else {
            $order = DB::table('orders')->where('id', session('OID'))->first();
        }

        //return response()->json(['error'=> 60]);
        if ($request->ajax()) {


            if (request('promo_code')) {


                $total_value = $order->sub_total;
                $code = request('promo_code');

                $check = Promocode::where('code', $code)->whereNot('usages_left', 0)->where(function ($query) {
                    $query->whereNull('expired_at')->orWhere('expired_at', '>', now());
                })->exists();

                if ($check) {

                    $promocode = Promocode::where('code', $code)->first();
                    $details = json_decode($promocode->details, true);

                    if ($details['status'] == 'invalid') {
                        return ['error' => 'This promocode is not valid anymore'];
                    }

                    if ($details['type'] == 'percentage') {

                        $discount_value = ($details['discount'] * $total_value) / 100;
                        $new_value = $total_value - $discount_value;
                        $discount = '-' . $details['discount'] . '%';

                        try {
                            Promocodes::code($code)
                                ->user(User::find(auth()->user()->id))
                                ->apply();
                        } catch (PromocodeAlreadyUsedByUserException $ex) {
                            return ['error' => 'The given promocode ' . $code . ' has already been used by you'];
                        } catch (PromocodeDoesNotExistException $ex) {
                            return ['error' => 'Provided promocode does not exists'];
                        } catch (PromocodeExpiredException $ex) {
                            return ['error' => 'Provided promocode has already expired'];
                        } catch (PromocodeNoUsagesLeftException $ex) {
                            return ['error' => 'Provided promocode has been depleted'];
                        }
                        session(['total_amount' => number_format($new_value, 2)]);
                        return ['total' => session('total_amount'), 'discount' => $discount];
                    } else {

                        try {
                            Promocodes::code($code)
                                ->user(User::find(auth()->user()->id))
                                ->apply();
                        } catch (PromocodeAlreadyUsedByUserException $ex) {
                            return ['error' => 'The given promocode ' . $code . ' has already been used by you'];
                        } catch (PromocodeDoesNotExistException $ex) {
                            return ['error' => 'Provided promocode does not exists'];
                        } catch (PromocodeExpiredException $ex) {
                            return ['error' => 'Provided promocode has already expired'];
                        } catch (PromocodeNoUsagesLeftException $ex) {
                            return ['error' => 'Provided promocode has been depleted'];
                        }

                        $new_value = $total_value - $details['discount'];
                        $discount = config('payment.default_system_currency_symbol') . $details['discount'] . ' ' . $id->currency;
                        session(['total_amount' => number_format($new_value, 2)]);
                        return ['total' => session('total_amount'), 'discount' => $discount];
                    }
                }

                return ['error' => 'Invalid promocode'];
            }

            return ['error' => 'Enter a valid promocode'];
        }
    }

    public function update_order(Request $request, $id)
    {

        session()->forget('total_amount');

        $service = DB::table('services')->where('id', $request->service_id)->first();
        $f = array();
        $p = array();
        //if ($request->hasFile('file')) {
         //   $path = public_path('/user_files');
            //cho $request->file('file');
           // $filenameWithExt = $request->file('file')->getClientOriginalName();
          //  $f = $filenameWithExt;
           // $p = asset('/user_files') . '/' . $filenameWithExt;
          //  $request->file->move($path, $filenameWithExt);
        //}

        $premium = 0.00;

        $price = format_amount($service->price)['amount'];
        if ($request->planType == 'premium') {
            $package = DB::table('packages')->where('cost', '<>', 0)->where('status', 1)->first();
            $premium = format_amount($package->cost)['amount'];
            $price = format_amount($package->cost)['amount'];
        } else {
            $package = DB::table('packages')->where('cost', 0)->where('status', 1)->first();
        }

        DB::table('orders')->where('id', $id)->update([
            'title' => $request->title,
            'formatting' => $request->formatting2 == 'other' ? $request->formatting : $request->formatting2,
            'instruction' => $request->specifications,
            'customer_id' => auth()->user()->id,
            'service_id' => $request->service_id,
            'work_level_id' => $request->work_level_id,
            'urgency_id' => 1,
            'dead_line' => $request->deadline_date,
            'deadline_time' => $request->deadline_time,
            'unit_name' => 'Pages',
            'base_price' => $price,
            'work_level_price' => 0,
            'urgency_price' => 0,
            'unit_price' => $price,
            'quantity' => $request->qty,
            'amount' => $price * $request->qty,
            'sub_total' => $price * $request->qty,
            'discount' => 0,
            'total' => $price * $request->qty,
            'staff_payment_amount' => 1,
            'time_format' => $request->urgency_id,
            'package' => $package->name,
            'package_amount' => $premium,
            'spacing_type' => 'double',
            'work_level_percentage' => 0,
            'urgency_percentage' => 0,
            'staff_id' => 0,
            'order_status_id' => 1,
            'currency' => currency(),
            'file' => 0,
            'file_path' => 0,
            'course' => $request->course,
            'sources' => $request->sources,
            'updated_at' => $request->today

        ]);



        $order = DB::table('orders')->where('customer_id', auth()->user()->id)->where('id', $id)->first();
		   if ($request->hasFile('file')) {
            $files = $request->file('file');
            $path = 'user_files'; // Relative path to the storage directory

            foreach ($files as $file) {
                if ($file->isValid()) {
                    $filenameWithExt = $file->getClientOriginalName();
                    $file->storeAs($path, $filenameWithExt, 'public'); // Store the file in the public disk under the specified path

                    $filePath = Storage::disk('public')->url($path . '/' . $filenameWithExt);
                    $f[] = $filenameWithExt;
                    $p[] = $filePath;
                    DB::table('attachments')->insert([
                        'order_id' => $order->id,
                        'uploader_id' => auth()->user()->id,
                        'file' => $filenameWithExt,
                        'file_path' => 'https://' . $filePath,
                    ]);
                }
            }
        }

        $data['total'] = $order->total;

        session(['total_amount' => $data['total']]);

        session(['OID' => $order->id]);



        $data['gateway_name'] = 'stripe';

        $data['gateway_name2'] = 'Paypal';

        $data['publishable_key'] = env('STRIPE_KEY');

        $sservice = DB::table('services')->where('id', $order->service_id)->first();
        $swork_level = DB::table('work_levels')->where('id', $order->work_level_id)->first();
		Mail::to(request('email'))->cc(auth()->user()->email)->send(new UpdateOrder());
		
        return response()->json([
            'status' => 200,
            'total' => $order->total,
            'title' => $order->title,
            'qty' => $order->quantity,
            'course' => $order->course,
            'sources' => $order->sources,
            'instruction' => $order->instruction,
            'formatting' => $order->formatting,
            'posted' => date('Y-m-d', strtotime($order->created_at)),
            'deadline_date' => $order->dead_line,
            'deadline_time' => $order->deadline_time,
            'service' => $sservice->name,
            'work_level' => $swork_level->name,
            'plan_type' => $package->name,
            'file_name' => $f,
            'file_path' => $p,
            'o_id' => $order->id
        ]);
		
		
		

        toastr()->success(__('Order has been successfully updated, Please Select a Payment Gateway for Payment'));

        return view('user.checkout.select_payment_method', compact('order', 'data'));





        return ['status' => 200, 'id' => $order->id, 'total' => session('total_amount')];
    }

    

    public function send_message(Request $request)
    {
        $f = '';
        $p = '';

        if ($request->hasFile('myfile')) {
            $path = public_path('/user_files');
            $filenameWithExt = $request->file('myfile')->getClientOriginalName();
            $f = $filenameWithExt;
            $p = asset('/user_files') . '/' . $filenameWithExt;
            $request->myfile->move($path, $filenameWithExt);
        }

        $w = DB::table('writers')->where('id', $request->receiver_id)->first();

        DB::table('conversations')->insert([
            'order_id' => $request->o_id,
            'message' => $request->message,
            'sender' => auth()->user()->username,
            'receiver' => 'admin',
            'attachment' => $f,
            'attachment_path' => $p,
        ]);
        return response()->json(['message' => $request->message]);
    }


    public function rate_order($id)
    {
        DB::table('orders')->where('id', $id)->update([
            'order_status_id' => 5
        ]);
		
		$user = auth()->user();
		$order = DB::table('orders')->where('id', $id)->first();
		$array = array(
			"sender" =>$user->username,
			"type" => "order-completed",
			"name" => $user->username,
			"email" =>$user->email,
			"subject" => "Order Completed",
			"country" => auth()->user()->country,
			"message" => "Your Order has been complted",
			"action" => "Action Required"
		);
		$jsonObject = json_encode($array);

			DB::table('notifications')->insert([
			'id' => rand(00000,99999),
			'type' => 'order-completed',
			'notifiable_type'=> 'App\Models\User',
			'notifiable_id' => 1,
			'data' => $jsonObject,
			'created_at'=>date('Y-m-d h:i:s')

		]);
		DB::table('notifications')->insert([
			'id' => rand(00000,99999),
			'type' => 'App\Notifications\GeneralNotification',
			'notifiable_type'=> 'App\Models\User',
			'notifiable_id' => $user->id,
			'data' => $jsonObject,
			'created_at'=>date('Y-m-d h:i:s')

		]);
		
		Mail::to(request('email'))->cc(auth()->user()->email)->send(new CompleteOrder($user, $order));
		
		
        toastr()->success(__('Order has been Completed, successfully'));
        return redirect()->back();
    }
}
