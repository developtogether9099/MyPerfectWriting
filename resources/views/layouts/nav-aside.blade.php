<!-- SIDE MENU BAR -->

<aside class="app-sidebar"> 
	@role('user')
    <div class="app-sidebar__logo">
        <a class="header-brand" href="{{url('/user/dashboard')}}">
            <img src="{{URL::asset('img/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Admintro logo">
            <img src="{{URL::asset('img/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Admintro logo">
        </a>
    </div>
	@endrole

    @role('blogger')
    <div class="app-sidebar__logo">
        <a class="header-brand" href="{{ route('blogger.blogs') }}">
            <img src="{{URL::asset('img/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Admintro logo">
            <img src="{{URL::asset('img/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Admintro logo">
        </a>
    </div>
	@endrole

	@role('admin')
    <div class="app-sidebar__logo">
        <a class="header-brand" href="{{url('/admin/dashboard')}}">
            <img src="{{URL::asset('img/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Admintro logo">
            <img src="{{URL::asset('img/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Admintro logo">
        </a>
    </div>
	@endrole
	

    <ul class="side-menu app-sidebar3">
		@role('user')
		<br>
    <div style="text-align: center;">
        <a href="{{ route('user.services') }}" class="btn btn-primary mt-1 pulsating-btn" style="font-size: 15px; margin-bottom: 30px;">{{ __('Place new Order') }}</a>
    </div>
@endrole
@role('blogger')
        <li class="side-item side-item-category mt-4 mb-3">{{ __('Menu') }}</li>

		<li class="slide">
			<a class="side-menu__item"  href="{{ route('blogger.blogs') }}">
					<span class="side-menu__icon lead-3 fa-solid fa-chart-tree-map"></span>
				  <span class="side-menu__label">{{ __('Blogs') }}</span></a>
		
		</li>
        @endrole

		
       <!-- <div class="side-progress-position mt-4">
            <div class="inline-flex w-100 text-center">
                <div class="flex w-100">
                    <span class="fs-12 font-weight-bold" id="side-word-notification"><i class="fa-solid fa-scroll-old text-yellow mr-2"></i><span class="text-primary mr-1" id="available-words">{{ App\Services\HelperService::getTotalWords()}}</span> <span class="text-muted">{{ __('words left') }}</span></span>
                </div> 
                @if (is_null(auth()->user()->plan_id))                 
                    <a href="{{ route('user.plans') }}" class="btn btn-cancel-upgrade mt-3 fs-12 pl-6 pr-6"><i class="fa-solid fa-circle-bolt mr-3 fs-15 text-yellow vertical-align-middle"></i>{{ __('Upgrade') }}</a>        
                @endif                    
            </div>
        </div> 
        <li class="side-item side-item-category mt-4 mb-3">{{ __('AI Panel') }}</li>
        <li class="slide">
            <a class="side-menu__item" href="{{ route('user.dashboard') }}">
            <span class="side-menu__icon lead-3 fa-solid fa-chart-tree-map"></span>
            <span class="side-menu__label">{{ __('Dashboard') }}</span></a>
        </li> 
        <li class="slide">
            <a class="side-menu__item" href="{{ route('user.templates') }}">
            <span class="side-menu__icon lead-3 fs-18 fa-solid fa-microchip-ai"></span>
            <span class="side-menu__label">{{ __('Templates') }}</span></a>
        </li> 
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                <span class="side-menu__icon fa-solid fa-folder-bookmark"></span>
                <span class="side-menu__label">{{ __('Documents') }}</span><i class="angle fa fa-angle-right"></i></a>
                <ul class="slide-menu">
                    <li><a href="{{ route('user.documents') }}" class="slide-item">{{ __('All Documents') }}</a></li>
                    @role('user')
                        @if (config('settings.image_feature_user') == 'allow')
                            <li><a href="{{ route('user.documents.images') }}" class="slide-item">{{ __('All Images') }}</a></li> 
                        @endif 
                    @endrole
                    @role('admin|subscriber')
                        <li><a href="{{ route('user.documents.images') }}" class="slide-item">{{ __('All Images') }}</a></li>
                    @endrole
                    @role('user')
                        @if (config('settings.voiceover_feature_user') == 'allow')
                            <li><a href="{{ route('user.documents.voiceovers') }}" class="slide-item">{{ __('All Voiceovers') }}</a></li> 
                        @endif 
                    @endrole
                    @role('admin|subscriber')
                        <li><a href="{{ route('user.documents.voiceovers') }}" class="slide-item">{{ __('All Voiceovers') }}</a></li> 
                    @endrole 
                    @role('user')
                        @if (config('settings.whisper_feature_user') == 'allow')
                            <li><a href="{{ route('user.documents.transcripts') }}" class="slide-item">{{ __('All Transcripts') }}</a></li> 
                        @endif 
                    @endrole
                    @role('admin|subscriber')
                        <li><a href="{{ route('user.documents.transcripts') }}" class="slide-item">{{ __('All Transcripts') }}</a></li> 
                    @endrole
                    @role('user')
                        @if (config('settings.code_feature_user') == 'allow')
                            <li><a href="{{ route('user.documents.codes') }}" class="slide-item">{{ __('All Codes') }}</a></li> 
                        @endif 
                    @endrole
                    @role('admin|subscriber')
                        <li><a href="{{ route('user.documents.codes') }}" class="slide-item">{{ __('All Codes') }}</a></li> 
                    @endrole
                    
                    <li><a href="{{ route('user.workbooks') }}" class="slide-item">{{ __('Workbooks') }}</a></li>                    
                </ul>
        </li>
        @role('user')
            @if (config('settings.voiceover_feature_user') == 'allow')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.voiceover') }}">
                    <span class="side-menu__icon fa-sharp fa-solid fa-waveform-lines"></span>
                    <span class="side-menu__label">{{ __('AI Voiceover') }}</span></a>
                </li> 
            @endif
        @endrole
        @role('admin|subscriber')
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.voiceover') }}">
                <span class="side-menu__icon fa-sharp fa-solid fa-waveform-lines"></span>
                <span class="side-menu__label">{{ __('AI Voiceover') }}</span></a>
            </li>
        @endrole 
        @role('user')
            @if (config('settings.whisper_feature_user') == 'allow')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.transcribe') }}">
                    <span class="side-menu__icon fa-sharp fa-solid fa-folder-music"></span>
                    <span class="side-menu__label">{{ __('AI Speech to Text') }}</span></a>
                </li> 
            @endif
        @endrole
        @role('admin|subscriber')
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.transcribe') }}">
                <span class="side-menu__icon fa-sharp fa-solid fa-folder-music"></span>
                <span class="side-menu__label">{{ __('AI Speech to Text') }}</span></a>
            </li>
        @endrole 
        @role('user')
            @if (config('settings.image_feature_user') == 'allow')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.images') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-camera-viewfinder"></span>
                    <span class="side-menu__label">{{ __('AI Images') }}</span></a>
                </li> 
            @endif
        @endrole
        @role('admin|subscriber')
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.images') }}">
                <span class="side-menu__icon lead-3 fa-solid fa-camera-viewfinder"></span>
                <span class="side-menu__label">{{ __('AI Images') }}</span></a>
            </li>
        @endrole 
        @role('user')
            @if (config('settings.code_feature_user') == 'allow')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.codex') }}">
                    <span class="side-menu__icon fa-solid fa-square-code"></span>
                    <span class="side-menu__label">{{ __('AI Code') }}</span></a>
                </li> 
            @endif
        @endrole
        @role('admin|subscriber')
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.codex') }}">
                <span class="side-menu__icon fa-solid fa-square-code"></span>
                <span class="side-menu__label">{{ __('AI Code') }}</span></a>
            </li>
        @endrole 
        @role('user')
            @if (config('settings.chat_feature_user') == 'allow')
                <li class="slide mb-3">
                    <a class="side-menu__item" href="{{ route('user.chat') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-message-captions"></span>
                    <span class="side-menu__label">{{ __('AI Chat') }}</span></a>
                </li> 
            @endif
        @endrole
        @role('admin|subscriber')
            <li class="slide mb-3">
                <a class="side-menu__item" href="{{ route('user.chat') }}">
                <span class="side-menu__icon lead-3 fa-solid fa-message-captions"></span>
                <span class="side-menu__label">{{ __('AI Chat') }}</span></a>
            </li>
        @endrole -->

        @role('user')
		
		   <!-- <li class="side-item side-item-category mt-4 mb-3">{{ __('Menu') }}</li> -->
       <li class="slide">
    <a class="side-menu__item" href="{{ route('user.dashboard') }}">
        <span class="side-menu__icon lead-3 fa-solid fa-chart-tree-map"></span>
        <span class="side-menu__label">{{ __('Dashboard') }}</span>
    </a>
</li> 
		
<!-- <li class="slide">
    <a class="side-menu__item" href="{{ route('user.services') }}">
        <span class="side-menu__icon lead-3 fas fa-clipboard-list"></span>
        <span class="side-menu__label">{{ __('Order A Service') }}</span>
    </a>
</li> -->

<li class="slide">
    <a class="side-menu__item" href="{{ route('user.my_orders') }}">
        <span class="side-menu__icon lead-3 fa-solid fa-file-invoice"></span>
        <span class="side-menu__label">{{ __('My Orders') }}</span>
    </a>
</li>

<li class="slide">
    <a class="side-menu__item" href="{{ route('user.unpaid_orders') }}">
        <span class="side-menu__icon lead-3 fa-solid fa-file-invoice-dollar"></span>
        <span class="side-menu__label">{{ __('My Unpaid Orders') }}</span>
    </a>
</li>

   @endrole
		@role('user')
		 @if (config('settings.user_notification') == 'enabled')
		<li class="slide">
    <a class="side-menu__item" href="{{ route('user.notifications') }}">
        <span class="side-menu__icon lead-3 fa-solid fa-message-exclamation"></span>
        <span class="side-menu__label">{{ __('Notifications') }}</span>
    </a>
</li>
                       
                                    @if (auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count())
                                        <span class="badge badge-warning ml-3">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count() }}</span>
                                    @endif   
                                </a>
                            @endif 
		              
                      
        @if (config('settings.user_support') == 'enabled')
		<li class="slide">
    <a class="side-menu__item" href="{{ route('user.support') }}">
        <span class="side-menu__icon lead-3 fa-solid fa-messages-question"></span>
        <span class="side-menu__label">{{ __('Support Request') }}</span>
    </a>
</li>
                            @endif        
                           @if (config('payment.referral.enabled') == 'on')
	<!--	<li class="slide">
    <a class="side-menu__item" href="{{ route('user.referral') }}">
        <span class="side-menu__icon lead-3 fa-solid fa-badge-dollar"></span>
        <span class="side-menu__label">{{ __('Affiliate Program') }}</span>
    </a>
</li> -->
        @endif          
                        @endrole
        @role('admin')
            <hr class="w-90 text-center m-auto">
          <!--  <li class="side-item side-item-category mt-4 mb-3">{{ __('Admin Panel') }}</li> -->
            <li class="slide">
                <a class="side-menu__item"  href="{{ route('admin.dashboard') }}">
                    <span class="side-menu__icon fa-solid fa-chart-tree-map"></span>
                    <span class="side-menu__label">{{ __('Dashboard') }}</span>
                </a>
            </li>
           <!-- <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                        <span class="side-menu__icon fa-solid fa-microchip-ai fs-18"></span>
                        <span class="side-menu__label">{{ __('Davinci Management') }}</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.davinci.dashboard') }}" class="slide-item">{{ __('Davinci Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.davinci.templates') }}" class="slide-item">{{ __('Davinci Templates') }}</a></li>
                        <li><a href="{{ route('admin.davinci.custom') }}" class="slide-item">{{ __('Custom Templates') }}</a></li>
                        <li><a href="{{ route('admin.davinci.custom.category') }}" class="slide-item">{{ __('Template Categories') }}</a></li>
                        <li><a href="{{ route('admin.davinci.voices') }}" class="slide-item">{{ __('Voices Customization') }}</a></li>
                        <li><a href="{{ route('admin.davinci.chats') }}" class="slide-item">{{ __('AI Chats Customization') }}</a></li>
                        <li><a href="{{ route('admin.davinci.configs') }}" class="slide-item">{{ __('Davinci Settings') }}</a></li>
                    </ul>
            </li> -->
            <li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
        <span class="side-menu__icon fas fa-users"></span>
        <span class="side-menu__label">{{ __('User Management') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
            <li><a href="{{ route('admin.user.dashboard') }}" class="slide-item">{{ __('User Dashboard') }}</a></li>
            <li><a href="{{ route('admin.user.list') }}" class="slide-item">{{ __('User List') }}</a></li>
            <li><a href="{{ route('admin.user.activity') }}" class="slide-item">{{ __('Activity Monitoring') }}</a></li>
        </ul>
</li>
<li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
        <span class="side-menu__icon fas fa-pen"></span>
        <span class="side-menu__label">{{ __('Writer Management') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
            <li><a href="{{ route('admin.writers') }}" class="slide-item">{{ __('Writers List') }}</a></li>
        </ul>
</li>
<li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
        <span class="side-menu__icon fas fa-cogs"></span>
        <span class="side-menu__label">{{ __('Service Management') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
            <li><a href="{{ route('admin.services') }}" class="slide-item">{{ __('Services') }}</a></li>
            <li><a href="{{ route('admin.work_levels') }}" class="slide-item">{{ __('Work Levels') }}</a></li>
			<li><a href="{{ route('admin.subjects') }}" class="slide-item">{{ __('Subjects') }}</a></li>
			<li><a href="{{ route('admin.citations') }}" class="slide-item">{{ __('Citations') }}</a></li>
			<li><a href="{{ route('admin.packages') }}" class="slide-item">{{ __('Packages') }}</a></li>
			<li><a href="{{ route('admin.additional_services') }}" class="slide-item">{{ __('Additional Services') }}</a></li>
        </ul>
</li>
<li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
        <span class="side-menu__icon fas fa-shopping-cart"></span>
        <span class="side-menu__label">{{ __('Order Management') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
                <li><a href="{{ route('admin.orders') }}" class="slide-item">{{ __('Paid Orders List') }}</a></li>
                <li><a href="{{ route('admin.assign') }}" class="slide-item">{{ __('Assign To Writer') }}</a></li>
                <li><a href="{{ route('admin.pending_for_approval') }}" class="slide-item">{{ __('Pending For Approval') }}</a></li>
                <li><a href="{{ route('admin.requested_by_writer') }}" class="slide-item">{{ __('Requested by Writers') }}</a></li>
                <li><a href="{{ route('admin.unpaid') }}" class="slide-item">{{ __('Unpaid Orders List') }}</a></li>
			<li><a href="{{ route('admin.createOrder') }}" class="slide-item">{{ __('Create Order') }}</a></li>
        </ul>
</li>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                    <span class="side-menu__icon fa-solid fa-sack-dollar"></span>
                    <span class="side-menu__label">{{ __('Finance Management') }}</span>
                    @if (auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count())
                        <span class="badge badge-warning">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count() }}</span>
                    @else
                        <i class="angle fa fa-angle-right"></i>
                    @endif
                </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.finance.dashboard') }}" class="slide-item">{{ __('Finance Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.finance.transactions') }}" class="slide-item">{{ __('Transactions') }}</a></li>
                        <li><a href="{{ route('admin.finance.plans') }}" class="slide-item">{{ __('Subscription Plans') }}</a></li>
                        <li><a href="{{ route('admin.finance.prepaid') }}" class="slide-item">{{ __('Prepaid Plans') }}</a></li>
                        <li><a href="{{ route('admin.finance.subscriptions') }}" class="slide-item">{{ __('Subscribers') }}</a></li>
                        <li><a href="{{ route('admin.finance.promocodes') }}" class="slide-item">{{ __('Promocodes') }}</a></li>
                        <li><a href="{{ route('admin.referral.settings') }}" class="slide-item">{{ __('Referral System') }}</a></li>
                        <li><a href="{{ route('admin.referral.payouts') }}" class="slide-item">{{ __('Referral Payouts') }}
                                @if ((auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count()))
                                    <span class="badge badge-warning ml-5">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li><a href="{{ route('admin.settings.invoice') }}" class="slide-item">{{ __('Invoice Settings') }}</a></li>
                        <li><a href="{{ route('admin.finance.settings') }}" class="slide-item">{{ __('Payment Settings') }}</a></li>
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item"  href="{{ route('admin.currency_rates') }}">
                    <span class="side-menu__icon fa-solid fa-money-bill"></span>
                    <span class="side-menu__label">{{ __('Currency Rates') }}</span>
                </a>
            </li>
	
            <li class="slide">
                <a class="side-menu__item"  href="{{ route('admin.support') }}">
                    <span class="side-menu__icon fa-solid fa-message-question"></span>
                    <span class="side-menu__label">{{ __('Support Requests') }}</span>
                    @if (App\Models\SupportTicket::where('status', 'Open')->count())
                        <span class="badge badge-warning">{{ App\Models\SupportTicket::where('status', 'Open')->count() }}</span>
                    @endif 
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                    <span class="side-menu__icon fa-solid fa-message-exclamation"></span>
                    <span class="side-menu__label">{{ __('Notifications') }}</span>
                        @if (auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count())
                            <span class="badge badge-warning" id="total-notifications-a"></span>
                        @else
                            <i class="angle fa fa-angle-right"></i>
                        @endif
                    </a>                     
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.notifications') }}" class="slide-item">{{ __('Mass Notifications') }}</a></li>
						<li><a href="{{ route('admin.emails') }}" class="slide-item">{{ __('Emails Data') }}</a></li>
                        <li><a href="{{ route('admin.notifications.system') }}" class="slide-item">{{ __('System Notifications') }} 
                                @if ((auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count()))
                                    <span class="badge badge-warning ml-5" id="total-notifications-b"></span>
                                @endif
                            </a>
                        </li>
                    </ul>
            </li>
		
		 
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                    <span class="side-menu__icon fa-solid fa-earth-americas"></span>
                    <span class="side-menu__label">{{ __('Frontend Management') }}</span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.settings.frontend') }}" class="slide-item">{{ __('Frontend Settings') }}</a></li>
                        <li><a href="{{ route('admin.settings.appearance') }}" class="slide-item">{{ __('SEO & Logos') }}</a></li>                        
                        <li><a href="{{ route('admin.settings.blog') }}" class="slide-item">{{ __('Blogs Manager') }}</a></li>
						<li><a href="{{ route('blogger.blogs') }}" class="slide-item">{{ __('Blog Writers') }}</a></li> 
						
                        <li><a href="{{ route('admin.settings.faq') }}" class="slide-item">{{ __('FAQs Manager') }}</a></li>
                        <li><a href="{{ route('admin.settings.review') }}" class="slide-item">{{ __('Reviews Manager') }}</a></li>
                        <li><a href="{{ route('admin.settings.terms') }}" class="slide-item">{{ __('T&C Pages Manager') }}</a></li>                                  
                        <li><a href="{{ route('admin.settings.adsense') }}" class="slide-item">{{ __('Google Adsense') }}</a></li>                         <li><a href="{{ route('admin.settings.service') }}" class="slide-item">{{ __('Services Manager') }}</a></li> 
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                    <span class="side-menu__icon fa fa-sliders"></span>
                    <span class="side-menu__label">{{ __('General Settings') }}</span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.settings.global') }}" class="slide-item">{{ __('Global Settings') }}</a></li>
                        <li><a href="{{ route('admin.settings.oauth') }}" class="slide-item">{{ __('Auth Settings') }}</a></li>
                        <li><a href="{{ route('admin.settings.registration') }}" class="slide-item">{{ __('Registration Settings') }}</a></li>
                        <li><a href="{{ route('admin.settings.smtp') }}" class="slide-item">{{ __('SMTP Settings') }}</a></li>
                      <!--  <li><a href="{{ route('admin.settings.backup') }}" class="slide-item">{{ __('Database Backup') }}</a></li>
                        <li><a href="{{ route('admin.settings.activation') }}" class="slide-item">{{ __('Activation') }}</a></li>     
                        <li><a href="{{ route('admin.settings.upgrade') }}" class="slide-item">{{ __('Upgrade Software') }}</a></li>   -->              
                        <li><a href="{{ route('admin.settings.clear') }}" class="slide-item">{{ __('Clear Cache') }}</a></li>                 
                    </ul>
            </li>
        @endrole
    </ul>
</aside>
<!-- END SIDE MENU BAR -->