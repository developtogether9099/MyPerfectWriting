<?php

namespace App\Http\Controllers\Admin\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Admin\DisplayService as Service;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ServiceController extends Controller
{
    public function index(Request $request){
      if ($request->ajax()) {
            $data = Service::all()->sortByDesc("created_at");
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $actionBtn = '<div>                                            
                                            <a href="'. route("admin.settings.service.edit", $row["id"] ). '"><i class="fa-solid fa-pencil-square table-action-buttons edit-action-button" title="Edit Service"></i></a>
                                            <a class="deleteBlogButton" id="'. $row["id"] .'" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Delete Service"></i></a>
                                        </div>';
                        return $actionBtn;
                    })
                    ->addColumn('created-on', function($row){
                        $created_on = '<span>'.date_format($row["created_at"], 'd M Y H:i:s').'</span>';
                        return $created_on;
                    })
                    ->addColumn('custom-status', function($row){
                        $custom_status = '<span class="cell-box blog-'.strtolower($row["status"]).'">'.ucfirst($row["status"]).'</span>';
                        return $custom_status;
                    })
                
                    ->rawColumns(['actions', 'custom-status', 'created-on'])
                    ->make(true);
                    
        }


        return view('admin.frontend.Service.index');
    }

    public function create(){
        
        return view('admin.frontend.Service.create');
    }

    public function store(Request $request){
            request()->validate([
            'title' => 'required',
            'status' => 'required',
            
            'content' => 'required',
        ]);

		$path = '';
        if (request()->has('image')) {

            request()->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,bmp,tiff,gif,svg,webp|max:10048'
            ]);
            
            $image = request()->file('image');
            $name = Str::random(10);         
            $folder = 'img/blogs/';
            
            $this->uploadImage($image, $folder, 'public', $name);

            $path = $folder . $name . '.' . request()->file('image')->getClientOriginalExtension();
        }

        if (request('url')) {
            $slug = request('url');
        } else {
            $slug = $this->slug(request('title'));
        }        

        $blog = Service::create([
          
            'title' => $request->title,
            'url' => $slug,
            'status' => $request->status,
            'keywords' => $request->keywords,
            'image' => $path,
            'body' => $request->content,
        ]);

        toastr()->success(__('Service successfully created'));
        return redirect()->route('admin.settings.service');
    }

    public function edit(Service $id)
    {
        return view('admin.frontend.Service.edit', compact('id'));
    }
    
    public function update(Request $request, $id){
       request()->validate([
            'title' => 'required',
            'status' => 'required',
            'content' => 'required',
        ]);

        if (request()->has('image')) {

            request()->validate([
                'image' => 'nullable|image|mimes:jpg,jpeg,png,bmp,tiff,gif,svg,webp|max:10048'
            ]);
            
            $image = request()->file('image');
            $name = Str::random(10);         
            $folder = 'img/blogs/';
            
            $this->uploadImage($image, $folder, 'public', $name);

            $path = $folder . $name . '.' . request()->file('image')->getClientOriginalExtension();

        } else {
            $path = '';
        }

        if (request('url')) {
            $slug = request('url');
        } else {
            $slug = '';
        } 

        $s= Service::where('id', $id)->firstOrFail();
        $s->title = request('title');
        $s->url = ($slug != '') ? $slug : $s->url;
        $s->image = ($path != '') ? $path : $s->image;
        $s->status = request('status');
        $s->keywords = request('keywords');
        $s->body = request('content');
        $s->save();    

        toastr()->success(__('Service successfully updated'));
        return redirect()->route('admin.settings.service');
    }
    

    public function uploadImage(UploadedFile $file, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(5);

        $file->storeAs($folder, $name .'.'. $file->getClientOriginalExtension(), $disk);
    }
    
   public function slug($text){ 

        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
      
        // trim
        $text = trim($text, '-');
      
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      
        // lowercase
        $text = strtolower($text);
      
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
      
        if (empty($text))
        {
          return 'n-a';
        }
      
        return $text;
    }
	
  public function delete(Request $request)
    {  
        if ($request->ajax()) {

            $blog = Service::find(request('id'));

            if($blog) {

                $blog->delete();

                return response()->json('success');

            } else{
                return response()->json('error');
            } 
        }  
    }
	
}
