<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;


class WriterController extends Controller
{
    public function index()
    {
		$writers = DB::table('writers')->get(); 

                 

        return view('admin.writers.index', compact('writers'));
    }

    public function writer_tasks(Request $request)
    {
        $tasks = DB::table('orders')->where('staff_id', $request->writer)->get();
        $writer = DB::table('writers')->where('id', $request->writer)->first();
        return view('admin.writers.writer_tasks', compact('tasks', 'writer'));
    }
    public function writer_create()
    {
        //$service = DB::table('services') ->where('id', $request->service)->first();
        $price_types = DB::table('price_types')->get();
        return view('admin.writers.create');
    }
	
	private function random_strings($length_of_string)
	{

	   $str_result = 'ABCDEFGHIJKLMNOP';

	   return substr(str_shuffle($str_result), 0, $length_of_string);
	}

    public function writer_store(Request $request)
    {
		  $request->validate([
            'name' => 'required|string|max:255',
			'username' => 'required|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'file' => 'required'
        ]);
		
        $f = '';
        if ($request->hasFile('file')) {
            $path = public_path('/writers/profiles');
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $f = $filenameWithExt;
            $request->file->move($path, $filenameWithExt);
        }
		
		$writer = DB::table('writers')->where('username', $request->username)->first();
		if(!empty($writer)){
			toastr()->error(__('This Username is already taken'));
        	return redirect()->back();
		} 
        DB::table('writers')
            ->insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'username' => $request->username,
                'image' => $f,

            ]);
        toastr()->success(__('Writer created, successfully'));
        return redirect()->route('admin.writers');
    }

	public function edit($id)
    {
        $writer = DB::table('writers')->where('id', $id)->first();
		//dd($writer->username);
        $price_types = DB::table('price_types')->get();
        return view('admin.writers.edit', compact('writer'));
    }
	
	
	public function update(Request $request, $id)
    {
		  $request->validate([
            'name' => 'required|string|max:255',
			
            'email' => 'required|string|email|max:255|unique:users',
          
        ]);
		
        $f = '';
        if ($request->hasFile('file')) {
            $path = public_path('/writers/profiles');
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $f = $filenameWithExt;
            $request->file->move($path, $filenameWithExt);
			DB::table('writers')->where('id',$id)
            ->update([
              'image' => $f,
			]);
        }
		if($request->password != null) {
			    DB::table('writers')->where('id',$id)
            ->update([
            
                'password' => bcrypt($request->password),
          ]);
		}

        DB::table('writers')->where('id',$id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
              
          ]);
        toastr()->success(__('Writer updated, successfully'));
        return redirect()->route('admin.writers');
    }

	

    public function active(Request $request)
    {
        DB::table('writers')
            ->where('id', $request->writer)
            ->update(['status' => 1]);
        toastr()->success(__('Writer activated, successfully'));
        return redirect()->back();
    }

    public function inActive(Request $request)
    {
        DB::table('writers')
            ->where('id', $request->writer)
            ->update(['status' => 0]);
        toastr()->success(__('Writer deactivated, successfully'));
        return redirect()->back();
    }
}
