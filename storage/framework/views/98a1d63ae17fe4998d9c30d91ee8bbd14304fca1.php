<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('plugins/slick/slick.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('plugins/slick/slick-theme.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('plugins/aos/aos.css')); ?>" rel="stylesheet" />
<style>
	 .pageBg {
		 background:black;
    background-image: url("https://img.freepik.com/free-photo/3d-dark-grunge-display-background-with-smoky-atmosphere_1048-16218.jpg");
	}
</style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <section id="main-wrapper">
			
            <div class="h-50vh justify-center min-h-screen pageBg">
                <div class="container" style="padding-top: 160px; padding-bottom: 100px;">
                       <div class="row align-items-center justify-content-center h-50vh vertial-center">
                       
                        	<div class="col-sm-6 upload-responsive">
							<form action="<?php echo e(route('services')); ?>" method="get">
								<div class="text-container text-center d-flex">

									<input type="test" name="search" class="typeahead form-control" placeholder="Search Services here...">
									<button class="btn btn-primary" style="border-radius:5px !important">Search</button>


								</div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


</div>


<?php if(config('frontend.blogs_section') == 'on'): ?>
<section id="blog-wrapper">

    <div class="container text-center">


       
        <div class="row mb-8">

            <div class="title w-100" style="margin-top: 100px;">
                <h6><span><?php echo e(__('Our')); ?></span> <?php echo e(__('Services')); ?></h6>
                <p><?php echo e(__('Unleashing the power of words to bring your ideas to life with creativity and precision')); ?></p>
            </div>

        </div> 

        <?php if($service_exists): ?>

       
        <div class="row">
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <div class="col-md-4 mb-3 service-item">
                        <div class="card">
                            <a href="<?php echo e(route('services.show', $service->url)); ?>">
                                <div class="card-body">
									<p><?php echo e(request()->segment(22)); ?></p>
                                    <?php echo e($service->title); ?>

                                </div>
                            </a>
                        </div>
                    </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
			
        </div>


   		<div class="d-flex justify-content-center" > <?php echo e($services->links()); ?></div>

        <?php else: ?>
        <div class="row text-center">
            <div class="col-sm-12 mt-6 mb-6">
                <h6 class="fs-12 font-weight-bold text-center"><?php echo e(__('No Services were published yet')); ?></h6>
            </div>
        </div>
        <?php endif; ?>

    </div> 



</section> 
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<script type="text/javascript">
    var path = "<?php echo e(route('services.search')); ?>";
    $('input.typeahead').typeahead({
        source: function (str, process) {
            return $.get(path, { str: str }, function (data) {
                var titles = data.map(item => item.title);
                console.log(titles);
                process(titles);
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/services.blade.php ENDPATH**/ ?>