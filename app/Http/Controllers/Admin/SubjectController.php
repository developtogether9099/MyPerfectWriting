<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\Admin\Subject;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('subjects')->get();
		    if ($request->ajax()) {
			$data = Subject::latest()->get(); 
			return Datatables::of($data)
			->addColumn('actionBtn', function($row){
			$actionBtn ='<div> <a href="'. route("admin.subject_edit",$row["id"] ).'"><i class="fa-solid fa fa-edit table-action-buttons edit-action-button" title="Edit Subject"></i></a>
			<a href="'. route("admin.subject_delete",$row["id"] ).'"><i class="fa-solid fa fa-trash table-action-buttons edit-action-button" title="Edit Subject"></i></a>
			</div>';
			return $actionBtn;
			})->addColumn('name', function($row){ 
				$name = $row["name"];
				return $name;
			})->addColumn('status', function($row){
				if($row['status'] == 1) {
					$status ='<a href="'. route("admin.subject_inactive")."?subject=".$row["id"] .'">
							<input type="checkbox" name="enable-gcp" class="custom-switch-input" checked>
							<span class="custom-switch-indicator"></span>  </a>';
						return $status; 
				}
			
				 else {
                        $status ='<a href="'. route("admin.subject_active")."?subject=".$row["id"] .'">
                      
                                    <span class="custom-switch-indicator"></span>
                                    </a>';
                            return $status;
                        }
			})->rawColumns(['name','status','actionBtn'])->make(true);         
		}
		return view('admin.subjects.index', compact('data'));
    }
	
	public function subject_create()
    {
       return view('admin.subjects.create');
    }
	
	public function subject_store(Request $request)
    {
 		DB::table('subjects')->insert([
            'name' => $request->name,
	        'description' => $request->description,
	  		
        ]);
        toastr()->success(__('Successfully Stored Subject'));
        return redirect()->route('admin.subjects');
    }
	
	public function subject_edit($id)
    {
	   $data = DB::table('subjects')
        ->where('id', $id)->first();
       return view('admin.subjects.edit', compact('data'));
    }
	
	public function subject_update(Request $request, $id)
    {
 		DB::table('subjects')->where('id',$id)->update([
            'name' => $request->name,
	        'description' => $request->description,
	  		
        ]);
          toastr()->success(__('Successfully Updated Subject'));
        return redirect()->route('admin.subjects');
    }

	public function active(Request $request){
        DB::table('subjects')
        ->where('id', $request->subject)
        ->update(['status' => 1]);
           toastr()->success(__('Successfully activated Subject'));
        return redirect()->back();
    }
    
    public function inActive(Request $request){
        DB::table('subjects')
        ->where('id', $request->subject)
        ->update(['status' => 0]);
         toastr()->success(__('Successfully deactivated Subject'));
        return redirect()->back();
    }

    public function delete($id){
        DB::table('subjects')
        ->where('id', $id)
        ->delete();
        //return $w;
        toastr()->success(__('Successfully deleted Subject'));
        return redirect()->back();
    }
}
