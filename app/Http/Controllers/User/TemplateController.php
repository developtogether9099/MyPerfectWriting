<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\User\Templates\ArticleGeneratorController;
use App\Http\Controllers\User\Templates\ParagraphGeneratorController;
use App\Http\Controllers\User\Templates\ProsAndConsController;
use App\Http\Controllers\User\Templates\TalkingPointsController;
use App\Http\Controllers\User\Templates\ProductDescriptionController;
use App\Http\Controllers\User\Templates\SummarizeTextController;
use App\Http\Controllers\User\Templates\StartupNameGeneratorController;
use App\Http\Controllers\User\Templates\ProductNameGeneratorController;
use App\Http\Controllers\User\Templates\MetaDescriptionController;
use App\Http\Controllers\User\Templates\FAQsController;
use App\Http\Controllers\User\Templates\FAQAnswersController;
use App\Http\Controllers\User\Templates\TestimonialsController;
use App\Http\Controllers\User\Templates\BlogTitlesController;
use App\Http\Controllers\User\Templates\BlogSectionController;
use App\Http\Controllers\User\Templates\BlogIdeasController;
use App\Http\Controllers\User\Templates\BlogIntrosController;
use App\Http\Controllers\User\Templates\BlogConclusionController;
use App\Http\Controllers\User\Templates\ContentRewriterController;
use App\Http\Controllers\User\Templates\FacebookAdsController;
use App\Http\Controllers\User\Templates\VideoDescriptionsController;
use App\Http\Controllers\User\Templates\VideoTitlesController;
use App\Http\Controllers\User\Templates\YoutubeTagsGeneratorController;
use App\Http\Controllers\User\Templates\InstagramCaptionsController;
use App\Http\Controllers\User\Templates\InstagramHashtagsGeneratorController;
use App\Http\Controllers\User\Templates\SocialMediaPostPersonalController;
use App\Http\Controllers\User\Templates\SocialMediaPostBusinessController;
use App\Http\Controllers\User\Templates\FacebookHeadlinesController;
use App\Http\Controllers\User\Templates\GoogleHeadlinesController;
use App\Http\Controllers\User\Templates\GoogleAdsController;
use App\Http\Controllers\User\Templates\PASController;
use App\Http\Controllers\User\Templates\AcademicEssayController;
use App\Http\Controllers\User\Templates\WelcomeEmailController;
use App\Http\Controllers\User\Templates\ColdEmailController;
use App\Http\Controllers\User\Templates\FollowUpEmailController;
use App\Http\Controllers\User\Templates\CreativeStoriesController;
use App\Http\Controllers\User\Templates\GrammarCheckerController;
use App\Http\Controllers\User\Templates\Summarize2ndGraderController;
use App\Http\Controllers\User\Templates\VideoScriptsController;
use App\Http\Controllers\User\Templates\AmazonProductController;
use App\Services\Statistics\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Orhanerday\OpenAi\OpenAi;
use App\Models\FavoriteTemplate;
use App\Models\CustomTemplate;
use App\Models\SubscriptionPlan;
use App\Models\Template;
use App\Models\Content;
use App\Models\Workbook;
use App\Models\Language;
use App\Models\Category;
use App\Models\ApiKey;
use App\Models\User;
use App\Models\Setting;


class TemplateController extends Controller
{
    private $api;
    private $user;

    public function __construct()
    {
        $this->api = new LicenseController();
        $this->user = new UserService();
    }

    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
		return redirect()->route('user.dashboard');
        $favorite_templates = Template::select('templates.*', 'favorite_templates.*')->where('favorite_templates.user_id', auth()->user()->id)->join('favorite_templates', 'favorite_templates.template_code', '=', 'templates.template_code')->where('status', true)->get();  
        $favorite_custom_templates = CustomTemplate::select('custom_templates.*', 'favorite_templates.*')->where('favorite_templates.user_id', auth()->user()->id)->join('favorite_templates', 'favorite_templates.template_code', '=', 'custom_templates.template_code')->where('status', true)->get();  
        $user_templates = FavoriteTemplate::where('user_id', auth()->user()->id)->pluck('template_code');     
        $other_templates = Template::whereNotIn('template_code', $user_templates)->where('status', true)->orderBy('group', 'asc')->get();   
        $custom_templates = CustomTemplate::whereNotIn('template_code', $user_templates)->where('status', true)->orderBy('group', 'asc')->get();   
        
        $check_categories = Template::where('status', true)->groupBy('group')->pluck('group')->toArray();
        $check_custom_categories = CustomTemplate::where('status', true)->groupBy('group')->pluck('group')->toArray();
        $active_categories = array_unique(array_merge($check_categories, $check_custom_categories));
        $categories = Category::whereIn('code', $active_categories)->orderBy('updated_at', 'desc')->get(); 

       

        return view('user.templates.index', compact('favorite_templates', 'other_templates', 'custom_templates', 'favorite_custom_templates', 'categories'));
    }


     /**
	*
	* Process Davinci
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function process(Request $request) 
    {
        if ($request->ajax()) {

            if (config('settings.openai_key_usage') == 'main') {
                $open_ai = new OpenAi(config('services.openai.key'));
            } else {
                $api_keys = ApiKey::where('engine', 'openai')->where('status', true)->pluck('api_key')->toArray();
                array_push($api_keys, config('services.openai.key'));
                $key = array_rand($api_keys, 1);
                $open_ai = $api_keys[$key];
            }
            
            $prompt = '';
            $model = '';
            $text = '';
            $max_tokens = '';
            $counter = 1;
            $input_title = '';
            $input_keywords = '';
            $input_description = '';

            $identify = $this->api->verify_license();
            if($identify['status']!=true){return false;}

            # Check if user has access to the template
            $template = Template::where('template_code', $request->template)->first();
            if (auth()->user()->group == 'user') {
                if (config('settings.templates_access_user') != 'all' && config('settings.templates_access_user') != 'premium') {
                    if ($template->package == 'professional' && config('settings.templates_access_user') == 'premium') {                       
                        $data['status'] = 'error';
                        $data['message'] = __('This template is not available for your account, subscribe to get a proper access');
                        return $data;                        
                    } else if($template->package == 'standard' && (config('settings.templates_access_user') == 'premium' || config('settings.templates_access_user') == 'professional')) {
                        $data['status'] = 'error';
                        $data['message'] = __('This template is not available for your account, subscribe to get a proper access');
                        return $data;
                    }
                }
            } elseif (auth()->user()->group == 'admin') {
                if (config('settings.templates_access_admin') != 'all' && config('settings.templates_access_admin') != 'premium') {
                    if ($template->package == 'professional' && config('settings.templates_access_admin') == 'premium') {                       
                        $data['status'] = 'error';
                        $data['message'] = __('This template is not available for your account, subscribe to get a proper access');
                        return $data;                        
                    } else if($template->package == 'standard' && (config('settings.templates_access_admin') == 'premium' || config('settings.templates_access_admin') == 'professional')) {
                        $data['status'] = 'error';
                        $data['message'] = __('This template is not available for your account, subscribe to get a proper access');
                        return $data;
                    }
                }
            } else {
                $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
                if ($plan->templates != 'all' && $plan->templates != 'premium') {          
                    if ($plan->templates == 'professional' && $template->package == 'premium') {
                        $data['status'] = 'error';
                        $data['message'] = __('Your current subscription does not include support for this chat assitant category');
                        return $data;
                    } else if($plan->templates == 'standard' && ($template->package == 'premium' || $template->package == 'professional')) {
                        $status = 'error';
                        $message =  __('Your current subscription does not include support for this chat assitant category');
                        return response()->json(['status' => $status, 'message' => $message]); 
                    }                     
                }
            }

            # Filter for sensitive words
            $bad_words = Setting::where('name', 'words_filter')->first();
            $bad_words = explode(',', $bad_words->value);
            $bad_words = array_map('trim', $bad_words);
            $count_words = count($bad_words);
            if ($count_words == 0) {
                if ($request->title) {
                    $input_title = $request->title;
                }

                if ($request->keywords) {
                    $input_keywords = $request->keywords;
                }

                if ($request->description) {
                    $input_description = $request->description;
                }

            } else {
                foreach ($bad_words as $key => $word) {
                    if ($request->title) {                        
                        if ($key == 0) {
                            $input_title = $this->check_bad_words($word, $request->title, '');
                        } else {
                            $input_title = $this->check_bad_words($word, $input_title, '');
                        }                        
                    }
    
                    if ($request->keywords) {
                        if ($key == 0) {
                            $input_keywords = $this->check_bad_words($word, $request->keywords, '');
                        } else {
                            $input_keywords = $this->check_bad_words($word, $input_keywords, '');
                        }
                    }
    
                    if ($request->description) {
                        if ($key == 0) {
                            $input_description = $this->check_bad_words($word, $request->description, '');
                        } else {
                            $input_description = $this->check_bad_words($word, $input_description, '');
                        }
                    }

                }
            }
            

            # Generate proper prompt in respective language
            switch ($request->template) {
                case 'KPAQQ':                    
                    request()->validate(['title' => 'required|string', 'keywords' => 'required|string']);
                    $template_prompt = new ArticleGeneratorController();
                    $prompt = $template_prompt->createArticleGeneratorPrompt(strip_tags($input_title), strip_tags($input_keywords), $request->language, $request->tone);
                    break;
                case 'JXRZB':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new ParagraphGeneratorController();
                    $prompt = $template_prompt->createParagraphGeneratorPrompt(strip_tags($input_title), strip_tags($input_keywords), $request->language, $request->tone);
                    break;
                case 'OPYAB':                                        
                    request()->validate(['title' => 'required|string', 'description' => 'required|string']);
                    $template_prompt = new ProsAndConsController();
                    $prompt = $template_prompt->createProsAndConsPrompt(strip_tags($input_title), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'VFWSQ':                    
                    request()->validate(['title' => 'required|string', 'description' => 'required|string']);
                    $template_prompt = new TalkingPointsController();
                    $prompt = $template_prompt->createTalkingPointsPrompt(strip_tags($input_title), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'OMMEI':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new SummarizeTextController();
                    $prompt = $template_prompt->createSummarizeTextPrompt(strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'HXLNA':                    
                    request()->validate(['title' => 'required|string', 'audience' => 'required|string', 'description' => 'required|string']);
                    $template_prompt = new ProductDescriptionController();
                    $prompt = $template_prompt->createProductDescriptionPrompt(strip_tags($input_title), strip_tags($request->audience), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'DJSVM':                    
                    request()->validate(['keywords' => 'required|string', 'description' => 'required|string']);
                    $template_prompt = new StartupNameGeneratorController();
                    $prompt = $template_prompt->createStartupNameGeneratorPrompt(strip_tags($input_keywords), strip_tags($input_description), $request->language);
                    break;
                case 'IXKBE':                    
                    request()->validate(['keywords' => 'required|string', 'description' => 'required|string']);
                    $template_prompt = new ProductNameGeneratorController();
                    $prompt = $template_prompt->createProductNameGeneratorPrompt(strip_tags($input_keywords), strip_tags($input_description), $request->language);
                    break;
                case 'JCDIK':                    
                    request()->validate(['title' => 'required|string', 'keywords' => 'required|string', 'description' => 'required|string']);
                    $template_prompt = new MetaDescriptionController();
                    $prompt = $template_prompt->createMetaDescriptionPrompt(strip_tags($input_title), strip_tags($input_keywords), strip_tags($input_description), $request->language);
                    break;
                case 'SZAUF':                    
                    request()->validate(['title' => 'required|string', 'description' => 'required|string']);
                    $template_prompt = new FAQsController();
                    $prompt = $template_prompt->createFAQsPrompt(strip_tags($input_title), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'BFENK':                    
                    request()->validate(['title' => 'required|string', 'description' => 'required|string', 'question' => 'required|string']);
                    $template_prompt = new FAQAnswersController();
                    $prompt = $template_prompt->createFAQAnswersPrompt(strip_tags($input_title), strip_tags($request->question), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'XLGPP':                    
                    request()->validate(['title' => 'required|string', 'description' => 'required|string']);
                    $template_prompt = new TestimonialsController();
                    $prompt = $template_prompt->createTestimonialsPrompt(strip_tags($input_title), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'WGKYP':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new BlogTitlesController();
                    $prompt = $template_prompt->createBlogTitlesPrompt(strip_tags($input_description), $request->language);
                    break;
                case 'EEKZF':                    
                    request()->validate(['title' => 'required|string', 'subheadings' => 'required|string']);
                    $template_prompt = new BlogSectionController();
                    $prompt = $template_prompt->createBlogSectionPrompt(strip_tags($input_title), strip_tags($request->subheadings), $request->language, $request->tone);
                    break;
                case 'KDGOX':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new BlogIdeasController();
                    $prompt = $template_prompt->createBlogIdeasPrompt(strip_tags($input_title), $request->language, $request->tone);
                    break;
                case 'TZTYR':                    
                    request()->validate(['title' => 'required|string', 'description' => 'required|string']);
                    $template_prompt = new BlogIntrosController();
                    $prompt = $template_prompt->createBlogIntrosPrompt(strip_tags($input_title), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'ZGUKM':                    
                    request()->validate(['title' => 'required|string', 'description' => 'required|string']);
                    $template_prompt = new BlogConclusionController();
                    $prompt = $template_prompt->createBlogConclusionPrompt(strip_tags($input_title), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'WCZGL':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new ContentRewriterController();
                    $prompt = $template_prompt->createContentRewriterPrompt(strip_tags($input_title), $request->language, $request->tone);
                    break;
                case 'CTMNI':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new FacebookAdsController();
                    $prompt = $template_prompt->createFacebookAdsPrompt(strip_tags($input_title), strip_tags($request->audience), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'ZLKSP':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new VideoDescriptionsController();
                    $prompt = $template_prompt->createVideoDescriptionsPrompt(strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'OJIOV':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new VideoTitlesController();
                    $prompt = $template_prompt->createVideoTitlesPrompt(strip_tags($input_description), $request->language);
                    break;
                case 'ECNVU':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new YoutubeTagsGeneratorController();
                    $prompt = $template_prompt->createYoutubeTagsGeneratorPrompt(strip_tags($input_title), $request->language);
                    break;
                case 'EOASR':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new InstagramCaptionsController();
                    $prompt = $template_prompt->createInstagramCaptionsPrompt(strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'IEMBM':                    
                    request()->validate(['keywords' => 'required|string']);
                    $template_prompt = new InstagramHashtagsGeneratorController();
                    $prompt = $template_prompt->createInstagramHashtagsPrompt(strip_tags($input_keywords), $request->language);
                    break;
                case 'CKOHL':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new SocialMediaPostPersonalController();
                    $prompt = $template_prompt->createSocialPostPersonalPrompt(strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'ABWGU':                    
                    request()->validate(['description' => 'required|string', 'title' => 'required|string', 'post' => 'required|string']);
                    $template_prompt = new SocialMediaPostBusinessController();
                    $prompt = $template_prompt->createSocialPostBusinessPrompt(strip_tags($input_description), strip_tags($input_title), strip_tags($request->post), $request->language);
                    break;
                case 'HJYJZ':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new FacebookHeadlinesController();
                    $prompt = $template_prompt->createFacebookHeadlinesPrompt(strip_tags($input_title), strip_tags($request->audience), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'SGZTW':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new GoogleHeadlinesController();
                    $prompt = $template_prompt->createGoogleHeadlinesPrompt(strip_tags($input_title), strip_tags($request->audience), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'YQAFG':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new GoogleAdsController();
                    $prompt = $template_prompt->createGoogleAdsPrompt(strip_tags($input_title), strip_tags($request->audience), strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'BGXJE':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new PASController();
                    $prompt = $template_prompt->createPASPrompt(strip_tags($input_title), strip_tags($request->audience), strip_tags($input_description), $request->language);
                    break;
                case 'SXQBT':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new AcademicEssayController();
                    $prompt = $template_prompt->createAcademicEssayPrompt(strip_tags($input_title), strip_tags($input_keywords), $request->language, $request->tone);
                    break;
                case 'RLXGB':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new WelcomeEmailController();
                    $prompt = $template_prompt->createWelcomeEmailPrompt(strip_tags($input_title), strip_tags($input_description), strip_tags($input_keywords), $request->language, $request->tone);
                    break;
                case 'RDJEZ':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new ColdEmailController();
                    $prompt = $template_prompt->createColdEmailPrompt(strip_tags($input_title), strip_tags($input_description), strip_tags($input_keywords), $request->language, $request->tone);
                    break;
                case 'XVNNQ':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new FollowUpEmailController();
                    $prompt = $template_prompt->createFollowUpEmailPrompt(strip_tags($input_title), strip_tags($input_description), strip_tags($request->event), strip_tags($input_keywords), $request->language, $request->tone);
                    break;
                case 'PAKMF':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new CreativeStoriesController();
                    $prompt = $template_prompt->createCreativeStoriesPrompt(strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'OORHD':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new GrammarCheckerController();
                    $prompt = $template_prompt->createGrammarCheckerPrompt(strip_tags($input_description), $request->language);
                    break;
                case 'SGJLU':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new Summarize2ndGraderController();
                    $prompt = $template_prompt->createSummarize2ndGraderPrompt(strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'WISHV':                    
                    request()->validate(['description' => 'required|string']);
                    $template_prompt = new VideoScriptsController();
                    $prompt = $template_prompt->createVideoScriptsPrompt(strip_tags($input_description), $request->language, $request->tone);
                    break;
                case 'WISTT':                    
                    request()->validate(['title' => 'required|string']);
                    $template_prompt = new AmazonProductController();
                    $prompt = $template_prompt->createAmazonProductPrompt(strip_tags($input_title), strip_tags($input_keywords), $request->language);
                    break;
                default:
                    # code...
                    break;
            }

            # Apply proper model based on role and subsciption
            if (auth()->user()->group == 'user') {
                $model = config('settings.default_model_user');
            } elseif (auth()->user()->group == 'admin') {
                $model = config('settings.default_model_admin');
            } else {
                $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
                $model = $plan->model;
            }

            # Verify if user has enough credits
            if ((auth()->user()->available_words + auth()->user()->available_words_prepaid) < $request->words) {
                $data['status'] = 'error';
                $data['message'] = __('Not enough word balance to proceed, subscribe or top up your word balance and try again');
                return $data;
            }

            # Verify word limit
            if (auth()->user()->group == 'user') {
                $max_tokens = (config('settings.max_results_limit_user') < (int)$request->words) ? config('settings.max_results_limit_user') : (int)$request->words;
            } elseif (auth()->user()->group == 'admin') {
                $max_tokens = (config('settings.max_results_limit_admin') < (int)$request->words) ? config('settings.max_results_limit_user') : (int)$request->words;
            } else {
                $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
                $max_tokens = ($plan->max_tokens < (int)$request->words) ? $plan->max_tokens : (int)$request->words;
            }

            $control = $this->user->verify_license();
            if($control['status']!=true){return false;}

            $max_results = (int)$request->max_results;
            $temperature = (float)$request->creativity;

            if ($model == 'gpt-3.5-turbo' || $model == 'gpt-4' || $model == 'gpt-4-32k') {
                $complete = $open_ai->chat([
                    'model' => $model,
                    'messages' => [
                        [
                            "role" => "user",
                            "content" => $prompt
                        ],
                    ],
                    'temperature' => $temperature,
                    'max_tokens' => $max_tokens,
                    'n' => $max_results,
                ]);
            } else {
                 $complete = $open_ai->completion([
                    'model' => $model,
                    'prompt' => $prompt,
                    'temperature' => $temperature,
                    'max_tokens' => $max_tokens,
                    'n' => $max_results,
                ]);
            }
            

            $response = json_decode($complete , true);            

            if (isset($response['choices'])) {
                if ($model != 'gpt-3.5-turbo' && $model != 'gpt-4' && $model != 'gpt-4-32k') {
                    if (count($response['choices']) > 1) {
                        foreach ($response['choices'] as $value) {
                            $text .= $counter . '. ' . ltrim($value['text']) . "\r\n\r\n\r\n";
                            $counter++;
                        }
                    } else {
                        $text = $response['choices'][0]['text'];
                    }
                } else {
                    if (count($response['choices']) > 1) {
                        foreach ($response['choices'] as $value) {
                            $text .= $counter . '. ' . trim($value['message']['content']) . "\r\n\r\n\r\n";
                            $counter++;
                        }
                    } else {
                        $text = ltrim($response['choices'][0]['message']['content']);
                    }
                }
                
                
                $tokens = $response['usage']['completion_tokens'];
                $plan_type = (auth()->user()->plan_id) ? 'paid' : 'free';
                
                # Update credit balance
                $this->updateBalance($tokens);
                $flag = Language::where('language_code', $request->language)->first();

                $content = new Content();
                $content->user_id = auth()->user()->id;
                $content->model = $model;
                $content->language = $request->language;
                $content->language_name = $flag->language;
                $content->language_flag = $flag->language_flag;
                $content->template_code = $request->template;
                $content->template_name = $template->name;
                $content->icon = $template->icon;
                $content->group = $template->group;
                $content->tokens = $tokens;
                $content->plan_type = $plan_type;
                $content->save();
    
                $data['text'] = trim($text);
                $data['status'] = 'success';
                $data['old'] = auth()->user()->available_words + auth()->user()->available_words_prepaid;
                $data['current'] = auth()->user()->available_words + auth()->user()->available_words_prepaid - $tokens;
                $data['id'] = $content->id;
                return $data; 

            } else {

                if (isset($response['error']['message'])) {
                    $message = $response['error']['message'];
                } else {
                    $message = __('There is an issue with your openai account');
                }
                
                $data['status'] = 'error';
                $data['message'] = $message;
                return $data;
            }
           

        }
	}


    /**
	*
	* Process Davinci
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function processCustom(Request $request) 
    {
        if ($request->ajax()) {

            $open_ai = new OpenAi(config('services.openai.key'));
            $prompt = '';
            $model = '';
            $text = '';
            $max_tokens = '';
            $counter = 1;

            $identify = $this->api->verify_license();
            if($identify['status']!=true){return false;}

            # Check if user has access to the template
            $template = CustomTemplate::where('template_code', $request->template)->first();
            $flag = Language::where('language_code', $request->language)->first();

            if (auth()->user()->group == 'user') {
                if (config('settings.templates_access_user') != 'all') {
                    if ($template->package != config('settings.templates_access_admin')) {                     
                        $data['status'] = 'error';
                        $data['message'] = __('This template is not available for your account, subscribe to get a proper access');
                        return $data;                        
                    }
                }
            } elseif (auth()->user()->group == 'admin') {
                if (config('settings.templates_access_admin') != 'all') {
                    if ($template->package != config('settings.templates_access_admin')) {                     
                        $data['status'] = 'error';
                        $data['message'] = __('This template is not available for your account, subscribe to get a proper access');
                        return $data;                        
                    }
                }
            } else {
                $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
                if ($plan->templates != 'all') {          
                    if ($plan->templates != $template->package) {
                        $data['status'] = 'error';
                        $data['message'] = __('Your current subscription does not cover this template');
                        return $data;
                    }                    
                }
            }
            

            # Apply proper model based on role and subsciption
            if (auth()->user()->group == 'user') {
                $model = config('settings.default_model_user');
            } elseif (auth()->user()->group == 'admin') {
                $model = config('settings.default_model_admin');
            } else {
                $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
                $model = $plan->model;
            }

            # Verify if user has enough credits
            if ((auth()->user()->available_words + auth()->user()->available_words_prepaid) < $request->words) {
                $data['status'] = 'error';
                $data['message'] = __('Not enough word balance to proceed, subscribe or top up your word balance and try again');
                return $data;
            }

            # Verify word limit
            if (auth()->user()->group == 'user') {
                $max_tokens = (config('settings.max_results_limit_user') < (int)$request->words) ? config('settings.max_results_limit_user') : (int)$request->words;
            } elseif (auth()->user()->group == 'admin') {
                $max_tokens = (config('settings.max_results_limit_admin') < (int)$request->words) ? config('settings.max_results_limit_user') : (int)$request->words;
            } else {
                $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
                $max_tokens = ($plan->max_tokens < (int)$request->words) ? $plan->max_tokens : (int)$request->words;
            }

            $upload = $this->user->upload();
            if (!$upload['status']) return;  

            if ($request->language == 'en-US') {
                $prompt = $template->prompt;
            } else {
                $prompt = "Provide response in " . $flag->language . '.\n\n '. $template->prompt;
            }

            if (isset($request->tone)) {
                $prompt = $prompt . ' \n\n Voice of tone of the response must be ' . $request->tone . '.';
            }
            
    
            foreach ($request->all() as $key=>$value) {
                $prompt = str_replace('###' . $key . '###', $value, $prompt);
            }

            $max_results = (int)$request->max_results;
            $temperature = (float)$request->creativity;

            if ($model == 'gpt-3.5-turbo' || $model == 'gpt-4' || $model == 'gpt-4-32k') {
                $complete = $open_ai->chat([
                    'model' => $model,
                    'messages' => [
                        [
                            "role" => "user",
                            "content" => $prompt
                        ],
                    ],
                    'temperature' => $temperature,
                    'max_tokens' => $max_tokens,
                    'n' => $max_results,
                ]);
            } else {
                 $complete = $open_ai->completion([
                    'model' => $model,
                    'prompt' => $prompt,
                    'temperature' => $temperature,
                    'max_tokens' => $max_tokens,
                    'n' => $max_results,
                ]);
            }
            

            $response = json_decode($complete , true);      
                 

            if (isset($response['choices'])) {
                if ($model != 'gpt-3.5-turbo' && $model != 'gpt-4' && $model != 'gpt-4-32k') {
                    if (count($response['choices']) > 1) {
                        foreach ($response['choices'] as $value) {
                            $text .= $counter . '. ' . ltrim($value['text']) . "\r\n\r\n\r\n";
                            $counter++;
                        }
                    } else {
                        $text = $response['choices'][0]['text'];
                    }
                } else {
                    if (count($response['choices']) > 1) {
                        foreach ($response['choices'] as $value) {
                            $text .= $counter . '. ' . trim($value['message']['content']) . "\r\n\r\n\r\n";
                            $counter++;
                        }
                    } else {
                        $text = ltrim($response['choices'][0]['message']['content']);
                    }
                }
                
                
                $tokens = $response['usage']['completion_tokens'];
                $plan_type = (auth()->user()->plan_id) ? 'paid' : 'free';
                
                # Update credit balance
                $this->updateBalance($tokens);

                $content = new Content();
                $content->user_id = auth()->user()->id;
                $content->model = $model;
                $content->language = $request->language;
                $content->language_name = $flag->language;
                $content->language_flag = $flag->language_flag;
                $content->template_code = $request->template;
                $content->template_name = $template->name;
                $content->icon = $template->icon;
                $content->group = $template->group;
                $content->tokens = $tokens;
                $content->plan_type = $plan_type;
                $content->save();
    
                $data['text'] = trim($text);
                $data['status'] = 'success';
                $data['old'] = auth()->user()->available_words + auth()->user()->available_words_prepaid;
                $data['current'] = auth()->user()->available_words + auth()->user()->available_words_prepaid - $tokens;
                $data['id'] = $content->id;
                return $data; 

            } else {

                if (isset($response['error']['message'])) {
                    $message = $response['error']['message'];
                } else {
                    $message = __('There is an issue with your openai account');
                }

                $data['status'] = 'error';
                $data['message'] = $message;
                return $data;
            }
           

        }
	}


    /**
	*
	* Update user word balance
	* @param - total words generated
	* @return - confirmation
	*
	*/
    public function updateBalance($words) {

        $user = User::find(Auth::user()->id);

        if (Auth::user()->available_words > $words) {

            $total_words = Auth::user()->available_words - $words;
            $user->available_words = ($total_words < 0) ? 0 : $total_words;

        } elseif (Auth::user()->available_words_prepaid > $words) {

            $total_words_prepaid = Auth::user()->available_words_prepaid - $words;
            $user->available_words_prepaid = ($total_words_prepaid < 0) ? 0 : $total_words_prepaid;

        } elseif ((Auth::user()->available_words + Auth::user()->available_words_prepaid) == $words) {

            $user->available_words = 0;
            $user->available_words_prepaid = 0;

        } else {

            $remaining = $words - Auth::user()->available_words;
            $user->available_words = 0;

            $prepaid_left = Auth::user()->available_words_prepaid - $remaining;
            $user->available_words_prepaid = ($prepaid_left < 0) ? 0 : $prepaid_left;

        }

        $user->update();

        return true;
    }


    /**
     * Check for sensitive words
     *
     * @param - input text
     * @return bool
     */
    public function check_bad_words($word, $prompt, $replaceWith)
    {
        return preg_replace("/\S*$word\S*/i", $replaceWith, trim($prompt));
    }


    /**
	*
	* Save changes
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function save(Request $request) 
    {
        if ($request->ajax()) {

            $verify = $this->api->verify_license();
            if($verify['status']!=true){return false;}

            $document = Content::where('id', request('id'))->first(); 

            if ($document->user_id == Auth::user()->id){

                $document->result_text = $request->text;
                $document->title = $request->title;
                $document->workbook = $request->workbook;
                $document->save();

                $data['status'] = 'success';
                return $data;  
    
            } else{

                $data['status'] = 'error';
                return $data;
            }  
        }
	}


    /**
	*
	* Set favorite status
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function favorite(Request $request) 
    {
        if ($request->ajax()) {

            $control = $this->user->verify_license();
            if($control['status']!=true){return false;}

            $template = Template::where('template_code', request('id'))->first(); 

            $favorite = FavoriteTemplate::where('template_code', $template->template_code)->where('user_id', auth()->user()->id)->first();

            if ($favorite) {

                $favorite->delete();

                $data['status'] = 'success';
                $data['set'] = true;
                return $data;  
    
            } else{

                $new_favorite = new FavoriteTemplate();
                $new_favorite->user_id = auth()->user()->id;
                $new_favorite->template_code = $template->template_code;
                $new_favorite->save();

                $data['status'] = 'success';
                $data['set'] = false;
                return $data; 
            }  
        }
	}


     /**
	*
	* Set favorite status
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function favoriteCustom(Request $request) 
    {
        if ($request->ajax()) {

            $control = $this->user->verify_license();
            if($control['status']!=true){return false;}

            $template = CustomTemplate::where('template_code', request('id'))->first(); 

            $favorite = FavoriteTemplate::where('template_code', $template->template_code)->where('user_id', auth()->user()->id)->first();

            if ($favorite) {

                $favorite->delete();

                $data['status'] = 'success';
                $data['set'] = true;
                return $data;  
    
            } else{

                $new_favorite = new FavoriteTemplate();
                $new_favorite->user_id = auth()->user()->id;
                $new_favorite->template_code = $template->template_code;
                $new_favorite->save();

                $data['status'] = 'success';
                $data['set'] = false;
                return $data; 
            }  
        }
	}


    /**
     * Initial settings 
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        if (!is_null(auth()->user()->plan_id)) {
            $plan = SubscriptionPlan::where('id', auth()->user()->plan_id)->first();
            $limit = $plan->max_tokens;    
        } elseif (auth()->user()->group == 'admin') {
            $limit = config('settings.max_results_limit_admin');    
        } else {
            $limit = config('settings.max_results_limit_user'); 
        }

        return $limit;
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewArticleGenerator(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'KPAQQ')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'KPAQQ')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.article-generator', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewParagraphGenerator(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'JXRZB')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'JXRZB')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.paragraph-generator', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewProsAndCons(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'OPYAB')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'OPYAB')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.pros-and-cons', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewTalkingPoints(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'VFWSQ')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'VFWSQ')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.talking-points', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewSummarizeText(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'OMMEI')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'OMMEI')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.summarize-text', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewProductDescription(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'HXLNA')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'HXLNA')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.product-description', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


     /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewStartupNameGenerator(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'DJSVM')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'DJSVM')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.startup-name-generator', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewProductNameGenerator(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'IXKBE')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'IXKBE')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.product-name-generator', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewMetaDescription(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'JCDIK')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'JCDIK')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.meta-description', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewFAQs(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'SZAUF')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'SZAUF')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.faqs', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewFAQAnswers(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'BFENK')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'BFENK')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.faq-answers', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewTestimonials(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'XLGPP')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'XLGPP')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.testimonials', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewBlogTitles(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'WGKYP')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'WGKYP')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.blog-titles', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewBlogSection(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'EEKZF')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'EEKZF')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.blog-section', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewBlogIdeas(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'KDGOX')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'KDGOX')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.blog-ideas', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewBlogIntros(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'TZTYR')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'TZTYR')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.blog-intros', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewBlogConclusion(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'ZGUKM')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'ZGUKM')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.blog-conclusion', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewContentRewriter(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'WCZGL')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'WCZGL')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.content-rewriter', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewFacebookAds(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'CTMNI')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'CTMNI')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.facebook-ads', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewVideoDescriptions(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'ZLKSP')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'ZLKSP')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.video-descriptions', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewVideoTitles(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'OJIOV')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'OJIOV')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.video-titles', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewYoutubeTagsGenerator(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'ECNVU')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'ECNVU')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.youtube-tags-generator', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewInstagramCaptions(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'EOASR')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'EOASR')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.instagram-captions', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


     /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewInstagramHashtagsGenerator(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'IEMBM')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'IEMBM')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.instagram-hashtags-generator', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewSocialPostPersonal(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'CKOHL')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'CKOHL')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.social-post-personal', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewSocialPostBusiness(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'ABWGU')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'ABWGU')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.social-post-business', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewFacebookHeadlines(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'HJYJZ')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'HJYJZ')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.facebook-headlines', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewGoogleAdsHeadlines(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'SGZTW')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'SGZTW')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.google-headlines', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


     /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewGoogleAdsDescription(Request $request)
    {   

        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'YQAFG')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'YQAFG')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.google-ads', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewPAS(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'BGXJE')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'BGXJE')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.problem-agitate-solution', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAcademicEssay(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'SXQBT')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'SXQBT')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.academic-essay', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewWelcomeEmail(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'RLXGB')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'RLXGB')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.welcome-email', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewColdEmail(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'RDJEZ')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'RDJEZ')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.cold-email', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewFollowUpEmail(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'XVNNQ')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'XVNNQ')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.follow-up-email', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCreativeStories(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'PAKMF')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'PAKMF')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.creative-stories', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewGrammarChecker(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'OORHD')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'OORHD')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.grammar-checker', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCVGenerator(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'ZJYNN')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'ZJYNN')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.cv-generator', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


     /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCoverLetter(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'GBNPP')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'GBNPP')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.cover-letter', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


     /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewSummarize2ndGrader(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'SGJLU')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'SGJLU')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.summarize-2nd-grader', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


     /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewVideoScripts(Request $request)
    {   

        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'WISHV')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'WISHV')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.video-scripts', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAmazonProduct(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = Template::where('template_code', 'WISTT')->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'WISTT')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.amazon-product', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCustomTemplate(Request $request)
    {   
        $languages = Language::orderBy('languages.language', 'asc')->get();

        $template = CustomTemplate::where('template_code', $request->code)->first();
        $favorite = FavoriteTemplate::where('user_id', auth()->user()->id)->where('template_code', 'WISTT')->first(); 
        $workbooks = Workbook::where('user_id', auth()->user()->id)->latest()->get();
        $limit = $this->settings();

        return view('user.templates.custom-template', compact('languages', 'template', 'favorite', 'workbooks', 'limit'));
    }
 

}
