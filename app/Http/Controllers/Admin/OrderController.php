<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AssignWriter;
use DataTables;
use Storage;
use DateTime;

class OrderController extends Controller
{
      public function index(Request $request){

        if ($request->ajax()) {
            $data = Order::where('payment_status',1)->latest()->get(); 
            return Datatables::of($data)
				     ->addColumn('actionBtn', function($row){
                        $actionBtn ='<div>

                                        <a href="'. route("admin.order_edit")."?id=".$row["id"] .'"><i class="fa-solid fa-user-pen table-action-buttons edit-action-button" title="Edit Order"></i></a>
                             
                                    </div>';
                        return $actionBtn;
                    })
                    ->addColumn('title', function($row){
                        $title = '<a class="text-primary" href="'.route('admin.order_details').'?id='.$row['id'].'">'. ($row["title"]).'<br>'.($row["number"]).'</a>';
                        return $title;
                    })
                    ->addColumn('service', function($row){
                        $srvc = DB::table('services')->where('id', $row["service_id"])->first();
                        $service = $srvc->name;
                        return $service;
                    })
                    ->addColumn('posted', function($row){
                        $posted = '<span class="font-weight-bold">'.date('Y-m-d',strtotime($row['created_at'])).'</span>';//$row["created_at"];
                        return $posted;
                    })
                    ->addColumn('deadline', function($row){
                        $deadline = '<span class="font-weight-bold">'.date('Y-m-d',strtotime($row['dead_line'])) .' '.date('h:i:A',strtotime($row['deadline_time']))
							
							
							
							.'</span>';//$row["cred_at"];
                        return $deadline;
                    })
                    ->addColumn('status', function($row){
                        $status = DB::table('order_statuses')->where('id', $row["order_status_id"])->first();
                        if($status) {

                            return $status->name;
                        } else {
                            return '';
                        }
                    })
                    ->addColumn('assigned', function($row){
                        $assigned = DB::table('writers')->where('id', $row["staff_id"])->first();
                        if($assigned) {

                            return $assigned->name;
                        } else {
                            return 'unassigned';
                        }
                    })
                  
                    ->rawColumns(['title','service','posted','deadline','status','assigned','actionBtn'])
                    ->make(true);                    
        }

        return view('admin.orders.index');
    }

	public function pending_for_approval(Request $request){
      //  $orders = DB::table('orders')->where('payment_status', 1)->where('order_status_id', 3)->get();
		
		if ($request->ajax()) {
            $data = Order::where('payment_status', 1)->where('order_status_id', 3)->latest()->get(); 
            return Datatables::of($data)
                    ->addColumn('title', function($row){
                        $title = '<a class="text-primary" href="'.route('admin.order_details').'?id='.$row['id'].'">'. ($row["title"]).'<br>'.($row["number"]).'</a>';
                        return $title;
                    })
                    ->addColumn('service', function($row){
                        $srvc = DB::table('services')->where('id', $row["service_id"])->first();
                        $service = $srvc->name;
                        return $service;
                    })
                    ->addColumn('posted', function($row){
                        $posted = '<span class="font-weight-bold">'.date('Y-m-d h:i:A',strtotime('@'.$row['create_at'])).'</span>';//$row["cated_at"];
                        return $posted;
                    })
                    ->addColumn('deadline', function($row){
                        $deadline = '<span class="font-weight-bold">'.date('Y-m-d h:i:A',strtotime('@'.$row['dead_line'])).'</span>';//$row["ceated_at"];
                        return $deadline;
                    })
                    ->addColumn('status', function($row){
                        $status = DB::table('order_statuses')->where('id', $row["order_status_id"])->first();
                        if($status) {

                            return $status->name;
                        } else {
                            return '';
                        }
                    })
                    ->addColumn('assigned', function($row){
                        $assigned = DB::table('writers')->where('id', $row["staff_id"])->first();
                        if($assigned) {

                            return $assigned->name;
                        } else {
                            return 'unassigned';
                        }
                    })
                  
                    ->rawColumns(['title','service','posted','deadline','status','assigned'])
                    ->make(true);                    
        }

        return view('admin.orders.pending_for_approval');
    }
    public function order_details(Request $request){
        session()->forget('OID');
        $order = DB::table('orders')->where('id', $request->id)->first();
        $comments = DB::table('comments')->where('order_id', $order->id)->get();
		$attachments =  DB::table('attachments')->where('order_id', $order->id)->get();
		$conversations =  DB::table('conversations')->where('order_id', $order->id)->get();
        return view('admin.orders.order_details', compact('order', 'comments','attachments','conversations'));
    }

    public function assign(Request $request){
        $orders = DB::table('orders')->where('staff_id', 0)->where('payment_status', 1)->get();
		 if ($request->ajax()) {
            $data = Order::where('payment_status',1)->where('staff_id', 0)->latest()->get(); 
            return Datatables::of($data)
				   
                    ->addColumn('title', function($row){
                        $title = '<a class="text-primary" href="'.route('admin.assign_order_details').'?id='.$row['id'].'">'. ($row["title"]).'<br>'.($row["number"]).'</a>';
                        return $title;
                    })
                    ->addColumn('service', function($row){
                        $srvc = DB::table('services')->where('id', $row["service_id"])->first();
                        $service = $srvc->name;
                        return $service;
                    })
                    ->addColumn('posted', function($row){
                        $posted = '<span class="font-weight-bold">'.date('Y-m-d',strtotime($row['created_at'])).'</span>';//$row["created_at"];
                        return $posted;
                    })
                    ->addColumn('deadline', function($row){
                        $deadline = '<span class="font-weight-bold">'.date('Y-m-d',strtotime($row['dead_line'])) .' '.date('h:i:A',strtotime($row['deadline_time']))
							
							
							
							.'</span>';//$row["cred_at"];
                        return $deadline;
                    })
                
                
                  
                    ->rawColumns(['title','service','posted','deadline'])
                    ->make(true);                    
        }

        return view('admin.orders.assign');
    }
    
    public function assign_order_details(Request $request){
        $order = DB::table('orders')->where('id', $request->id)->where('payment_status', 1)->first();
        $writers = DB::table('writers')->where('status', 1)->get();
			$attachments =  DB::table('attachments')->where('order_id', $order->id)->get();
        return view('admin.orders.assign_order_details', compact('order','writers','attachments'));
    }

    public function assign_submit(Request $request){
	
        DB::table('orders')->where('id', $request->o_id)->where('payment_status', 1)
        ->update([
			'staff_id' => $request->writer_id,
			'writer_deadline' => strtotime($request->writer_deadline),
			'order_status_id'=> 2
		]);
		$order = DB::table('orders')->where('id', $request->o_id)->first();
		$user = DB::table('users')->where('id', $order->customer_id)->first();	
		$array = array(
			"sender" => "Admin",
			"type" => "order-assigned",
			"name" => $user->username,
			"email" =>$user->email,
			"subject" => "Order Assigned",
			"country" => auth()->user()->country,
			"message" => "Your Order has been assigned to writer, Please Check it out",
			"action" => "Action Required"
		);
		$jsonObject = json_encode($array);

			DB::table('notifications')->insert([
			'id' => rand(00000,99999),
			'type' => 'order-assigned',
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
		$writer = DB::table('writers')->where('id', $request->writer_id)->first();
		Mail::to(request('email'))->cc($user->email)->send(new AssignWriter($user, $order, $writer));
        toastr()->success(__('Assigned successfully'));
        return redirect()->route('admin.assign');
    }
	
	public function approve(Request $request){
        $orders = DB::table('orders')->where('id', $request->id)->where('payment_status', 1)->update([
		'order_status_id'=>7
		]);
		$order = DB::table('orders')->where('id', $request->id)->first();
		$user = DB::table('users')->where('id', $order->customer_id)->first();	
		$array = array(
			"sender" => "Admin",
			"type" => "App\Notifications\GeneralNotification",
			"name" => $user->username,
			"email" =>$user->email,
			"subject" => "Order Done",
			"country" => auth()->user()->country,
			"message" => "Your Order has been placed done by writer, Please Check it out",
			"action" => "Action Required"
		);
		$jsonObject = json_encode($array);

		DB::table('notifications')->insert([
			'id' => rand(00000,99999),
			'type' => 'order-done',
			'notifiable_type'=> 'App\Models\User',
			'notifiable_id' => $user->id,
			'data' => $jsonObject,
			'created_at'=>date('Y-m-d h:i:s')

		]);
        toastr()->success(__('Order approved successfully'));
        return redirect()->back();
    } 
	
	 public function unpaid(Request $request){
        $orders = DB::table('orders')->where('payment_status', 0)->get();
		 if ($request->ajax()) {
            $data = Order::where('payment_status',0)->latest()->get(); 
            return Datatables::of($data)
				     ->addColumn('actionBtn', function($row){
                        $actionBtn ='<div>
<a href="'. route("admin.order_edit")."?id=".$row["id"] .'"><i class="fa-solid fa-pen table-action-buttons edit-action-button" title="Edit Order"></i></a>
                                        <a href="'. route("admin.order_delete")."?id=".$row["id"] .'"><i class="fa-solid fa fa-trash table-action-buttons delete-action-button" title="Delete Order"></i></a>
                             <input type="hidden" value="https://portal.myperfectwriting.co.uk/payment/order-details/" id="link"/>
							 <a href="#"  onclick="copyToClipboard('.$row["id"].')">
    <i class="fa fa-link"></i>
</a>
                                    </div>';
                        return $actionBtn;
                    })
                    ->addColumn('title', function($row){
                        $title = '<a class="text-primary" href="'.route('admin.order_details').'?id='.$row['id'].'">'. ($row["title"]).'<br>'.($row["number"]).'</a>';
                        return $title;
                    })
                    ->addColumn('service', function($row){
                        $srvc = DB::table('services')->where('id', $row["service_id"])->first();
                        $service = $srvc->name;
                        return $service;
                    })
                    ->addColumn('posted', function($row){
                        $posted = '<span class="font-weight-bold">'.date('Y-m-d',strtotime($row['created_at'])).'</span>';
                        return $posted;
                    })
                    ->addColumn('deadline', function($row){
                        $deadline = '<span class="font-weight-bold">'.date('Y-m-d',strtotime($row['dead_line'])) .' '.date('h:i:A',strtotime($row['deadline_time']))
							
							
							
							.'</span>';//$row["cred_at"];
                        return $deadline;
                    })
             
                   
                  
                    ->rawColumns(['title','service','posted','deadline','actionBtn'])
                    ->make(true);                    
        }
        return view('admin.orders.unpaid');
    }
	
	public function requested_by_writer(Request $request){
        $orders = DB::table('orders')->where('staff_req_id', '<>', 0)->where('staff_id', 0)->get();
		if ($request->ajax()) {
            $data = Order::where('payment_status',1)->where('staff_req_id', '<>', 0)->where('staff_id', 0)->latest()->get(); 
            return Datatables::of($data)
				     ->addColumn('actionBtn', function($row){$actionBtn ='<div>

                                        <a href="'. route("admin.accept_request")."?id=".$row["id"] .'"><i class="fa-solid fa fa-check edit-action-button" title="Accept Order"></i></a>
										<a href="'. route("admin.reject_request")."?id=".$row["id"] .'"><i class="ms-2 fa-solid fa fa-close edit-action-button" title="Accept Order"></i></a>

                             

                                    </div>'; return $actionBtn;
                  
                    })
                    ->addColumn('title', function($row){
                        $title = '<a class="text-primary" href="'.route('admin.order_details').'?id='.$row['id'].'">'. ($row["title"]).'<br>'.($row["number"]).'</a>';
                        return $title;
                    })
                    ->addColumn('service', function($row){
                        $srvc = DB::table('services')->where('id', $row["service_id"])->first();
                        $service = $srvc->name;
                        return $service;
                    })
                    ->addColumn('posted', function($row){
                        $posted = '<span class="font-weight-bold">'.date('Y-m-d',strtotime($row['created_at'])).'</span>';//$row["created_at"];
                        return $posted;
                    })
                    ->addColumn('deadline', function($row){
                        $deadline = '<span class="font-weight-bold">'.date('Y-m-d',strtotime($row['dead_line'])) .' '.date('h:i:A',strtotime($row['deadline_time']))
							
							
							
							.'</span>';//$row["cred_at"];
                        return $deadline;
                    })
                    ->addColumn('status', function($row){
                        $status = DB::table('order_statuses')->where('id', $row["order_status_id"])->first();
                        if($status) {

                            return $status->name;
                        } else {
                            return '';
                        }
                    })
                
                  
                    ->rawColumns(['title','service','posted','deadline','status','actionBtn'])
                    ->make(true);                    
        }

        return view('admin.orders.requested_by_writer');
    }
	
	public function accept_request(Request $request){
	
        $order = DB::table('orders')->where('id', $request->id)->first();
		DB::table('orders')->where('id', $request->id)->update([
		 	'staff_id'=>$order->staff_req_id, 
			]);
		//$order = DB::table('orders')->where('staff_id', $request->o_id)->first();
		$user = DB::table('writers')->where('id', $order->staff_id)->first();	
		$array = array(
			"sender" => "Admin",
			"type" => "App\Notifications\GeneralNotification",
			"name" => $user->username,
			"email" =>$user->email,
			"subject" => "Request Accepted",
			"country" => auth()->user()->country,
			"message" => "Your request for Order has been accepted, Please Check it out",
			"action" => "Action Required"
		);
		$jsonObject = json_encode($array);

		DB::table('notifications')->insert([
			'id' => rand(00000,99999),
			'type' => 'request-accepted',
			'notifiable_type'=> 'App\Models\User',
			'notifiable_id' => $user->id,
			'data' => $jsonObject,
			'created_at'=>date('Y-m-d h:i:s')
			]);

		toastr()->success(__('Order request accepted and assigned to writer, successfully'));
        return redirect()->back();
    }
	
	public function reject_request(Request $request){
	
        $order = DB::table('orders')->where('id', $request->id)->first();
		DB::table('orders')->where('id', $request->id)->update([
		 	'staff_req_id'=>0, 
			]);
		$user = DB::table('writers')->where('id', $order->staff_id)->first();	
		$array = array(
			"sender" => "Admin",
			"type" => "App\Notifications\GeneralNotification",
			"name" => $user->username,
			"email" =>$user->email,
			"subject" => "Request Rejected",
			"country" => auth()->user()->country,
			"message" => "Your request for Order has been rejected",
			"action" => "Action Required"
		);
		$jsonObject = json_encode($array);

		DB::table('notifications')->insert([
			'id' => rand(00000,99999),
			'type' => 'request-rejected',
			'notifiable_type'=> 'App\Models\User',
			'notifiable_id' => $user->id,
			'data' => $jsonObject,
			'created_at'=>date('Y-m-d h:i:s')
			]);
		toastr()->success(__('Order request rejected, successfully'));
        return redirect()->back();
    }
	
	public function create(Request $request){
	    $services = DB::table('services')->where('inactive',null)->get();
        $work_levels = DB::table('work_levels')->where('inactive',null)->get();
     
		$packages = DB::table('packages')->where('status',1)->get();
		$subjects = DB::table('subjects')->where('status',1)->get();
		$citations = DB::table('citations')->where('status',1)->get();
        return view('admin.orders.create', compact('services','work_levels','packages','subjects','citations'));
    } 
	
	
	public function store(Request $request)
    {
        session()->forget('total_amount');
        $orders = DB::table('orders')->count();
        $number = $orders;
        $number += 1;
        $service = DB::table('services')->where('id', $request->service_id)->first();
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
            'service_id' => $request->service_id,
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
            'created_at' => now()
        ]);

        $order = DB::table('orders')->where('customer_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
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
        
        
        toastr()->success(__('Order has been successfully submitted'));
        return redirect()->back();
    }
	
	public function edit(Request $request){
        $order = DB::table('orders')->where('id', $request->id)->first();
		$services = DB::table('services')->where('inactive',null)->get();
        $work_levels = DB::table('work_levels')->where('inactive',null)->get();
     	$packages = DB::table('packages')->where('status',1)->get();
		$subjects = DB::table('subjects')->where('status',1)->get();
		$citations = DB::table('citations')->where('status',1)->get();
		
		$sservice = DB::table('services')->where('id', $order->service_id)->where('inactive',null)->first();
        $swork_level = DB::table('work_levels')->where('id', $order->work_level_id)->where('inactive',null)->first();
     
		$spackage = DB::table('packages')->where('id', $order->service_id)->where('status',1)->first();
		$ssubject = DB::table('subjects')->where('name', $order->course)->where('status',1)->first();
		$scitation = DB::table('citations')->where('name', $order->formatting)->where('status',1)->first();
        return view('admin.orders.edit', compact('order','services','work_levels','packages','subjects','citations','sservice','swork_level','spackage','ssubject','scitation'));
    } 
	
	public function delete(Request $request){
        $order = DB::table('orders')->where('id', $request->id)->delete();
		toastr()->success(__('Order has been deleted, successfully'));
        return redirect()->back();
    } 
	
	
	public function update(Request $request, $id){
		
	//return $id;
        $service = DB::table('services')->where('id', $request->service_id)->first();
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
                    //$f[] = $filenameWithExt;
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
        toastr()->success(__('Order updated successfully'));
        return redirect()->back();
    } 
	
	
  public function submit_work(Request $request)
  {

  
   
 $order = Order::where('id', $request->id)->first();
    
	     if ($request->hasFile('name')) {
            $files = $request->file('name');
            $path = asset('/core/public/writers/files/') . '/'; // Relative path to the storage directory

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

	  /*
    if ($request->hasFile('name')) {

      $ext = $request->file('name')->getClientOriginalExtension();
      if($ext == 'pdf' || $ext == 'zip' || $ext == 'doc' || $ext == 'rtf' || $ext == 'rar') {
        $filenameWithExt = $request->file('name')->getClientOriginalName();
        $dn = $filenameWithExt;
        
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
        $extension = $request->file('name')->getClientOriginalExtension();
        
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        
        $path = public_path('/writers/files/');
        $request->file('name')->move($path, $fileNameToStore);
        $path = asset('/core/public/writers/files/') . '/' . $fileNameToStore;
      } else {

		toastr()->error(__('Cannot upload this file, Please convert to .zip or .rar!'));
        return redirect()->back();
      }
    }
*/


	 
    DB::table('submitted_works')->insert([
      'user_id' => $order->customer_id,
      'order_id' => $request->id,
      'message' => $request->message,
      'display_name' => '123',
      'name' => '123'
    ]);

    DB::table('orders')->where('id', $request->id)->update([
      'order_status_id' => 4
    ]);
	  	$array = array(
			"sender" => "Writer",
			"type" => "work-submit",
			"name" => 'admin',
			"email" => 'admin',
			"subject" => "Work Submitted",
			"country" => '-',
			"message" => "Client's order has been done and submitted the files for approval from Admin",
			"action" => "Action Required"
		);
		$jsonObject = json_encode($array);

		DB::table('notifications')->insert([
			'id' => rand(00000,99999),
			'type' => 'work-submit',
			'notifiable_type'=> 'App\Models\User',
			'notifiable_id' => 1,
			'data' => $jsonObject,
			'created_at'=>date('Y-m-d h:i:s')
		]);
	  
	    toastr()->success(__('Work has been submitted to client, successfully'));
        return redirect()->back();
    
  }
	
	public function admin_send_message(Request $request)
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
		$o = Order::where('id', $request->o_id)->first();
		$u = User::where('id', $o->customer_id)->first();
        DB::table('conversations')->insert([
            'order_id' => $request->o_id,
            'message' => $request->message,
            'sender' => 'admin', 
            'receiver' => $u->username,
            'attachment' => $f,
            'attachment_path' => $p,
        ]);

        toastr()->success(__('Message has been sent'));
        return redirect()->back();
    }


	
}