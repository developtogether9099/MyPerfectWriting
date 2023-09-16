<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('plugins/slick/slick.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('plugins/slick/slick-theme.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('plugins/aos/aos.css')); ?>" rel="stylesheet" />
<style>
	.pageBg {
		 background:black;
    background-image: url("https://img.freepik.com/free-photo/3d-dark-grunge-display-background-with-smoky-atmosphere_1048-16218.jpg");
	}
    .no-arrows::-webkit-inner-spin-button,
    .no-arrows::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .no-arrows {
        -moz-appearance: textfield;
    }

    body {
        font-size: 13px;
    }

    .progress {
        height: 30px;
        margin-bottom: 20px;
    }

    .progress-bar {
        background-color: #f49d1d;
    }

    .error-tooltip {
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
    }

    .slick-dots {

        display: none !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <section id="main-wrapper">
			
            <div class="h-50vh justify-center min-h-screen pageBg">
                <div class="container" style="padding-top: 160px; padding-bottom: 100px;">
                    <div class="row h-50vh vertial-center">
                        <div class="col-md-12 col-sm-12 upload-responve">
							
                            <div class="text-container text-center">
								
                                <h3 class="my-4 font-weight-bold text-primary"><?php echo e(__('Our Prices')); ?></h3>
                             
                            </div>
                        </div>
					
                        
                    </div>
                </div>
            </div>
        </section>
    </div>


</div>


  <?php if(config('frontend.pricing_section') == 'on'): ?>
            <section id="prices-wrapper">

                <div class="container pt-9">  
                    
                    <!-- SECTION TITLE -->
                    <div class="row text-center">

                        <div class="title">
                            <h6><?php echo e(__('Various')); ?> <span><?php echo e(__('Subscription')); ?></span> <?php echo e(__('Plans')); ?></h6>
                            <p><?php echo e(__('Most competitive prices are guaranteed')); ?></p>
                        </div>

                    </div> <!-- END SECTION TITLE -->
                    
                    <div class="row">
                        <div class="card-body">			
			
                            <?php if($monthly || $yearly || $prepaid || $lifetime): ?>
                
                                <div class="tab-menu-heading text-center">
                                    <div class="tabs-menu">								
                                        <ul class="nav">
                                            <?php if($prepaid): ?>						
                                                <li><a href="#prepaid" class="<?php if(!$monthly && !$yearly && $prepaid): ?> active <?php else: ?> '' <?php endif; ?>" data-bs-toggle="tab"> <?php echo e(__('Prepaid Plans')); ?></a></li>
                                            <?php endif; ?>							
                                            <?php if($monthly): ?>
                                                <li><a href="#monthly_plans" class="<?php if(($monthly && $prepaid && $yearly) || ($monthly && !$prepaid && !$yearly) || ($monthly && $prepaid && !$yearly) || ($monthly && !$prepaid && $yearly)): ?> active <?php else: ?> '' <?php endif; ?>" data-bs-toggle="tab"> <?php echo e(__('Monthly Plans')); ?></a></li>
                                            <?php endif; ?>	
                                            <?php if($yearly): ?>
                                                <li><a href="#yearly_plans" class="<?php if(!$monthly && !$prepaid && $yearly): ?> active <?php else: ?> '' <?php endif; ?>" data-bs-toggle="tab"> <?php echo e(__('Yearly Plans')); ?></a></li>
                                            <?php endif; ?>		
                                            <?php if($lifetime): ?>
                                                <li><a href="#lifetime" class="<?php if(!$monthly && !$yearly && !$prepaid &&  $lifetime): ?> active <?php else: ?> '' <?php endif; ?>" data-bs-toggle="tab"> <?php echo e(__('Lifetime Plans')); ?></a></li>
                                            <?php endif; ?>							
                                        </ul>
                                    </div>
                                </div>
                
                            
                
                                <div class="tabs-menu-body">
                                    <div class="tab-content">
                
                                        <?php if($prepaid): ?>
                                            <div class="tab-pane <?php if((!$monthly && $prepaid) && (!$yearly && $prepaid)): ?> active <?php else: ?> '' <?php endif; ?>" id="prepaid">
                
                                                <?php if($prepaids->count()): ?>
                
                                                    <h6 class="font-weight-normal fs-12 text-center mb-6"><?php echo e(__('Top up your subscription with more credits or start with Prepaid Plans credits only')); ?></h6>
                                                    
                                                    <div class="row justify-content-md-center">
                                                    
                                                        <?php $__currentLoopData = $prepaids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prepaid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>																			
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <div class="price-card pl-3 pr-3 pt-2 mb-7">
                                                                    <div class="card border-0 p-4 pl-5">
                                                                        <div class="plan prepaid-plan">
                                                                            <div class="plan-title"><?php echo e($prepaid->plan_name); ?> <span class="prepaid-currency-sign"><?php echo e($prepaid->currency); ?></span><span class="plan-cost"><?php if(config('payment.decimal_points') == 'allow'): ?> <?php echo e(number_format((float)$prepaid->price, 2)); ?> <?php else: ?> <?php echo e(number_format($prepaid->price)); ?> <?php endif; ?></span><span class="prepaid-currency-sign"><?php echo config('payment.default_system_currency_symbol'); ?></span></div>
                                                                                <p class="fs-12 mt-2 mb-0"><?php echo e(__('Words Included')); ?>: <span class="ml-2 font-weight-bold text-primary"><?php echo e(number_format($prepaid->words)); ?></span></p>
                                                                                <p class="fs-12 mt-2 mb-0"><?php echo e(__('Images Included')); ?>: <span class="ml-2 font-weight-bold text-primary"><?php echo e(number_format($prepaid->images)); ?></span></p>
                                                                                <p class="fs-12 mt-2 mb-0"><?php echo e(__('Characters Included')); ?>: <span class="ml-2 font-weight-bold text-primary"><?php echo e(number_format($prepaid->characters)); ?></span></p>																								
																                <p class="fs-12 mt-2 mb-4"><?php echo e(__('Minutes Included')); ?>: <span class="ml-2 font-weight-bold text-primary"><?php echo e(number_format($prepaid->minutes)); ?></span></p>																									
                                                                            <div class="text-center action-button mt-2 mb-2">
                                                                                <a href="<?php echo e(route('user.prepaid.checkout', ['type' => 'prepaid', 'id' => $prepaid->id])); ?>" class="btn btn-cancel"><?php echo e(__('Purchase')); ?></a> 
                                                                            </div>
                                                                        </div>							
                                                                    </div>	
                                                                </div>							
                                                            </div>										
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>						
                
                                                    </div>
                
                                                <?php else: ?>
                                                    <div class="row text-center">
                                                        <div class="col-sm-12 mt-6 mb-6">
                                                            <h6 class="fs-12 font-weight-bold text-center"><?php echo e(__('No Prepaid plans were set yet')); ?></h6>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                
                                            </div>			
                                        <?php endif; ?>	
                
                                        <?php if($monthly): ?>	
                                            <div class="tab-pane <?php if(($monthly && $prepaid) || ($monthly && !$prepaid) || ($monthly && !$yearly)): ?> active <?php else: ?> '' <?php endif; ?>" id="monthly_plans">
                
                                                <?php if($monthly_subscriptions->count()): ?>		
                                                    
                                                    <h6 class="font-weight-normal fs-12 text-center mb-6"><?php echo e(__('Subscribe to our Monthly Subscription Plans and enjoy ton of benefits')); ?></h6>
                
                                                    <div class="row justify-content-md-center">
                
                                                        <?php $__currentLoopData = $monthly_subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>																			
                                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                                <div class="pt-2 mb-7 prices-responsive">
                                                                    <div class="card border-0 p-4 pl-5 pr-5 pt-7 price-card <?php if($subscription->featured): ?> price-card-border <?php endif; ?>">
                                                                        <?php if($subscription->featured): ?>
                                                                            <span class="plan-featured"><?php echo e(__('Most Popular')); ?></span>
                                                                        <?php endif; ?>
                                                                        <div class="plan">			
                                                                            <div class="plan-title text-center"><?php echo e($subscription->plan_name); ?></div>		
                                                                            <p class="fs-12 text-center mb-3"><?php echo e($subscription->primary_heading); ?></p>																					
                                                                            <p class="plan-cost text-center mb-0"><span class="plan-currency-sign"></span><?php echo config('payment.default_system_currency_symbol'); ?><?php if(config('payment.decimal_points') == 'allow'): ?> <?php echo e(number_format((float)$subscription->price, 2)); ?> <?php else: ?> <?php echo e(number_format($subscription->price)); ?> <?php endif; ?></p>
                                                                            <p class="fs-12 text-center mb-3"><?php echo e($subscription->currency); ?> / <?php echo e(__('Month')); ?></p>
                                                                            <div class="text-center action-button mt-2 mb-5">
                                                                                <a href="<?php echo e(route('user.plan.subscribe', $subscription->id)); ?>" class="btn btn-primary"><?php echo e(__('Subscribe Now')); ?></a>                                                														
                                                                            </div>
                                                                            <p class="fs-12 text-center mb-3"><?php echo e($subscription->secondary_heading); ?></p>																	
                                                                            <ul class="fs-12 pl-3">														
                                                                                <?php $__currentLoopData = (explode(',', $subscription->plan_features)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <?php if($feature): ?>
                                                                                        <li><i class="fa-solid fa-circle-small fs-10 text-muted"></i> <?php echo e($feature); ?></li>
                                                                                    <?php endif; ?>																
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>															
                                                                            </ul>																
                                                                        </div>					
                                                                    </div>	
                                                                </div>							
                                                            </div>										
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                                                    </div>	
                                                
                                                <?php else: ?>
                                                    <div class="row text-center">
                                                        <div class="col-sm-12 mt-6 mb-6">
                                                            <h6 class="fs-12 font-weight-bold text-center"><?php echo e(__('No Subscriptions plans were set yet')); ?></h6>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>					
                                            </div>	
                                        <?php endif; ?>	
                                        
                                        <?php if($yearly): ?>	
                                            <div class="tab-pane <?php if(($yearly && $prepaid) && ($yearly && !$prepaid) && ($yearly && !$monthly)): ?> active <?php else: ?> '' <?php endif; ?>" id="yearly_plans">
                
                                                <?php if($yearly_subscriptions->count()): ?>		
                                                    
                                                    <h6 class="font-weight-normal fs-12 text-center mb-6"><?php echo e(__('Subscribe to our Yearly Subscription Plans and enjoy ton of benefits')); ?></h6>
                
                                                    <div class="row justify-content-md-center">
                
                                                        <?php $__currentLoopData = $yearly_subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>																			
                                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                                <div class="pt-2 mb-7 prices-responsive">
                                                                    <div class="card border-0 p-4 pl-5 pr-5 pt-7 price-card <?php if($subscription->featured): ?> price-card-border <?php endif; ?>">
                                                                        <?php if($subscription->featured): ?>
                                                                            <span class="plan-featured"><?php echo e(__('Most Popular')); ?></span>
                                                                        <?php endif; ?>
                                                                        <div class="plan">			
                                                                            <div class="plan-title text-center"><?php echo e($subscription->plan_name); ?></div>		
                                                                            <p class="fs-12 text-center mb-3"><?php echo e($subscription->primary_heading); ?></p>																					
                                                                            <p class="plan-cost text-center mb-0"><span class="plan-currency-sign"></span><?php echo config('payment.default_system_currency_symbol'); ?><?php if(config('payment.decimal_points') == 'allow'): ?> <?php echo e(number_format((float)$subscription->price, 2)); ?> <?php else: ?> <?php echo e(number_format($subscription->price)); ?> <?php endif; ?></p>
                                                                            <p class="fs-12 text-center mb-3"><?php echo e($subscription->currency); ?> / <?php echo e(__('Year')); ?></p>
                                                                            <div class="text-center action-button mt-2 mb-4">          
                                                                                <a href="<?php echo e(route('user.plan.subscribe', $subscription->id)); ?>" class="btn btn-primary"><?php echo e(__('Subscribe Now')); ?></a>
                                                                           													
                                                                            </div>
                                                                            <p class="fs-12 text-center mb-3"><?php echo e($subscription->secondary_heading); ?></p>																	
                                                                            <ul class="fs-12 pl-3">														
                                                                                <?php $__currentLoopData = (explode(',', $subscription->plan_features)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <?php if($feature): ?>
                                                                                        <li><i class="fa-solid fa-circle-small fs-10 text-muted"></i> <?php echo e($feature); ?></li>
                                                                                    <?php endif; ?>																
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>															
                                                                            </ul>																
                                                                        </div>					
                                                                    </div>	
                                                                </div>							
                                                            </div>										
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                                                    </div>	
                                                
                                                <?php else: ?>
                                                    <div class="row text-center">
                                                        <div class="col-sm-12 mt-6 mb-6">
                                                            <h6 class="fs-12 font-weight-bold text-center"><?php echo e(__('No Subscriptions plans were set yet')); ?></h6>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>					
                                            </div>
                                        <?php endif; ?>	
                                        
                                        <?php if($lifetime): ?>
                                            <div class="tab-pane <?php if((!$monthly && $lifetime) && (!$yearly && $lifetime)): ?> active <?php else: ?> '' <?php endif; ?>" id="lifetime">

                                                <?php if($lifetime_subscriptions->count()): ?>

                                                    <h6 class="font-weight-normal fs-12 text-center mb-6"><?php echo e(__('Sign up and enjoy Lifetime Plans')); ?></h6>
                                                    
                                                    <div class="row justify-content-md-center">
                                                    
                                                        <?php $__currentLoopData = $lifetime_subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>																			
                                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                                    <div class="pt-2 mb-7 prices-responsive">
                                                                        <div class="card border-0 p-4 pl-5 pr-5 pt-7 price-card <?php if($subscription->featured): ?> price-card-border <?php endif; ?>">
                                                                            <?php if($subscription->featured): ?>
                                                                                <span class="plan-featured"><?php echo e(__('Most Popular')); ?></span>
                                                                            <?php endif; ?>
                                                                            <div class="plan">			
                                                                                <div class="plan-title text-center"><?php echo e(__($subscription->plan_name)); ?></div>		
                                                                                <p class="fs-12 text-center mb-3"><?php echo e(__($subscription->primary_heading)); ?></p>																					
                                                                                <p class="plan-cost text-center mb-0"><span class="plan-currency-sign"></span><?php echo config('payment.default_system_currency_symbol'); ?><?php echo e(number_format((float)$subscription->price, 2)); ?></p>
                                                                                <p class="fs-12 text-center mb-3"><?php echo e($subscription->currency); ?> / <?php echo e(__('Lifetime')); ?></p>
                                                                                <div class="text-center action-button mt-2 mb-4">
                                                                                    <a href="<?php echo e(route('user.prepaid.checkout', ['type' => 'lifetime', 'id' => $subscription->id])); ?>" class="btn btn-primary"><?php echo e(__('Subscribe Now')); ?></a>													
                                                                                </div>
                                                                                <p class="fs-12 text-center mb-3"><?php echo e(__($subscription->secondary_heading)); ?></p>																	
                                                                                <ul class="fs-12 pl-3">														
                                                                                    <?php $__currentLoopData = (explode(',', $subscription->plan_features)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                        <?php if($feature): ?>
                                                                                            <li><i class="fa-solid fa-circle-small fs-10 text-muted"></i> <?php echo e(__($feature)); ?></li>
                                                                                        <?php endif; ?>																
                                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>															
                                                                                </ul>																
                                                                            </div>					
                                                                        </div>	
                                                                    </div>							
                                                                </div>										
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>					

                                                    </div>

                                                <?php else: ?>
                                                    <div class="row text-center">
                                                        <div class="col-sm-12 mt-6 mb-6">
                                                            <h6 class="fs-12 font-weight-bold text-center"><?php echo e(__('No lifetime plans were set yet')); ?></h6>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            </div>	
                                        <?php endif; ?>	
                                    </div>
                                </div>
                            
                            <?php else: ?>
                                <div class="row text-center">
                                    <div class="col-sm-12 mt-6 mb-6">
                                        <h6 class="fs-12 font-weight-bold text-center"><?php echo e(__('No Subscriptions or Prepaid plans were set yet')); ?></h6>
                                    </div>
                                </div>
                            <?php endif; ?>
                
                        </div>
                </div>
                
                </div>
        
            </section>
        <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

   <script src="<?php echo e(URL::asset('plugins/slick/slick.min.js')); ?>"></script>  
    <script src="<?php echo e(URL::asset('plugins/aos/aos.js')); ?>"></script> 
    <script src="<?php echo e(URL::asset('plugins/typed/typed.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/frontend.js')); ?>"></script>  
    <script type="text/javascript">
		$(function () {

            var typed = new Typed('#typed', {
                strings: ['<h1><span><?php echo e(__('Fixed Pricing System')); ?></span></h1>', 
                            '<h1><span><?php echo e(__('Per Page Writing Services')); ?></span></h1>',
                            '<h1><span><?php echo e(__('Analytical Essay')); ?></span></h1>',
                            '<h1><span><?php echo e(__('Contrast Essay')); ?></span></h1>',
                            '<h1><span><?php echo e(__('Expository Essay')); ?></span></h1>',
                            '<h1><span><?php echo e(__('Narrative Essay')); ?></span></h1>',
                            '<h1><span><?php echo e(__('And Many More!')); ?></span></h1>'],
                typeSpeed: 40,
                backSpeed: 40,
                backDelay: 2000,
                loop: true,
                showCursor: false,
            });

            AOS.init();

		});    
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/prices.blade.php ENDPATH**/ ?>