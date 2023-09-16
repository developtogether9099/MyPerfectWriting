<?php $__env->startSection('css'); ?>
	<!-- Data Table CSS -->
	<link href="<?php echo e(URL::asset('plugins/awselect/awselect.min.css')); ?>" rel="stylesheet" />

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <section id="main-wrapper">
			
            <div class=" justify-centr min-h-scren" id="main-background">
                <div class="container h-50vh" style="padding: 40px;">
             
                </div>
            </div>
        </section>
    </div>


</div>
    <section id="blog-wrapper">

        <div class="container pt-9">

           <div class="row justify-content-md-center align-items-center">
            <div class="col-md-6">
           
                <h6 style="font-size:54px" class="fs-28 mt-6"><?php echo e($service->title); ?></h6>
              
            </div>
            
        </div>
        <div class="row mt-4">
			<div class="col-md-8">
                <div class="fs-18 text-justify" id="blog-view-mobile"><?php echo $service->body; ?></div>
            </div>
            <div class="col-md-4">
                <p class="text-left">More Services</p>
				<?php $__currentLoopData = $popularservices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card" data-aos="zoom-in" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">
                    <div class="card-body">
                       <a href="<?php echo e(route('services.show', $service->url)); ?>">
                        <h5 class="blog-title fs-16 text-left mb-3"><?php echo e(__($service->title)); ?></h5>
                       </a>
                    </div>
                </div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
           
            </div>
            
        </div>
    </div>

    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<!-- Awselect JS -->
	<script src="<?php echo e(URL::asset('plugins/awselect/awselect.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('js/awselect.js')); ?>"></script>  
    <script src="<?php echo e(URL::asset('js/minimize.js')); ?>"></script> 

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

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/service-show.blade.php ENDPATH**/ ?>