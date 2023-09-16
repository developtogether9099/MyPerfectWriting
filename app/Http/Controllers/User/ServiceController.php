<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(){
        $services = DB::table('services')->where('inactive',null)->get();
        $work_levels = DB::table('work_levels')->where('inactive',null)->get();
     
		$packages = DB::table('packages')->where('status',1)->get();
		$subjects = DB::table('subjects')->where('status',1)->get();
		$citations = DB::table('citations')->where('status',1)->get();
        //return $w;
        return view('user.orders.services', compact('services','work_levels','packages','subjects','citations'));
     }
	
	  public function get_services(){
        $services = DB::table('services')->where('inactive',null)->get();
       
        return $services;
     }
}
