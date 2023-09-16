<?php $__env->startSection('css'); ?>


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
                        
					<div class="col-md-6 upload-responsive">
						<form action="<?php echo e(route('blogs')); ?>" method="get">
							<div class="text-container text-center d-flex">
								<input type="text" name="search" class="typeahead form-control" placeholder="Search Blogs here..." />
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


        <!-- SECTION TITLE -->
        <div class="row mb-8 ">

            <div class="title w-100" style="margin-top: 100px;">
                <h6><span><?php echo e(__('Our')); ?></span> <?php echo e(__('Blogs')); ?></h6>
                <p><?php echo e(__('Read our unique blog articles about various data archiving solutions and secrets')); ?></p>
            </div>

        </div> <!-- END SECTION TITLE -->

        <?php if($blog_exists): ?>

        <!-- BLOGS -->
        <div class="row">
            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="blog col-md-4 my-3" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">
               <a href="<?php echo e(route('blogs.show', $blog->url)); ?>">
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


   		<div class="d-flex justify-content-center" style="margin-top: 60px;"> <?php echo e($blogs->links()); ?></div>

        <?php else: ?>
        <div class="row text-center">
            <div class="col-sm-12 mt-6 mb-6">
                <h6 class="fs-12 font-weight-bold text-center"><?php echo e(__('No blog articles were published yet')); ?></h6>
            </div>
        </div>
        <?php endif; ?>

    </div> <!-- END CONTAINER -->

    <?php echo adsense_frontend_blogs_728x90(); ?>


</section> <!-- END SECTION BLOGS -->
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<script type="text/javascript">
    var path = "<?php echo e(route('blogs.search')); ?>";
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
<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/blogs.blade.php ENDPATH**/ ?>