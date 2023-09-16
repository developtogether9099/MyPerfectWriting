<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UrgencyController extends Controller
{
    public function index(){
        $urgencies = DB::table('urgencies')->get();
        //return $w;
        return view('admin.urgencies.index', compact('urgencies'));
    }
    
    public function active(Request $request){
        DB::table('urgencies')
        ->where('id', $request->urgency)
        ->update(['inactive' => null]);
        //return $w;
        return redirect()->back();
    }
    
    public function inActive(Request $request){
        DB::table('urgencies')
        ->where('id', $request->urgency)
        ->update(['inactive' => 1]);
        //return $w;
        return redirect()->back();
    }
}
