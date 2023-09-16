<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdditionalServiceController extends Controller
{
    public function index(){
        $additional_services = DB::table('additional_services')->get();
        //return $w;
        return view('admin.additional_services.index', compact('additional_services'));
    }
    
    public function active(Request $request){
        DB::table('additional_services')
        ->where('id', $request->additional_service)
        ->update(['inactive' => null]);
        //return $w;
        return redirect()->back();
    }
    
    public function inActive(Request $request){
        DB::table('additional_services')
        ->where('id', $request->additional_service)
        ->update(['inactive' => 1]);
        //return $w;
        return redirect()->back();
    }
}