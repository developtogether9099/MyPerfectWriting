<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Admin\WorkLevel;

class WorkLevelController extends Controller
{
    public function index(Request $request){
        $work_levels = WorkLevel::get(); //return $work_levels;
        if ($request->ajax()) {
			$data = WorkLevel::latest()->get(); 
			return Datatables::of($data)
			->addColumn('actionBtn', function($row){
			$actionBtn ='<div> <a href="'. route("admin.work_level_edit")."?id=".$row["id"] .'"><i class="fa-solid fa fa-edit table-action-buttons edit-action-button" title="Edit Work Level"></i></a>
			<a href="'. route("admin.subject_delete",$row["id"] ).'"><i class="fa-solid fa fa-trash table-action-buttons edit-action-button" title="Edit Subject"></i></a></div>';
			return $actionBtn;
			})->addColumn('name', function($row){ 
				$name = $row["name"];
				return $name;
			})->addColumn('status', function($row){
				if($row['inactive'] == null) {
					$status ='<a href="'. route("admin.work_level_inactive")."?work_level=".$row["id"] .'">
							<input type="checkbox" name="enable-gcp" class="custom-switch-input" checked>
							<span class="custom-switch-indicator"></span>  </a>';
						return $status; 
				}
			
				 else {
                        $status ='<a href="'. route("admin.work_level_active")."?work_level=".$row["id"] .'">
                      
                                    <span class="custom-switch-indicator"></span>
                                    </a>';
                            return $status;
                        }
			})->rawColumns(['name','status','actionBtn'])->make(true);         
		}
		
        return view('admin.work_levels.index', compact('work_levels'));
    }
	
	public function create(){
         return view('admin.work_levels.create');
    }

    public function store(Request $request){
        DB::table('work_levels')
        ->insert([
            'name'=>$request->name,
			'percentage_to_add'=>0
    
        ]);
        toastr()->success(__('Work Level has been created, successfully'));
        return redirect()->route('admin.work_levels');
    }

    public function edit(Request $request){
        $work_level = DB::table('work_levels')->where('id', $request->id)->first();
        return view('admin.work_levels.edit', compact('work_level'));
    }
    
    public function update(Request $request){
        DB::table('work_levels')
        ->where('id', $request->id)
        ->update([
            'name'=>$request->name
        ]);
        toastr()->success(__('Work Level has been updated, successfully'));
        return redirect()->route('admin.work_levels');
    }
    

    
    public function active(Request $request){
        DB::table('work_levels')
        ->where('id', $request->work_level)
        ->update(['inactive' => null]);
        toastr()->success(__('Work Level has been activated, successfully'));
        return redirect()->back();
    }
    
    public function inActive(Request $request){
        DB::table('work_levels')
        ->where('id', $request->work_level)
        ->update(['inactive' => 1]);
        toastr()->success(__('Work Level has been deactivated, successfully'));
        return redirect()->back();
    }
}
