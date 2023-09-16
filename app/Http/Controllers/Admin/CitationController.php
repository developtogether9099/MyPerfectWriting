<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\Admin\Citation;

class CitationController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('citations')->get();
		if ($request->ajax()) {
			$data = Citation::latest()->get(); 
			return Datatables::of($data)
			->addColumn('actionBtn', function($row){
			$actionBtn ='<div> <a href="'. route("admin.citation_edit",$row["id"] ).'"><i class="fa-solid fa fa-edit table-action-buttons edit-action-button" title="Edit Citation"></i></a>
			<a href="'. route("admin.citation_delete",$row["id"] ).'"><i class="fa-solid fa fa-trash table-action-buttons edit-action-button" title="Edit Citation"></i></a>
			</div>';
			return $actionBtn;
			})->addColumn('name', function($row){ 
				$name = $row["name"];
				return $name;
			})->addColumn('status', function($row){
				if($row['status'] == 1) {
					$status ='<a href="'. route("admin.citation_inactive")."?citation=".$row["id"] .'">
							<input type="checkbox" name="enable-gcp" class="custom-switch-input" checked>
							<span class="custom-switch-indicator"></span>  </a>';
						return $status; 
				}
			
				 else {
                        $status ='<a href="'. route("admin.citation_active")."?citation=".$row["id"] .'">
                      
                                    <span class="custom-switch-indicator"></span>
                                    </a>';
                            return $status;
                        }
			})->rawColumns(['name','status','actionBtn'])->make(true);         
		}
		return view('admin.citations.index', compact('data'));
    }
	
	public function citation_create()
    {
       return view('admin.citations.create');
    }
	
	public function citation_store(Request $request)
    {
 		DB::table('citations')->insert([
            'name' => $request->name,
	        'description' => $request->description,
	  		
        ]);
        toastr()->success(__('Successfully Stored citation'));
        return redirect()->route('admin.citations');
    }
	
	public function citation_edit($id)
    {
	   $data = DB::table('citations')
        ->where('id', $id)->first();
       return view('admin.citations.edit', compact('data'));
    }
	
	public function citation_update(Request $request, $id)
    {
 		DB::table('citations')->where('id',$id)->update([
            'name' => $request->name,
	        'description' => $request->description,
	  		
        ]);
          toastr()->success(__('Successfully Updated citation'));
        return redirect()->route('admin.citations');
    }

	public function active(Request $request){
        DB::table('citations')
        ->where('id', $request->citation)
        ->update(['status' => 1]);
         toastr()->success(__('Successfully activated Citation'));
        return redirect()->back();
    }
    
    public function inActive(Request $request){
        DB::table('citations')
        ->where('id', $request->citation)
        ->update(['status' => 0]);
        toastr()->success(__('Successfully deactivated Citation'));
        return redirect()->back();
    }
    public function delete($id){
        DB::table('citations')
        ->where('id', $id)
        ->delete();
        //return $w;
        toastr()->success(__('Successfully deleted Citation'));
        return redirect()->back();
    }
}
