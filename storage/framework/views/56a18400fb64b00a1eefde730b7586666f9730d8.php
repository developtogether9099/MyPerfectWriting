<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
	<head>
		<!-- Meta data -->
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="">
	    <meta name="keywords" content="">
	    <meta name="description" content="">
		
        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <!-- Title -->
        <title><?php echo e(config('app.name')); ?></title>

		<!-- Style css -->
		<link href="<?php echo e(URL::asset('plugins/tippy/scale-extreme.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('plugins/tippy/material.css')); ?>" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400&display=swap" rel="stylesheet">

		<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	</head>

	<body class="app sidebar-mini">

		<!-- Page -->
		<div class="page">
			<div class="page-main">
				
				<!-- App-Content -->			
				<div class="main-content">
					<div class="side-app">

						<?php echo $__env->yieldContent('content'); ?>

					</div>                   
				</div>
		
		</div><!-- End Page -->

		<?php echo $__env->make('layouts.footer-frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
	</body>
</html>


<?php /**PATH /var/www/vhosts/relaxed-nobel.35-229-252-74.plesk.page/httpdocs/resources/views/layouts/auth.blade.php ENDPATH**/ ?>