<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('plugins/slick/slick.css')); ?>" rel="stylesheet" />
	<link href="<?php echo e(URL::asset('plugins/slick/slick-theme.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('plugins/aos/aos.css')); ?>" rel="stylesheet" />


    <script src="https://www.youtube.com/iframe_api"></script>

<style>
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
   .text-container h1 {
	  font-size: 50px !important; 
	}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12" >
        <section id="main-wrapper">
            <div class="h-100vh justify-center min-h-screen" id="main-background">
                <div class="container h-100vh" style="padding: 20px;">
                    <div class="row h-100vh vertical-center">
                        <div class="col-sm-8 upload-responsive">
                            <div class="text-container">
                                <h3 class="mb-4 font-weight-bold text-white" data-aos="fade-left" data-aos-delay="400" data-aos-once="true" data-aos-duration="700"><?php echo e(__('Meet')); ?>, <?php echo e(config('app.name')); ?></h3>
                                <h1 class="text-white" data-aos="fade-left" data-aos-delay="500" data-aos-once="true" data-aos-duration="700"><?php echo e(__('The Future of Essay Writing')); ?></h1>
                                <h1 class="mb-0 gradient fixed-height" id="typed" data-aos="fade-left" data-aos-delay="600" data-aos-once="true" data-aos-duration="900"></h1>
                                <p class="fs-18 text-white" data-aos="fade-left" data-aos-delay="700" data-aos-once="true" data-aos-duration="1100"> Get Academic Writing Service Only <i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i><?php echo e(format_amount(6.99)['amount']); ?>/page </p>
                                <a href="<?php echo e(route('register')); ?>" class="btn btn-primary special-action-button" data-aos="fade-left" data-aos-delay="800" data-aos-once="true" data-aos-duration="1100"><?php echo e(__('Write My Essay Now')); ?></a>
                            </div>
							 
                                        
                                        <div style="margin-top: 30px;">
                                            <img src="<?php echo e(URL::asset('img/files/tp.png')); ?>" alt="" style="width: 20%; margin-right: 20px;">
											<img src="<?php echo e(URL::asset('img/files/tp.png')); ?>" alt="" style="width: 20%; margin-right: 20px;">
											<img src="<?php echo e(URL::asset('img/files/tp.png')); ?>" alt="" style="width: 20%;">
                                        </div>
                                   
                        </div>
						<div class="col-sm-4 upload-responsive">
						     <div class="card border-0 " style="background-color: #3C3465;">
                        <div class="card-body p-2 ">
                            <!-- BOX CONTENT -->
                            <div class="box-content" style="color: #ffffff;">
                                <form id="submit-order" method="post" enctype="multipart/form-data" class="row">
                                    <?php echo csrf_field(); ?>
                                    <div class="col-md-12">
                                        <h4 class="mt-1 page-title text-center" style="color: #f49d1d;">Calculate Price</h4>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group ">
                                            <select name="service_id" class="form-control" id="f-service" required>
                                                <option value="" disabled selected>What can we do for you?</option>
                                                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <select name="work_level_id" class="form-control" id="f-wl" required>
                                                <option value="" disabled selected>You study at?</option>
                                                <?php $__currentLoopData = $work_levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($wl->id); ?>"><?php echo e($wl->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="pp" value="<?php echo e(format_amount(6.99)['amount']); ?>">
                                    <input type="hidden" id="today" name="today">
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label for="quantity">Number of pages</label>
                                            <div class="d-flex">
                                                <a id="dec" class="bg-primary p-2 rounded mr-3 text-white" style="cursor:pointer">-</a>
                                                <input type="number" name="qty" class="text-center no-arrows" id="quantity" value="1" min="1" style="width:100%; border:none">
                                                <a id="inc" class="bg-primary p-2 rounded ml-3 text-white" style="cursor:pointer">+</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 mt-2">
                                        <div class="form-group">
                                            <label for="deadline-date">Deadline Date</label>
                                            <input type="date" name="deadline_date" id="deadline-date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 mt-2">
                                        <div class="form-group">
                                            <label for="deadline-time">Time</label>
                                            <select name="deadline_time" id="deadline-time" class="form-control" required>
                                                <?php
                                                    $currentHour = date('H');
                                                    $currentMinute = (int) date('i');
                                                    $currentMinute = $currentMinute - ($currentMinute % 15); // Round down to the nearest 15 minutes
                                                ?>
                                                <?php for($hour = 0; $hour < 24; $hour++): ?>
                                                    <?php for($minute=0; $minute < 60; $minute +=15): ?>
                                                        <?php
                                                            $optionValue = sprintf('%02d:%02d', $hour, $minute);
                                                            $disabled = ($hour < $currentHour || ($hour === $currentHour && $minute < $currentMinute)) ? 'disabled' : '';
                                                            $selected = ($hour === $currentHour && $minute === $currentMinute) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo e($optionValue); ?>" <?php echo e($disabled); ?> <?php echo e($selected); ?>>
                                                            <?php echo e($optionValue); ?>

                                                        </option>
                                                    <?php endfor; ?>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="delivery-time" class="col-md-12 mt-2 text-center" style="display: none;">
                                        <p>
                                            <i class="fas fa-info-circle"></i> Your order will be delivered within
                                            <span id="delivery-days"></span> days and
                                            <span id="delivery-hours"></span> hours.
                                        </p>
                                    </div>
							
                                    <div class="col-lg-12 col-md-12 col-sm-12">
											<br>
                                        <div class="card border-0 mt-1" style="background-color: #000000;">
                                            <div class="card-body">
                                                <!-- BOX CONTENT -->
                                                <div class="box-content" style="color: #ffffff;">
                                                  
                                                        <h4 class="mb-2 page-title text-center" style="color: #f49d1d;">Totals</h4>
                                               
                                                    <p class="text-left">Total Amount <span class="float-right"> <i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i><span id="total">0</span></span>  </p>
                                                    <p class="text-left">No. of Pages <span class="float-right" id="qty">0</span>  </p>
													<div style="width:220px; margin:0 auto">
												
														<a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary"><i class="fas fa-video"></i> Play Video</a>
														<?php if(auth()->user()): ?>
															<a href="<?php echo e(route('user.services')); ?>" class="btn btn-primary">Write My Essay</a>
														<?php else: ?>
															<a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Write My Essay</a>
														<?php endif; ?>
													</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
						 </div>
                    </div>
                </div>
            </div> 
        </section>
    </div>
	

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     
<iframe id="youtube-player" width="100%" height="315" src="https://myperfectwriting.co.uk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>


      </div>
 
    </div>
  </div>
</div>

<!-- SECTION - BANNER
        ========================================================-->
        <section id="banner-wrapper">

            <div class="container">

                <!-- SECTION TITLE -->
                <div class="row mb-7 text-center">

                    <div class="title">
                        <h6><?php echo e(__('Our')); ?> <span><?php echo e(__('Partners')); ?></span></h6>
                        <p class="mb-0"><?php echo e(__('Be among the many that trust us')); ?></p>
                    </div>

                </div> <!-- END SECTION TITLE -->

                <div class="row" id="partners">
                            
                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="<?php echo e(URL::asset('img/files/Icon1.png')); ?>" alt="partner">
                            </div>
                        </div>	
                    </div>    
                    
                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="<?php echo e(URL::asset('img/files/Icon2.png')); ?>" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="<?php echo e(URL::asset('img/files/Icon3.png')); ?>" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="<?php echo e(URL::asset('img/files/Icon4.png')); ?>" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="<?php echo e(URL::asset('img/files/Icon5.png')); ?>" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="<?php echo e(URL::asset('img/files/Icon6.png')); ?>" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="<?php echo e(URL::asset('img/files/Icon7.png')); ?>" alt="partner">
                            </div>
                        </div>	
                    </div> 
                </div>
            </div>

        </section> <!-- END SECTION BANNER -->

        <!-- SECTION - FEATURES
        ========================================================-->
        <?php if(config('frontend.features_section') == 'on'): ?>
            <section id="features-wrapper">

                <?php echo adsense_frontend_features_728x90(); ?>

                

                <div class="container">

                    <div class="row text-center mt-8 mb-8">
                        <div class="col-md-12 title">
                            <h6><span><?php echo e(config('app.name')); ?></span> <?php echo e(__('Benefits')); ?></h6>
                            <p><?php echo e(__('Enjoy the full flexibility of the platform with ton of features')); ?></p>
                        </div>
                    </div>
        
                        
                    <!-- LIST OF SOLUTIONS -->
                    <div class="row d-flex" id="solutions-list">
                        
                        <div class="col-md-4 col-sm-12">
                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                
                                <div class="solution" data-aos="zoom-in" data-aos-delay="1000" data-aos-once="true" data-aos-duration="1000">                                                                          
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="<?php echo e(URL::asset('img/files/01.png')); ?>" alt="">
                                        </div>
                                    
                                        <h5><?php echo e(__('Essays: Fixed Price, No Deadline Fees!')); ?></h5>
                                        
                                        <p>Experience academic excellence and affordability with MyPerfectWriting's exceptional custom essay writing service. Our professional writers deliver top-quality papers on time without any additional charges for deadlines, making your success their priority.</p>

                                    </div>                         

                                </div>

                            </div> <!-- END SOLUTION -->
                            
                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="1500" data-aos-once="true" data-aos-duration="1500">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="<?php echo e(URL::asset('img/files/09.png')); ?>" alt="">
                                        </div>
                                    
                                        <h5><?php echo e(__('Academic Writing: Same Price, All Education Levels!')); ?></h5>
                                        
                                        <p> </p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->

                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="2000" data-aos-once="true" data-aos-duration="2000">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="<?php echo e(URL::asset('img/files/06.png')); ?>" alt="">
                                        </div>
                                    
                                        <h5><?php echo e(__(' ')); ?></h5>
                                        
                                        <p> </p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->
                        </div>

                        <div class="col-md-4 col-sm-12 mt-7">
                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="1000" data-aos-once="true" data-aos-duration="1000">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="<?php echo e(URL::asset('img/files/05.png')); ?>" alt="">
                                        </div>
                                    
                                        <h5><?php echo e(__(' ')); ?></h5>
                                        
                                        <p> </p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->


                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="1500" data-aos-once="true" data-aos-duration="1500">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="<?php echo e(URL::asset('img/files/03.png')); ?>" alt="">
                                        </div>
                                    
                                        <h5><?php echo e(__(' ')); ?></h5>
                                        
                                        <p> </p>

                                    </div>                                

                                </div>

                            </div> <!-- END SOLUTION -->


                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="2000" data-aos-once="true" data-aos-duration="2000">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="<?php echo e(URL::asset('img/files/04.png')); ?>" alt="">
                                        </div>
                                    
                                        <h5><?php echo e(__(' ')); ?></h5>
                                        
                                        <p> </p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->
                        </div>

                        <div class="col-md-4 col-sm-12 d-flex">

                            <div class="feature-text">
                                <div>
                                    <h4><span class="text-primary"><?php echo e(config('app.name')); ?></span> <?php echo e(__(' ')); ?></h4>
                                </div>
                                
                                <p> </p>
                                <p> </p>
                            </div>
                            
                        </div>
                        
                    </div> <!-- END LIST OF SOLUTIONS -->
         

                </div>

            </section>
        <?php endif; ?>


       


        <!-- SECTION - CUSTOMER FEEDBACKS
        ========================================================-->
        <?php if(config('frontend.reviews_section') == 'on'): ?>
            <section id="feedbacks-wrapper">

                <div class="container pt-4 text-center">


                    <!-- SECTION TITLE -->
                    <div class="row mb-8" style="margin-top: 100px;">

                        <div class="title">
                            <h6><?php echo e(__('Customer')); ?> <span><?php echo e(__('Reviews')); ?></span></h6>
                            <p><?php echo e(__('We guarantee that you will be one of our happy customers as well')); ?></p>
                        </div>

                    </div> <!-- END SECTION TITLE -->

                    <?php if($review_exists): ?>

                        <div class="row" id="feedbacks">
                            
                            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="feedback" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                                    <!-- MAIN COMMENT -->
                                    <p class="comment"><sup><span class="fa fa-quote-left"></span></sup> <?php echo e(__($review->text)); ?> <sub><span class="fa fa-quote-right"></span></sub></p>

                                    <!-- COMMENTER -->
                                    <div class="feedback-image d-flex">
                                        <div>
                                            <img src="<?php echo e(URL::asset($review->image_url)); ?>" alt="Feedback" class="rounded-circle"><span class="small-quote fa fa-quote-left"></span>
                                        </div>

                                        <div class="pt-3">
                                            <p class="feedback-reviewer"><?php echo e(__($review->name)); ?></p>
                                            <p class="fs-12"><?php echo e(__($review->position)); ?></p>
                                        </div>
                                    </div>	
                                </div> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                       
                        </div>

                        <!-- ROTATORS BUTTONS -->
                        <div class="offers-nav">
                            <a class="offers-prev"><i class="fa fa-chevron-left"></i></a>
                            <a class="offers-next"><i class="fa fa-chevron-right"></i></a>                                
                        </div>

                    <?php else: ?>
                        <div class="row text-center">
                            <div class="col-sm-12 mt-6 mb-6">
                                <h6 class="fs-12 font-weight-bold text-center"><?php echo e(__('No customer reviews were published yet')); ?></h6>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    
                </div> <!-- END CONTAINER -->
                
            </section> <!-- END SECTION CUSTOMER FEEDBACK -->
        <?php endif; ?>
        
        
         


        <!-- SECTION - PRICING
        ========================================================-->
        <?php if(config('frontend.pricing_section') == 'on'): ?>
            
        <?php endif; ?>


  		<!-- SECTION - SERVICES
        ========================================================-->
        <?php if(config('frontend.services_section') == 'on'): ?>
         <div  style="margin-bottom: 100px;"> 
<section id="service-wrapper">
    <div class="container text-center">
        <!-- SECTION TITLE -->
        <div class="row mb-8 mt-5">
            <div class="title w-100">
                <h6><span><?php echo e(__('Our Academic Writing')); ?></span> <?php echo e(__('Services')); ?></h6>
                <p><?php echo e(__('Unleashing the power of words to bring your ideas to life with creativity and precision')); ?></p>
				<form class="row justify-content-center" action="<?php echo e(route('services')); ?>" method="get">
					<div class="text-container text-center col-lg-4 col-12 d-flex">
						<input type="text" name="search" class="typeahead form-control" placeholder="Search Services here..." />
						<button class="btn btn-primary" style="border-radius:5px !important">Search</button>
					</div>
				</form>
            </div>
        </div> <!-- END SECTION TITLE -->

        <?php if($dservice_exists): ?>
            <!-- Services -->
            <div class="row" id="dservices">
                <?php $__currentLoopData = $dservices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-3 service-item">
                        <div class="card">
                            <a href="<?php echo e(route('services.show', $ds->url)); ?>">
                                <div class="card-body">
                                    <?php echo e($ds->title); ?>

                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
		<a class="btn btn-primary" href="<?php echo e(route('services')); ?>"> View All </a>
        <?php endif; ?>

    </div> <!-- END CONTAINER -->
</section> <!-- END SECTION SERVICES -->
        <?php endif; ?>
      <!-- SECTION - FAQ
        ========================================================-->
        <?php if(config('frontend.faq_section') == 'on'): ?>
            <section id="faq-wrapper">    
                <div class="container pt-7">

                    <div class="row text-center mb-8 mt-7">
                        <div class="col-md-12 title">
                            <h6><?php echo e(__('Frequently Asked')); ?> <span><?php echo e(__('Questions')); ?></span></h6>
                            <p><?php echo e(__('Got questions? We have you covered.')); ?></p>
                        </div>
                    </div>

                    <div class="row justify-content-md-center">
        
                        <?php if($faq_exists): ?>

                            <div class="col-md-10">
        
                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div id="accordion" data-aos="fade-left" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                                        <div class="card">
                                            <div class="card-header" id="heading<?php echo e($faq->id); ?>">
                                                <h5 class="mb-0">
                                                <span class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo e($faq->id); ?>" aria-expanded="false" aria-controls="collapse-<?php echo e($faq->id); ?>">
                                                    <?php echo e(__($faq->question)); ?>

                                                </span>
                                                </h5>
                                            </div>
                                        
                                            <div id="collapse-<?php echo e($faq->id); ?>" class="collapse" aria-labelledby="heading<?php echo e($faq->id); ?>" data-bs-parent="#accordion">
                                                <div class="card-body">
                                                    <?php echo __($faq->answer); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                    
        
                        <?php else: ?>
                            <div class="row text-center">
                                <div class="col-sm-12 mt-6 mb-6">
                                    <h6 class="fs-12 font-weight-bold text-center"><?php echo e(__('No FAQ answers were published yet')); ?></h6>
                                </div>
                            </div>
                        <?php endif; ?>
            
                    </div>        
                </div>
        
            </section> <!-- END SECTION FAQ -->
        <?php endif; ?>

        <!-- SECTION - BLOGS
        ========================================================-->
        <?php if(config('frontend.blogs_section') == 'on'): ?>
            <section id="blog-wrapper">

                <div class="container text-center">


                    <!-- SECTION TITLE -->
                    <div class="row mb-8 mt-5">

                        <div class="title w-100" style="margin-top: 100px;">
                            <h6><span><?php echo e(__('Latest')); ?></span> <?php echo e(__('Blogs')); ?></h6>
                            <p><?php echo e(__('Unlocking Knowledge: Your Premier Source for Expert Essay Insights and Academic Excellence')); ?></p>
							<form class="row justify-content-center" action="<?php echo e(route('blogs')); ?>" method="get">
								<div class="text-container text-center col-lg-4 col-12 d-flex">
									<input type="text" name="search" class="typeahead form-control" placeholder="Search Blogs here..." />
									<button class="btn btn-primary" style="border-radius:5px !important">Search</button>
								</div>
							</form>
                        </div>

                    </div> <!-- END SECTION TITLE -->

                    <?php if($blog_exists): ?>
                        
                        <!-- BLOGS -->
                        <div class="row" id="blogs">
                            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="blog" data-aos="zoom-in" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">			 							<a href="<?php echo e(route('blogs.show', $blog->url)); ?>">
                                <div class="blog-box">
                                    <div class="blog-img">
                                       <img src="<?php echo e(URL::asset($blog->image)); ?>" alt="Blog Image">
                                    </div>
                                    <div class="blog-info">
                                        <h6 class="blog-date text-left text-muted mt-3 pt-1 mb-4"><span class="mr-2"><?php echo e($blog->created_by); ?></span> | <i class="mdi mdi-alarm mr-2"></i><?php echo e(date('j F Y', strtotime($blog->created_at))); ?></h6>
                                        <h5 class="blog-title fs-16 text-left mb-3"><?php echo e(__($blog->title)); ?></h5>                                     
                                    </div>
                                </div>  
								</a>
                            </div> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div> 
                        

                        <!-- ROTATORS BUTTONS -->
                        <div class="blogs-nav">
                            <a class="blogs-prev"><i class="fa fa-chevron-left"></i></a>
                            <a class="blogs-next"><i class="fa fa-chevron-right"></i></a>                                
                        </div>

                    <?php else: ?>
                        <div class="row text-center">
                            <div class="col-sm-12 mt-6 mb-6">
                                <h6 class="fs-12 font-weight-bold text-center"><?php echo e(__('No blog articles were published yet')); ?></h6>
                            </div>
                        </div>
                    <?php endif; ?>

				<a class="btn btn-primary text-center" href="<?php echo e(route('blogs')); ?>"> View All </a>
                </div> <!-- END CONTAINER -->

                <?php echo adsense_frontend_blogs_728x90(); ?>

                
            </section> <!-- END SECTION BLOGS -->
        <?php endif; ?>




  

        
        <!-- SECTION - CONTACT US
        ========================================================-->
        <?php if(config('frontend.contact_section') == 'on'): ?>
            <section id="contact-wrapper">

                <div class="container pt-9">       
                    
                    <!-- SECTION TITLE -->
                    <div class="row mb-8 text-center">

                        <div class="title w-100">
                            <h6><span><?php echo e(__('Contact')); ?></span> <?php echo e(__('With Us')); ?></h6>
                            <p><?php echo e(__('Reach out to us for additional information')); ?></p>
                        </div>

                    </div> <!-- END SECTION TITLE -->

                    
                    <div class="row">                
                        
                        <div class="col-md-6 col-sm-12" data-aos="fade-left" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                            <img class="w-70" src="<?php echo e(URL::asset('img/files/about.svg')); ?>" alt="">
                        </div>

                        <div class="col-md-6 col-sm-12" data-aos="fade-right" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                            <form id="" action="<?php echo e(route('contact')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
        
                                <div class="row justify-content-md-center">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="name" type="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" autocomplete="off" placeholder="<?php echo e(__('First Name')); ?>" required>
                                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <?php echo e($message); ?>

                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="lastname" type="text" class="form-control <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="lastname" value="<?php echo e(old('lastname')); ?>" autocomplete="off" placeholder="<?php echo e(__('Last Name')); ?>" required>
                                            <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <?php echo e($message); ?>

                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                            
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row justify-content-md-center">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" autocomplete="off"  placeholder="<?php echo e(__('Email Address')); ?>" required>
                                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <?php echo e($message); ?>

                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="phone" type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone" value="<?php echo e(old('phone')); ?>" autocomplete="off"  placeholder="<?php echo e(__('Phone Number')); ?>" required>
                                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <?php echo e($message); ?>

                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>                            
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="input-box">							
                                            <textarea class="form-control <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="message" rows="10" required placeholder="<?php echo e(__('Message')); ?>"></textarea>
                                            <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="text-danger"><?php echo e($errors->first('message')); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>	
                                        </div>
                                    </div>
                                </div>
        
                                <input type="hidden" name="recaptcha" id="recaptcha">
                                
                                <div class="row justify-content-md-center text-center">
                                    <!-- ACTION BUTTON -->
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary special-action-button"><?php echo e(__('Send Message')); ?></button>							
                                    </div>
                                </div>
                            
                            </form>
        
                        </div>                   
                        
                    </div>
                
                </div>
        
            </section>
        <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script>
  // Get current date
  const currentDate = new Date().toISOString().split('T')[0];
  const dateInput = document.getElementById('deadline-date');
  dateInput.value = currentDate;

  // Get current time
  const currentTime = new Date();
  const currentHour = currentTime.getHours();
  const currentMinute = Math.floor(currentTime.getMinutes() / 15) * 15;

  // Select the current time option and disable past times
  const timeSelect = document.getElementById('deadline-time');
  for (let hour = 0; hour < 24; hour++) {
    for (let minute = 0; minute < 60; minute += 15) {
      if (hour === currentHour && minute === currentMinute) {
        const optionValue = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
        const option = document.createElement('option');
        option.value = optionValue;
        option.textContent = optionValue;
        option.selected = true;
        timeSelect.appendChild(option);
      } else {
        const currentTime = new Date();
        const compareTime = new Date(currentTime.getFullYear(), currentTime.getMonth(), currentTime.getDate(), hour, minute);
        if (compareTime >= currentTime) {
          const optionValue = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
          const option = document.createElement('option');
          option.value = optionValue;
          option.textContent = optionValue;
          if (compareTime < currentTime) {
            option.disabled = true;
          }
          timeSelect.appendChild(option);
        }
      }
    }
  }

  // Function to calculate and update delivery time message
  function updateDeliveryTime() {
    const selectedDate = new Date(dateInput.value);
    const selectedTime = timeSelect.value.split(':');
    const deliveryDate = new Date(
      selectedDate.getFullYear(),
      selectedDate.getMonth(),
      selectedDate.getDate(),
      parseInt(selectedTime[0]),
      parseInt(selectedTime[1])
    );
    const currentTime = new Date();

    if (deliveryDate > currentTime) {
      const timeDifference = Math.abs(deliveryDate - currentTime);
      const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
      const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

      const deliveryDaysElement = document.getElementById('delivery-days');
      const deliveryHoursElement = document.getElementById('delivery-hours');

      deliveryDaysElement.textContent = days;
      deliveryHoursElement.textContent = hours;

      document.getElementById('delivery-time').style.display = 'block';

      // Set minimum time selection to 0 days 3 hours (3 hours = 3 * 60 * 60 * 1000 milliseconds)
      const minTimeDifference = 3 * 60 * 60 * 1000;
      const minTime = new Date(currentTime.getTime() + minTimeDifference);
      const minTimeHour = minTime.getHours();
      const minTimeMinute = Math.floor(minTime.getMinutes() / 15) * 15;

      for (let i = 0; i < timeSelect.options.length; i++) {
        const option = timeSelect.options[i];
        const optionTime = option.value.split(':');
        const optionDate = new Date(
          selectedDate.getFullYear(),
          selectedDate.getMonth(),
          selectedDate.getDate(),
          parseInt(optionTime[0]),
          parseInt(optionTime[1])
        );

        if (optionDate >= minTime && option.disabled) {
          option.disabled = false;
        } else if (optionDate < minTime && !option.disabled) {
          option.disabled = true;
        }
      }
    } else {
      document.getElementById('delivery-time').style.display = 'none';
    }
  }

  // Event listeners for date input change and time select change
  dateInput.addEventListener('change', updateDeliveryTime);
  timeSelect.addEventListener('change', updateDeliveryTime);
</script>





<script>
  $(document).ready(function() {

   
    $('#inc').click(function() {
      var quantity = $('#quantity').val();
      quantity++;
      $('#quantity').val(quantity);
      var pp = $('#pp').val();
      var amount = pp * parseInt(quantity);
      amount = parseFloat(amount).toFixed(2)
      $('#qty').text(quantity)
      $('#total').text(amount)
	
    });
    $('#dec').click(function() {
      var quantity = $('#quantity').val();
      quantity--;
      if (quantity >= 1) {
        $('#quantity').val(quantity);
        var pp = $('#pp').val();
        var amount = pp * parseInt(quantity);
        amount = parseFloat(amount).toFixed(2)
      $('#qty').text(quantity)
      $('#total').text(amount)
      }

    });
    $('#quantity').keyup(function() {
      var quantity = $('#quantity').val();
      var pp = $('#pp').val();
      var amount = pp * parseInt(quantity);
      amount = parseFloat(amount).toFixed(2)
$('#qty').text(quantity)
      $('#total').text(amount)
		
    });
    $('#f-service').change(function() {
      var service = this.options[this.selectedIndex].text;
      $('#service').text(service)
      var pp = $('#pp').val();
      var amount = pp;
      var qty = 1;
   		$('#qty').text(qty)
      $('#total').text(amount)

    });





  });
</script>




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

    <?php if(config('services.google.recaptcha.enable') == 'on'): ?>
         <!-- Google reCaptcha JS -->
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo e(config('services.google.recaptcha.site_key')); ?>"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('<?php echo e(config('services.google.recaptcha.site_key')); ?>', {action: 'contact'}).then(function(token) {
                    if (token) {
                    document.getElementById('recaptcha').value = token;
                    }
                });
            });
        </script>
    <?php endif; ?>




<script>
        var page = 1;
        var hasMoreServices = <?php echo e($hasMoreServices ? 'true' : 'false'); ?>;

        function loadMoreServices() {
            if (!hasMoreServices) {
                return;
            }

            page++;
            $.ajax({
                url: '/get-services/' + page,
                method: 'GET',
                dataType: 'json', // Add this line to specify the response type
                success: function (response) {
                    if (response.data.length > 0) { // Access the data directly
                        var servicesContainer = $('#dservices');
                        $.each(response.data, function (index, service) {
                            var serviceItem = $('<div class="col-md-4 mb-3 service-item">');
                            var card = $('<div class="card">');
                            var anchor = $('<a>').attr('href', 'https://sweet-northcutt.35-221-213-75.plesk.page/service/'+service.url);
                            var cardBody = $('<div class="card-body">').append(anchor);
                            var cardTitle = $('<div class="">').text(service.title).appendTo(anchor);

                            cardBody.appendTo(card);
                            card.appendTo(serviceItem);
                            serviceItem.appendTo(servicesContainer);
                        });
                    } else {
                        hasMoreServices = false;
                        $('#show-more-btn').remove();
                    }
                },
                error: function () {
                    console.error('Error loading more services.');
                }
            });
        }

        $(document).ready(function () {
            $('#show-more-btn').on('click', loadMoreServices);
        });
    </script>

<script>
    // Function to stop the video when the modal is closed
    function stopVideoOnClose() {
        var iframe = document.getElementById('youtube-player');

        // Remove the 'autoplay' attribute from the iframe
        iframe.removeAttribute('autoplay');

        // Reload the iframe to apply the changes and stop the video
        iframe.src = iframe.src;
    }

    // Attach the function to the close button click event
    document.querySelector('.btn-close').addEventListener('click', stopVideoOnClose);
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/relaxed-nobel.35-229-252-74.plesk.page/httpdocs/resources/views/home.blade.php ENDPATH**/ ?>