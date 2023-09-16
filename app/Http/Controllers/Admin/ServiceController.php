<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Admin\Service;
use DataTables;


class ServiceController extends Controller
{
    public function index(Request $request){
        $services = DB::table('services')->get();
 if ($request->ajax()) {
            $data = Service::latest()->get(); 
            return Datatables::of($data)
				     ->addColumn('actionBtn', function($row){
                        $actionBtn ='<div>

                                        <a href="'. route("admin.service_edit")."?service=".$row["id"] .'"><i class="fa-solid fa fa-edit table-action-buttons edit-action-button" title="Edit Service"></i></a>
                              <a href="'. route("admin.service_delete")."?service=".$row["id"] .'"><i class="fa-solid fa fa-trash table-action-buttons edit-action-button" title="Delete Service"></i></a>
                                    </div>';
                        return $actionBtn;
                    })
                    ->addColumn('name', function($row){
                        $name =  ($row["name"]);
                        return $name;
                    })
				  	->addColumn('price', function($row){
                        $price =  '<i class="fa fa-gbp"></i>'.($row["price"]);
                        return $price;
                    })
                    ->addColumn('price_type', function($row){
                        $srvc = DB::table('price_types')->where('id', $row["price_type_id"])->first();
                        $service = $srvc->name;
                        return $service;
                    })
                
                    ->addColumn('status', function($row){
                        $statusCheck = DB::table('order_statuses')->where('id', $row["order_status_id"])->first();
                        if($row['inactive'] == null) {
  						 $status ='<a href="'. route("admin.service_inactive")."?service=".$row["id"] .'">
                                    <input type="checkbox" name="enable-gcp" class="custom-switch-input" checked>
                                    <span class="custom-switch-indicator"></span>
                                    </a>';
                            return $status;
                        } else {
                        $status ='<a href="'. route("admin.service_active")."?service=".$row["id"] .'">
                      
                                    <span class="custom-switch-indicator"></span>
                                    </a>';
                            return $status;
                        }
                    })
                  
                  
                    ->rawColumns(['name','price','price_type','status','actionBtn'])
                    ->make(true);                    
        }

        return view('admin.services.index', compact('services'));
    }

    public function create(){
        //$service = DB::table('services') ->where('id', $request->service)->first();
        $price_types = DB::table('price_types')->get();
        return view('admin.services.create', compact('price_types'));
    }

    public function store(Request $request){
        DB::table('services')
        ->insert([
            'name'=>$request->name,
            'price_type_id'=>$request->price_type_id,
            'price'=>$request->price,
            'single_spacing_price'=>$request->single_spacing_price,
            'double_spacing_price'=>$request->double_spacing_price,
            'minimum_order_quantity'=>$request->minimum_order_quantity,
    
        ]);
        toastr()->success(__('Service has been created, successfully'));
        return redirect()->route('admin.services');
    }

    public function edit(Request $request){
        $service = DB::table('services') ->where('id', $request->service)->first();
        $price_type_selected = DB::table('price_types')->where('id', $service->price_type_id)->first();
        $price_type_others = DB::table('price_types')->where('id', '<>',$service->price_type_id)->get();
        return view('admin.services.edit', compact('service','price_type_selected','price_type_others'));
    }
    
    public function update(Request $request){
        DB::table('services')
        ->where('id', $request->id)
        ->update([
            'name'=>$request->name,
            'price_type_id'=>$request->price_type_id,
            'price'=>$request->price,
            'single_spacing_price'=>$request->single_spacing_price,
            'double_spacing_price'=>$request->double_spacing_price,
            'minimum_order_quantity'=>$request->minimum_order_quantity,
    
        ]);
        toastr()->success(__('Service has been updated, successfully'));
        return redirect()->route('admin.services');
    }
    

    public function active(Request $request){
        DB::table('services')
        ->where('id', $request->service)
        ->update(['inactive' => null]);
        toastr()->success(__('Service has been activated, successfully'));
        return redirect()->back();
    }
    
    public function inActive(Request $request){
        DB::table('services')
        ->where('id', $request->service)
        ->update(['inactive' => 1]);
        toastr()->success(__('Service has been deactivated, successfully'));
        return redirect()->back();
    }
	
	public function delete(Request $request){
        $order = DB::table('services')->where('id', $request->service)->delete();
		toastr()->success(__('Service has been deleted, successfully'));
        return redirect()->back();
    } 
	
}
