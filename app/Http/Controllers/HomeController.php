<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\ContactFormEmail;
use App\Models\SubscriptionPlan;
use App\Models\PrepaidPlan;
use App\Models\Setting;
use App\Models\CustomTemplate;
use App\Models\Template;
use App\Models\Blog;
use App\Models\Admin\DisplayService;
use App\Models\Review;
use App\Models\Page;
use App\Models\Faq;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Show home page
     */
    public function index()
    {

        $review_exists = Review::count();   
        $reviews = Review::all();

        $information = $this->metadataInformation();

        $faq_exists = Faq::count();        
        $faqs = Faq::where('status', 'visible')->get();

        $blog_exists = Blog::count();
        $blogs = Blog::where('status', 'published')->get();
		
		$dservice_exists = DisplayService::count();
        $dservices = DisplayService::where('status', 'published')->paginate(6);
		$hasMoreServices = $dservices->hasMorePages();

        $monthly = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'monthly')->count();
        $yearly = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'yearly')->count();
        $lifetime = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'lifetime')->count();
        $prepaid = PrepaidPlan::where('status', 'active')->count();

        $monthly_subscriptions = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'monthly')->get();
        $yearly_subscriptions = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'yearly')->get();
        $lifetime_subscriptions = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'lifetime')->get();
        $prepaids = PrepaidPlan::where('status', 'active')->get();

        $other_templates = Template::orderBy('group', 'asc')->where('status', true)->get();  
        $custom_templates = CustomTemplate::orderBy('group', 'asc')->where('status', true)->get();  
		
		$services = DB::table('services')->where('inactive',null)->get();
        $work_levels = DB::table('work_levels')->where('inactive',null)->get();

        return view('home', compact('information', 'blog_exists', 'blogs', 'faq_exists', 'faqs', 'review_exists', 'reviews', 'monthly', 'yearly', 'monthly_subscriptions', 'yearly_subscriptions', 'prepaids', 'prepaid', 'other_templates', 'custom_templates', 'lifetime', 'lifetime_subscriptions','services','work_levels','dservice_exists','dservices','hasMoreServices'));
    }

	public function services(Request $request)
    {
		$information = $this->metadataInformation();
		$service_exists = DisplayService::count();
		if($request->search) {
        	$services = DisplayService::where('title', 'like', "%$request->search%")->where('status', 'published')->paginate(12);
		} else {
			$services = DisplayService::where('status', 'published')->paginate(12);
		}

        return view('services', compact('services','service_exists','information'));
    }
	
	public function pricing(Request $request)
    {
		$information = $this->metadataInformation();
		$monthly = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'monthly')->count();
        $yearly = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'yearly')->count();
        $lifetime = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'lifetime')->count();
        $prepaid = PrepaidPlan::where('status', 'active')->count();

        $monthly_subscriptions = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'monthly')->get();
        $yearly_subscriptions = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'yearly')->get();
        $lifetime_subscriptions = SubscriptionPlan::where('status', 'active')->where('payment_frequency', 'lifetime')->get();
        $prepaids = PrepaidPlan::where('status', 'active')->get();
		
		

        return view('pricing', compact('information', 'monthly', 'yearly', 'monthly_subscriptions', 'yearly_subscriptions', 'prepaids', 'prepaid', 'lifetime', 'lifetime_subscriptions'));
    }
	
	public function blogs(Request $request)
    {
		$information = $this->metadataInformation();
		$blog_exists = Blog::count();
		if($request->search) {
			  $blogs = Blog::where('title', 'like', "%$request->search%")->where('status', 'published')->paginate(12);
		} else {
			  $blogs = Blog::where('status', 'published')->paginate(12);
		}
      

        return view('blogs', compact('blogs','blog_exists','information'));
    }

    /**
     * Display terms & conditions page
     * 
     */
    public function termsAndConditions() 
    {
        $information = $this->metadataInformation();

        $pages_rows = ['terms'];
        $pages = [];
        $page = Page::all();

        foreach ($page as $row) {
            if (in_array($row['name'], $pages_rows)) {
                $pages[$row['name']] = $row['value'];
            }
        }

        return view('service-terms', compact('information', 'pages'));
    }


    /**
     * Display privacy policy page
     * 
     */
    public function privacyPolicy() 
    {
        $information = $this->metadataInformation();

        $pages_rows = ['privacy'];
        $pages = [];
        $page = Page::all();

        foreach ($page as $row) {
            if (in_array($row['name'], $pages_rows)) {
                $pages[$row['name']] = $row['value'];
            }
        }

        return view('privacy-policy', compact('information', 'pages'));
    }


    /**
     * Frontend show blog
     * 
     */ 
	
    public function blogShow($slug)
    {
        $blog = Blog::where('url', $slug)->firstOrFail();
		$popularBlogs = Blog::where('id', '<>', $blog->id)->orderBy('id','ASC')->limit(2)->get();
		$relatedBlogs = Blog::where('id', '<>', $blog->id)->orderBy('id','DESC')->limit(2)->get();
	
		$readTime = $this->calculateReadTime($blog->body);
		
        $information_rows = ['js', 'css'];
        $information = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $information_rows)) {
                $information[$row['name']] = $row['value'];
            }
        }

        $information['author'] = $blog->created_by;
        $information['title'] = $blog->title;
        $information['keywords'] = $blog->keywords;
        $information['description'] = $blog->title;

        return view('blog-show', compact('information', 'blog','popularBlogs','relatedBlogs','readTime'));
    }
	
	private function countWords($content)
	{
		return str_word_count(strip_tags($content));
	}
	
	
	private function calculateReadTime($content, $averageWordsPerMinute = 200)
	{
		$wordCount = $this->countWords($content);
		$readTimeInMinutes = ceil($wordCount / $averageWordsPerMinute);
		return $readTimeInMinutes;
	}
	
	public function serviceShow($slug)
    {
        $service = DisplayService::where('url', $slug)->firstOrFail();
		$popularservices = DisplayService::where('id', '<>', $service->id)->inRandomOrder()->take(5)->get();
        $information_rows = ['js', 'css'];
        $information = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $information_rows)) {
                $information[$row['name']] = $row['value'];
            }
        }

      	$information['author'] = 'admin';
        $information['title'] = $service->title;
        $information['keywords'] = $service->keywords;
        $information['description'] = $service->title;

        return view('service-show', compact('information', 'service', 'popularservices'));
    }


    /**
     * Frontend contact us form record
     * 
     */
    public function contact(Request $request)
    {
        request()->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        if (config('services.google.recaptcha.enable') == 'on') {

            $recaptchaResult = $this->reCaptchaCheck(request('recaptcha'));

            if ($recaptchaResult->success != true) {
                return redirect()->back()->with('error', 'Google reCaptcha Validation has Failed');
            }

            if ($recaptchaResult->score >= 0.5) {

                try {

                    Mail::to(config('mail.from.address'))->send(new ContactFormEmail($request));
 
                    if (Mail::flushMacros()) {
                        return redirect()->back()->with('error', 'Sending email failed, please try again.');
                    }
                    
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'SMTP settings were not set yet, please contact support team. ' . $e->getMessage());
                }

                return redirect()->back()->with('success', 'Email was successfully sent');

            } else {
                return redirect()->back()->with('error', 'Google reCaptcha Validation has Failed');
            }
        
        } else {

            try {

                Mail::to(config('mail.from.address'))->send(new ContactFormEmail($request));
 
                if (Mail::flushMacros()) {
                    return redirect()->back()->with('error', 'Sending email failed, please try again.');
                }

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'SMTP settings were not set yet, please contact support team. ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Email was successfully sent');
        }  
    }


    /**
     * Verify reCaptch for frontend contact us page (if enabled)
     * 
     */
    private function reCaptchaCheck($recaptcha)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];

        $data = [
                'secret' => config('services.google.recaptcha.secret_key'),
                'response' => $recaptcha,
                'remoteip' => $remoteip
        ];

        $options = [
                'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
                ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);

        return $resultJson;
    }


    public function metadataInformation()
    {
        $information_rows = ['title', 'author', 'keywords', 'description', 'js', 'css'];
        $information = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $information_rows)) {
                $information[$row['name']] = $row['value'];
            }
        }

        return $information;
    }
	
	public function blogsSearch(Request $request)
    {
		
          $data = Blog::select("title")
                ->where("title", "LIKE", "%{$request->str}%")
                ->get('query');

    	  return response()->json($data);
    }
	
	public function servicesSearch(Request $request)
    {
		
        $data = DisplayService::select("title")
            ->where("title", "LIKE", "%{$request->str}%")
            ->get('query');
			
        return response()->json($data);
    }

}
