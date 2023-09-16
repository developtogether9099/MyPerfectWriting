<!-- SIDE MENU BAR -->

<aside class="app-sidebar"> 
	<?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
    <div class="app-sidebar__logo">
        <a class="header-brand" href="<?php echo e(url('/user/dashboard')); ?>">
            <img src="<?php echo e(URL::asset('img/brand/logo.png')); ?>" class="header-brand-img desktop-lgo" alt="Admintro logo">
            <img src="<?php echo e(URL::asset('img/brand/favicon.png')); ?>" class="header-brand-img mobile-logo" alt="Admintro logo">
        </a>
    </div>
	<?php endif; ?>

    <?php if(auth()->check() && auth()->user()->hasRole('blogger')): ?>
    <div class="app-sidebar__logo">
        <a class="header-brand" href="<?php echo e(route('blogger.blogs')); ?>">
            <img src="<?php echo e(URL::asset('img/brand/logo.png')); ?>" class="header-brand-img desktop-lgo" alt="Admintro logo">
            <img src="<?php echo e(URL::asset('img/brand/favicon.png')); ?>" class="header-brand-img mobile-logo" alt="Admintro logo">
        </a>
    </div>
	<?php endif; ?>

	<?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
    <div class="app-sidebar__logo">
        <a class="header-brand" href="<?php echo e(url('/admin/dashboard')); ?>">
            <img src="<?php echo e(URL::asset('img/brand/logo.png')); ?>" class="header-brand-img desktop-lgo" alt="Admintro logo">
            <img src="<?php echo e(URL::asset('img/brand/favicon.png')); ?>" class="header-brand-img mobile-logo" alt="Admintro logo">
        </a>
    </div>
	<?php endif; ?>
	

    <ul class="side-menu app-sidebar3">
		<?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
		<br>
    <div style="text-align: center;">
        <a href="<?php echo e(route('user.services')); ?>" class="btn btn-primary mt-1 pulsating-btn" style="font-size: 15px; margin-bottom: 30px;"><?php echo e(__('Place new Order')); ?></a>
    </div>
<?php endif; ?>
<?php if(auth()->check() && auth()->user()->hasRole('blogger')): ?>
        <li class="side-item side-item-category mt-4 mb-3"><?php echo e(__('Menu')); ?></li>

		<li class="slide">
			<a class="side-menu__item"  href="<?php echo e(route('blogger.blogs')); ?>">
					<span class="side-menu__icon lead-3 fa-solid fa-chart-tree-map"></span>
				  <span class="side-menu__label"><?php echo e(__('Blogs')); ?></span></a>
		
		</li>
        <?php endif; ?>

		
       <!-- <div class="side-progress-position mt-4">
            <div class="inline-flex w-100 text-center">
                <div class="flex w-100">
                    <span class="fs-12 font-weight-bold" id="side-word-notification"><i class="fa-solid fa-scroll-old text-yellow mr-2"></i><span class="text-primary mr-1" id="available-words"><?php echo e(App\Services\HelperService::getTotalWords()); ?></span> <span class="text-muted"><?php echo e(__('words left')); ?></span></span>
                </div> 
                <?php if(is_null(auth()->user()->plan_id)): ?>                 
                    <a href="<?php echo e(route('user.plans')); ?>" class="btn btn-cancel-upgrade mt-3 fs-12 pl-6 pr-6"><i class="fa-solid fa-circle-bolt mr-3 fs-15 text-yellow vertical-align-middle"></i><?php echo e(__('Upgrade')); ?></a>        
                <?php endif; ?>                    
            </div>
        </div> 
        <li class="side-item side-item-category mt-4 mb-3"><?php echo e(__('AI Panel')); ?></li>
        <li class="slide">
            <a class="side-menu__item" href="<?php echo e(route('user.dashboard')); ?>">
            <span class="side-menu__icon lead-3 fa-solid fa-chart-tree-map"></span>
            <span class="side-menu__label"><?php echo e(__('Dashboard')); ?></span></a>
        </li> 
        <li class="slide">
            <a class="side-menu__item" href="<?php echo e(route('user.templates')); ?>">
            <span class="side-menu__icon lead-3 fs-18 fa-solid fa-microchip-ai"></span>
            <span class="side-menu__label"><?php echo e(__('Templates')); ?></span></a>
        </li> 
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                <span class="side-menu__icon fa-solid fa-folder-bookmark"></span>
                <span class="side-menu__label"><?php echo e(__('Documents')); ?></span><i class="angle fa fa-angle-right"></i></a>
                <ul class="slide-menu">
                    <li><a href="<?php echo e(route('user.documents')); ?>" class="slide-item"><?php echo e(__('All Documents')); ?></a></li>
                    <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
                        <?php if(config('settings.image_feature_user') == 'allow'): ?>
                            <li><a href="<?php echo e(route('user.documents.images')); ?>" class="slide-item"><?php echo e(__('All Images')); ?></a></li> 
                        <?php endif; ?> 
                    <?php endif; ?>
                    <?php if(auth()->check() && auth()->user()->hasRole('admin|subscriber')): ?>
                        <li><a href="<?php echo e(route('user.documents.images')); ?>" class="slide-item"><?php echo e(__('All Images')); ?></a></li>
                    <?php endif; ?>
                    <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
                        <?php if(config('settings.voiceover_feature_user') == 'allow'): ?>
                            <li><a href="<?php echo e(route('user.documents.voiceovers')); ?>" class="slide-item"><?php echo e(__('All Voiceovers')); ?></a></li> 
                        <?php endif; ?> 
                    <?php endif; ?>
                    <?php if(auth()->check() && auth()->user()->hasRole('admin|subscriber')): ?>
                        <li><a href="<?php echo e(route('user.documents.voiceovers')); ?>" class="slide-item"><?php echo e(__('All Voiceovers')); ?></a></li> 
                    <?php endif; ?> 
                    <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
                        <?php if(config('settings.whisper_feature_user') == 'allow'): ?>
                            <li><a href="<?php echo e(route('user.documents.transcripts')); ?>" class="slide-item"><?php echo e(__('All Transcripts')); ?></a></li> 
                        <?php endif; ?> 
                    <?php endif; ?>
                    <?php if(auth()->check() && auth()->user()->hasRole('admin|subscriber')): ?>
                        <li><a href="<?php echo e(route('user.documents.transcripts')); ?>" class="slide-item"><?php echo e(__('All Transcripts')); ?></a></li> 
                    <?php endif; ?>
                    <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
                        <?php if(config('settings.code_feature_user') == 'allow'): ?>
                            <li><a href="<?php echo e(route('user.documents.codes')); ?>" class="slide-item"><?php echo e(__('All Codes')); ?></a></li> 
                        <?php endif; ?> 
                    <?php endif; ?>
                    <?php if(auth()->check() && auth()->user()->hasRole('admin|subscriber')): ?>
                        <li><a href="<?php echo e(route('user.documents.codes')); ?>" class="slide-item"><?php echo e(__('All Codes')); ?></a></li> 
                    <?php endif; ?>
                    
                    <li><a href="<?php echo e(route('user.workbooks')); ?>" class="slide-item"><?php echo e(__('Workbooks')); ?></a></li>                    
                </ul>
        </li>
        <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
            <?php if(config('settings.voiceover_feature_user') == 'allow'): ?>
                <li class="slide">
                    <a class="side-menu__item" href="<?php echo e(route('user.voiceover')); ?>">
                    <span class="side-menu__icon fa-sharp fa-solid fa-waveform-lines"></span>
                    <span class="side-menu__label"><?php echo e(__('AI Voiceover')); ?></span></a>
                </li> 
            <?php endif; ?>
        <?php endif; ?>
        <?php if(auth()->check() && auth()->user()->hasRole('admin|subscriber')): ?>
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('user.voiceover')); ?>">
                <span class="side-menu__icon fa-sharp fa-solid fa-waveform-lines"></span>
                <span class="side-menu__label"><?php echo e(__('AI Voiceover')); ?></span></a>
            </li>
        <?php endif; ?> 
        <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
            <?php if(config('settings.whisper_feature_user') == 'allow'): ?>
                <li class="slide">
                    <a class="side-menu__item" href="<?php echo e(route('user.transcribe')); ?>">
                    <span class="side-menu__icon fa-sharp fa-solid fa-folder-music"></span>
                    <span class="side-menu__label"><?php echo e(__('AI Speech to Text')); ?></span></a>
                </li> 
            <?php endif; ?>
        <?php endif; ?>
        <?php if(auth()->check() && auth()->user()->hasRole('admin|subscriber')): ?>
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('user.transcribe')); ?>">
                <span class="side-menu__icon fa-sharp fa-solid fa-folder-music"></span>
                <span class="side-menu__label"><?php echo e(__('AI Speech to Text')); ?></span></a>
            </li>
        <?php endif; ?> 
        <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
            <?php if(config('settings.image_feature_user') == 'allow'): ?>
                <li class="slide">
                    <a class="side-menu__item" href="<?php echo e(route('user.images')); ?>">
                    <span class="side-menu__icon lead-3 fa-solid fa-camera-viewfinder"></span>
                    <span class="side-menu__label"><?php echo e(__('AI Images')); ?></span></a>
                </li> 
            <?php endif; ?>
        <?php endif; ?>
        <?php if(auth()->check() && auth()->user()->hasRole('admin|subscriber')): ?>
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('user.images')); ?>">
                <span class="side-menu__icon lead-3 fa-solid fa-camera-viewfinder"></span>
                <span class="side-menu__label"><?php echo e(__('AI Images')); ?></span></a>
            </li>
        <?php endif; ?> 
        <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
            <?php if(config('settings.code_feature_user') == 'allow'): ?>
                <li class="slide">
                    <a class="side-menu__item" href="<?php echo e(route('user.codex')); ?>">
                    <span class="side-menu__icon fa-solid fa-square-code"></span>
                    <span class="side-menu__label"><?php echo e(__('AI Code')); ?></span></a>
                </li> 
            <?php endif; ?>
        <?php endif; ?>
        <?php if(auth()->check() && auth()->user()->hasRole('admin|subscriber')): ?>
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('user.codex')); ?>">
                <span class="side-menu__icon fa-solid fa-square-code"></span>
                <span class="side-menu__label"><?php echo e(__('AI Code')); ?></span></a>
            </li>
        <?php endif; ?> 
        <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
            <?php if(config('settings.chat_feature_user') == 'allow'): ?>
                <li class="slide mb-3">
                    <a class="side-menu__item" href="<?php echo e(route('user.chat')); ?>">
                    <span class="side-menu__icon lead-3 fa-solid fa-message-captions"></span>
                    <span class="side-menu__label"><?php echo e(__('AI Chat')); ?></span></a>
                </li> 
            <?php endif; ?>
        <?php endif; ?>
        <?php if(auth()->check() && auth()->user()->hasRole('admin|subscriber')): ?>
            <li class="slide mb-3">
                <a class="side-menu__item" href="<?php echo e(route('user.chat')); ?>">
                <span class="side-menu__icon lead-3 fa-solid fa-message-captions"></span>
                <span class="side-menu__label"><?php echo e(__('AI Chat')); ?></span></a>
            </li>
        <?php endif; ?> -->

        <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
		
		   <!-- <li class="side-item side-item-category mt-4 mb-3"><?php echo e(__('Menu')); ?></li> -->
       <li class="slide">
    <a class="side-menu__item" href="<?php echo e(route('user.dashboard')); ?>">
        <span class="side-menu__icon lead-3 fa-solid fa-chart-tree-map"></span>
        <span class="side-menu__label"><?php echo e(__('Dashboard')); ?></span>
    </a>
</li> 
		
<!-- <li class="slide">
    <a class="side-menu__item" href="<?php echo e(route('user.services')); ?>">
        <span class="side-menu__icon lead-3 fas fa-clipboard-list"></span>
        <span class="side-menu__label"><?php echo e(__('Order A Service')); ?></span>
    </a>
</li> -->

<li class="slide">
    <a class="side-menu__item" href="<?php echo e(route('user.my_orders')); ?>">
        <span class="side-menu__icon lead-3 fa-solid fa-file-invoice"></span>
        <span class="side-menu__label"><?php echo e(__('My Orders')); ?></span>
    </a>
</li>

<li class="slide">
    <a class="side-menu__item" href="<?php echo e(route('user.unpaid_orders')); ?>">
        <span class="side-menu__icon lead-3 fa-solid fa-file-invoice-dollar"></span>
        <span class="side-menu__label"><?php echo e(__('My Unpaid Orders')); ?></span>
    </a>
</li>

   <?php endif; ?>
		<?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
		 <?php if(config('settings.user_notification') == 'enabled'): ?>
		<li class="slide">
    <a class="side-menu__item" href="<?php echo e(route('user.notifications')); ?>">
        <span class="side-menu__icon lead-3 fa-solid fa-message-exclamation"></span>
        <span class="side-menu__label"><?php echo e(__('Notifications')); ?></span>
    </a>
</li>
                       
                                    <?php if(auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count()): ?>
                                        <span class="badge badge-warning ml-3"><?php echo e(auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count()); ?></span>
                                    <?php endif; ?>   
                                </a>
                            <?php endif; ?> 
		              
                      
        <?php if(config('settings.user_support') == 'enabled'): ?>
		<li class="slide">
    <a class="side-menu__item" href="<?php echo e(route('user.support')); ?>">
        <span class="side-menu__icon lead-3 fa-solid fa-messages-question"></span>
        <span class="side-menu__label"><?php echo e(__('Support Request')); ?></span>
    </a>
</li>
                            <?php endif; ?>        
                           <?php if(config('payment.referral.enabled') == 'on'): ?>
	<!--	<li class="slide">
    <a class="side-menu__item" href="<?php echo e(route('user.referral')); ?>">
        <span class="side-menu__icon lead-3 fa-solid fa-badge-dollar"></span>
        <span class="side-menu__label"><?php echo e(__('Affiliate Program')); ?></span>
    </a>
</li> -->
        <?php endif; ?>          
                        <?php endif; ?>
        <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
            <hr class="w-90 text-center m-auto">
          <!--  <li class="side-item side-item-category mt-4 mb-3"><?php echo e(__('Admin Panel')); ?></li> -->
            <li class="slide">
                <a class="side-menu__item"  href="<?php echo e(route('admin.dashboard')); ?>">
                    <span class="side-menu__icon fa-solid fa-chart-tree-map"></span>
                    <span class="side-menu__label"><?php echo e(__('Dashboard')); ?></span>
                </a>
            </li>
           <!-- <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                        <span class="side-menu__icon fa-solid fa-microchip-ai fs-18"></span>
                        <span class="side-menu__label"><?php echo e(__('Davinci Management')); ?></span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.davinci.dashboard')); ?>" class="slide-item"><?php echo e(__('Davinci Dashboard')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.davinci.templates')); ?>" class="slide-item"><?php echo e(__('Davinci Templates')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.davinci.custom')); ?>" class="slide-item"><?php echo e(__('Custom Templates')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.davinci.custom.category')); ?>" class="slide-item"><?php echo e(__('Template Categories')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.davinci.voices')); ?>" class="slide-item"><?php echo e(__('Voices Customization')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.davinci.chats')); ?>" class="slide-item"><?php echo e(__('AI Chats Customization')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.davinci.configs')); ?>" class="slide-item"><?php echo e(__('Davinci Settings')); ?></a></li>
                    </ul>
            </li> -->
            <li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
        <span class="side-menu__icon fas fa-users"></span>
        <span class="side-menu__label"><?php echo e(__('User Management')); ?></span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
            <li><a href="<?php echo e(route('admin.user.dashboard')); ?>" class="slide-item"><?php echo e(__('User Dashboard')); ?></a></li>
            <li><a href="<?php echo e(route('admin.user.list')); ?>" class="slide-item"><?php echo e(__('User List')); ?></a></li>
            <li><a href="<?php echo e(route('admin.user.activity')); ?>" class="slide-item"><?php echo e(__('Activity Monitoring')); ?></a></li>
        </ul>
</li>
<li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
        <span class="side-menu__icon fas fa-pen"></span>
        <span class="side-menu__label"><?php echo e(__('Writer Management')); ?></span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
            <li><a href="<?php echo e(route('admin.writers')); ?>" class="slide-item"><?php echo e(__('Writers List')); ?></a></li>
        </ul>
</li>
<li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
        <span class="side-menu__icon fas fa-cogs"></span>
        <span class="side-menu__label"><?php echo e(__('Service Management')); ?></span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
            <li><a href="<?php echo e(route('admin.services')); ?>" class="slide-item"><?php echo e(__('Services')); ?></a></li>
            <li><a href="<?php echo e(route('admin.work_levels')); ?>" class="slide-item"><?php echo e(__('Work Levels')); ?></a></li>
			<li><a href="<?php echo e(route('admin.subjects')); ?>" class="slide-item"><?php echo e(__('Subjects')); ?></a></li>
			<li><a href="<?php echo e(route('admin.citations')); ?>" class="slide-item"><?php echo e(__('Citations')); ?></a></li>
			<li><a href="<?php echo e(route('admin.packages')); ?>" class="slide-item"><?php echo e(__('Packages')); ?></a></li>
			<li><a href="<?php echo e(route('admin.additional_services')); ?>" class="slide-item"><?php echo e(__('Additional Services')); ?></a></li>
        </ul>
</li>
<li class="slide">
    <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
        <span class="side-menu__icon fas fa-shopping-cart"></span>
        <span class="side-menu__label"><?php echo e(__('Order Management')); ?></span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
                <li><a href="<?php echo e(route('admin.orders')); ?>" class="slide-item"><?php echo e(__('Paid Orders List')); ?></a></li>
                <li><a href="<?php echo e(route('admin.assign')); ?>" class="slide-item"><?php echo e(__('Assign To Writer')); ?></a></li>
                <li><a href="<?php echo e(route('admin.pending_for_approval')); ?>" class="slide-item"><?php echo e(__('Pending For Approval')); ?></a></li>
                <li><a href="<?php echo e(route('admin.requested_by_writer')); ?>" class="slide-item"><?php echo e(__('Requested by Writers')); ?></a></li>
                <li><a href="<?php echo e(route('admin.unpaid')); ?>" class="slide-item"><?php echo e(__('Unpaid Orders List')); ?></a></li>
			<li><a href="<?php echo e(route('admin.createOrder')); ?>" class="slide-item"><?php echo e(__('Create Order')); ?></a></li>
        </ul>
</li>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                    <span class="side-menu__icon fa-solid fa-sack-dollar"></span>
                    <span class="side-menu__label"><?php echo e(__('Finance Management')); ?></span>
                    <?php if(auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count()): ?>
                        <span class="badge badge-warning"><?php echo e(auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count()); ?></span>
                    <?php else: ?>
                        <i class="angle fa fa-angle-right"></i>
                    <?php endif; ?>
                </a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.finance.dashboard')); ?>" class="slide-item"><?php echo e(__('Finance Dashboard')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.transactions')); ?>" class="slide-item"><?php echo e(__('Transactions')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.plans')); ?>" class="slide-item"><?php echo e(__('Subscription Plans')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.prepaid')); ?>" class="slide-item"><?php echo e(__('Prepaid Plans')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.subscriptions')); ?>" class="slide-item"><?php echo e(__('Subscribers')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.promocodes')); ?>" class="slide-item"><?php echo e(__('Promocodes')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.referral.settings')); ?>" class="slide-item"><?php echo e(__('Referral System')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.referral.payouts')); ?>" class="slide-item"><?php echo e(__('Referral Payouts')); ?>

                                <?php if((auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count())): ?>
                                    <span class="badge badge-warning ml-5"><?php echo e(auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count()); ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li><a href="<?php echo e(route('admin.settings.invoice')); ?>" class="slide-item"><?php echo e(__('Invoice Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.settings')); ?>" class="slide-item"><?php echo e(__('Payment Settings')); ?></a></li>
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item"  href="<?php echo e(route('admin.currency_rates')); ?>">
                    <span class="side-menu__icon fa-solid fa-money-bill"></span>
                    <span class="side-menu__label"><?php echo e(__('Currency Rates')); ?></span>
                </a>
            </li>
	
            <li class="slide">
                <a class="side-menu__item"  href="<?php echo e(route('admin.support')); ?>">
                    <span class="side-menu__icon fa-solid fa-message-question"></span>
                    <span class="side-menu__label"><?php echo e(__('Support Requests')); ?></span>
                    <?php if(App\Models\SupportTicket::where('status', 'Open')->count()): ?>
                        <span class="badge badge-warning"><?php echo e(App\Models\SupportTicket::where('status', 'Open')->count()); ?></span>
                    <?php endif; ?> 
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                    <span class="side-menu__icon fa-solid fa-message-exclamation"></span>
                    <span class="side-menu__label"><?php echo e(__('Notifications')); ?></span>
                        <?php if(auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count()): ?>
                            <span class="badge badge-warning" id="total-notifications-a"></span>
                        <?php else: ?>
                            <i class="angle fa fa-angle-right"></i>
                        <?php endif; ?>
                    </a>                     
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.notifications')); ?>" class="slide-item"><?php echo e(__('Mass Notifications')); ?></a></li>
						<li><a href="<?php echo e(route('admin.emails')); ?>" class="slide-item"><?php echo e(__('Emails Data')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.notifications.system')); ?>" class="slide-item"><?php echo e(__('System Notifications')); ?> 
                                <?php if((auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count())): ?>
                                    <span class="badge badge-warning ml-5" id="total-notifications-b"></span>
                                <?php endif; ?>
                            </a>
                        </li>
                    </ul>
            </li>
		
		 
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                    <span class="side-menu__icon fa-solid fa-earth-americas"></span>
                    <span class="side-menu__label"><?php echo e(__('Frontend Management')); ?></span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.settings.frontend')); ?>" class="slide-item"><?php echo e(__('Frontend Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.appearance')); ?>" class="slide-item"><?php echo e(__('SEO & Logos')); ?></a></li>                        
                        <li><a href="<?php echo e(route('admin.settings.blog')); ?>" class="slide-item"><?php echo e(__('Blogs Manager')); ?></a></li>
						<li><a href="<?php echo e(route('blogger.blogs')); ?>" class="slide-item"><?php echo e(__('Blog Writers')); ?></a></li> 
						
                        <li><a href="<?php echo e(route('admin.settings.faq')); ?>" class="slide-item"><?php echo e(__('FAQs Manager')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.review')); ?>" class="slide-item"><?php echo e(__('Reviews Manager')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.terms')); ?>" class="slide-item"><?php echo e(__('T&C Pages Manager')); ?></a></li>                                  
                        <li><a href="<?php echo e(route('admin.settings.adsense')); ?>" class="slide-item"><?php echo e(__('Google Adsense')); ?></a></li>                         <li><a href="<?php echo e(route('admin.settings.service')); ?>" class="slide-item"><?php echo e(__('Services Manager')); ?></a></li> 
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                    <span class="side-menu__icon fa fa-sliders"></span>
                    <span class="side-menu__label"><?php echo e(__('General Settings')); ?></span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.settings.global')); ?>" class="slide-item"><?php echo e(__('Global Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.oauth')); ?>" class="slide-item"><?php echo e(__('Auth Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.registration')); ?>" class="slide-item"><?php echo e(__('Registration Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.smtp')); ?>" class="slide-item"><?php echo e(__('SMTP Settings')); ?></a></li>
                      <!--  <li><a href="<?php echo e(route('admin.settings.backup')); ?>" class="slide-item"><?php echo e(__('Database Backup')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.activation')); ?>" class="slide-item"><?php echo e(__('Activation')); ?></a></li>     
                        <li><a href="<?php echo e(route('admin.settings.upgrade')); ?>" class="slide-item"><?php echo e(__('Upgrade Software')); ?></a></li>   -->              
                        <li><a href="<?php echo e(route('admin.settings.clear')); ?>" class="slide-item"><?php echo e(__('Clear Cache')); ?></a></li>                 
                    </ul>
            </li>
        <?php endif; ?>
    </ul>
</aside>
<!-- END SIDE MENU BAR --><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/layouts/nav-aside.blade.php ENDPATH**/ ?>