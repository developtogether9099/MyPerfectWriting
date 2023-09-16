<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{
    public function currency_rates()
    {
        $data = DB::table('currency_rates')->first();

        return view('admin.currency.currency_rates', compact('data'));
    }

    public function update_currency_rates(Request $request)
    {
        DB::table('currency_rates')->where('id', 1)->update([
            'usd' => $request->dollar,
        ]);
        toastr()->success(__('Successfully updated'));
        return redirect()->back();
    }
	
	public function packages()
    {
        $data = DB::table('packages')->get();
		return view('admin.currency.packages', compact('data'));
    }
	
	public function package_create()
    {
       return view('admin.currency.package_create');
    }
	
	public function package_store(Request $request)
    {
 		DB::table('packages')->insert([
            'name' => $request->name,
	        'description' => $request->description,
	  		'cost' => $request->cost,
        ]);
          toastr()->success(__('Successfully Stored Package'));
        return redirect()->route('admin.packages');
    }
	
	public function package_edit($id)
    {
	   $data = DB::table('packages')
        ->where('id', $id)->first();
       return view('admin.currency.package_edit', compact('data'));
    }
	
	public function package_update(Request $request, $id)
    {
 		DB::table('packages')->where('id',$id)->update([
            'name' => $request->name,
	        'description' => $request->description,
	  		'cost' => $request->cost,
        ]);
          toastr()->success(__('Successfully Updated Package'));
        return redirect()->route('admin.packages');
    }
	public function active(Request $request){
        DB::table('packages')
        ->where('id', $request->package)
        ->update(['status' => 1]);
        //return $w;
        return redirect()->back();
    }
    
    public function inActive(Request $request){
        DB::table('packages')
        ->where('id', $request->package)
        ->update(['status' => 0]);
        //return $w;
        return redirect()->back();
    }
}
