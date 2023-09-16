

<?php $__env->startSection('content'); ?>
<style>
	.h-100vh {
            height: 110vh !important;
        }
	#password.form-control {
		border-top-right-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
	}
	
    .input-box {
        position: relative;
    }

    .input-group {
        display: flex;
    }

    .input-group-append {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .input-group-text {
        background-color: transparent;
        border: none;
    }

    .input-group-text i {
        font-size: 16px;
    }

    .invalid-feedback {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }
.ml-auto a.text-info.fs-12 {
    color: transparent; /* Start with transparent text color */
    text-shadow: 0 0 1px rgba(0, 0, 0, 1); /* Apply a black shadow */
    transition: all 0.3s; /* Add a smooth transition effect */
}

.ml-auto a.text-info.fs-12:hover {
    color: #000; /* Change the text color to black on hover */
    text-shadow: none; /* Remove the text shadow on hover */
}

.ml-auto a.text-info.fs-12 {
    font-size: 18px;
}

	
</style>

<div class="container-fluid justify-content-center">
    <div class="row h-100vh align-items-center background-white">
        <div class="col-md-7 col-sm-12 text-center background-special h-100 align-middle p-0" id="login-background">
             <section id="main-wrapper">
            <div class="h-100vh justify-center min-h-screen" id="main-background">
                <div class="container h-100vh">
                    <div class="row h-100vh vertical-center">
                        <div class="col-sm-12 upload-responsive">
                            <div class="text-container text-center">
                                <h3 class="mb-4 font-weight-bold text-white" data-aos="fade-left" data-aos-delay="400" data-aos-once="true" data-aos-duration="700"><?php echo e(__('Meet')); ?>, <?php echo e(config('app.name')); ?></span></h3>
                                <h1 class="text-white" data-aos="fade-left" data-aos-delay="500" data-aos-once="true" data-aos-duration="700"><?php echo e(__('The Future of Essay Writing')); ?></span></h1>
                                <h1 class="mb-0 gradient fixed-height" id="typed" data-aos="fade-left" data-aos-delay="600" data-aos-once="true" data-aos-duration="900"></h1>
                                <p class="fs-18 text-white" data-aos="fade-left" data-aos-delay="700" data-aos-once="true" data-aos-duration="1100"><?php echo e(__('Get Academic Writing Service Only £6.99/page')); ?></p>
                                <a href="<?php echo e(route('register')); ?>" class="btn btn-primary special-action-button" data-aos="fade-left" data-aos-delay="800" data-aos-once="true" data-aos-duration="1100"><?php echo e(__('Write My Essay Now')); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </section>
        </div>
        
        <div class="col-md-5 col-sm-12 h-100" id="login-responsive">                
            <div class="card-body pr-10 pl-10">
                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>                                       

					<div style="text-align: center;">
    <a class="header-brand" href="https://www.myperfectwriting.co.uk" target="_blank">
        <img src="<?php echo e(URL::asset('img/brand/logo.png')); ?>" style="max-width: 230px;">
    </a>
</div>

					
                    <h3 class="text-center font-weight-bold mb-8"><?php echo e(__('Welcome Back to')); ?> <span class="text-info"><a href="<?php echo e(url('/')); ?>"><?php echo e(config('app.name')); ?></a></span><p class="text-center"><br><strong>"Do not trust us, Test Us"</strong></p>
</h3>
	

                    <?php if($message = Session::get('success')): ?>
                        <div class="alert alert-login alert-success"> 
                            <strong><i class="fa fa-check-circle"></i> <?php echo e($message); ?></strong>
                        </div>
                        <?php endif; ?>

                        <?php if($message = Session::get('error')): ?>
                        <div class="alert alert-login alert-danger">
                            <strong><i class="fa fa-exclamation-triangle"></i> <?php echo e($message); ?></strong>
                        </div>
                    <?php endif; ?>
                    
					
					   <div class="divider">
    <div class="divider-text text-muted">
        <small style="font-size: 18px; font-weight: bold;"><?php echo e(__('login with email')); ?></small>
    </div>
</div>

                   
                    

                    <div class="input-box mb-4">                             
                        <label for="email" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Email Address')); ?></label>
                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" autocomplete="off" placeholder="<?php echo e(__('Email Address')); ?>" required>
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

                    <div class="input-box">
    <label for="password" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Password')); ?></label>
    <div class="input-group">
        <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" autocomplete="off" placeholder="<?php echo e(__('Password')); ?>" required>
        <div class="input-group-append">
            <span class="input-group-text" onclick="togglePasswordVisibility()"><i id="togglePasswordIcon" class="fa fa-eye"></i></span>
        </div>
    </div>
    <?php $__errorArgs = ['password'];
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


                    <div class="form-group mb-3">  
                        <div class="d-flex">                        
                            <label class="custom-switch">
                                <input type="checkbox" class="custom-switch-input" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description"><?php echo e(__('Keep me logged in')); ?></span>
                            </label>   

                           <div class="ml-auto">
    <?php if(Route::has('password.request')): ?>
        <a class="text-info fs-12" href="<?php echo e(route('password.request')); ?>"><?php echo e(__('Forgot Your Password?')); ?></a>
    <?php endif; ?>
</div>

                        </div>
                    </div>

                    <input type="hidden" name="recaptcha" id="recaptcha">

                    <div class="form-group mb-0">                        
                        <button type="submit" class="btn btn-primary mr-2"><?php echo e(__('Login')); ?></button>       
                        <?php if(config('settings.registration') == 'enabled'): ?>
                            <a href="<?php echo e(route('register')); ?>"  class="btn btn-cancel"><?php echo e(__('Sign Up')); ?></a> 
                        <?php endif; ?>                         
                                               
                    </div>

                   <p class="fs-14 text-muted pt-3" style="font-weight: bold; font-size: 14px;">
    <?php echo e(__('By continuing, you agree to our')); ?>

    <a href="<?php echo e(route('terms')); ?>" class="text-info"><?php echo e(__('Terms and Conditions')); ?></a>
    <?php echo e(__('and')); ?>

    <a href="<?php echo e(route('privacy')); ?>" class="text-info"><?php echo e(__('Privacy Policy')); ?></a>
</p>

                    <?php if(config('settings.oauth_login') == 'enabled'): ?>
                       <div class="divider">
    <div class="divider-text text-muted">
        <small style="font-size: 18px; font-weight: bold;"><?php echo e(__('Or Login with')); ?></small>
    </div>
</div>


                        <div class="actions-total text-center">
                            <?php if(config('services.facebook.enable') == 'on'): ?><a href="<?php echo e(url('/auth/redirect/facebook')); ?>" data-tippy-content="<?php echo e(__('Login with Facebook')); ?>" class="btn mr-2" id="login-facebook"><i class="fa-brands fa-facebook-f"></i></a><?php endif; ?>
                            <?php if(config('services.twitter.enable') == 'on'): ?><a href="<?php echo e(url('/auth/redirect/twitter')); ?>" data-tippy-content="<?php echo e(__('Login with Twitter')); ?>" class="btn mr-2" id="login-twitter"><i class="fa-brands fa-twitter"></i></a><?php endif; ?>	
                            <?php if(config('services.google.enable') == 'on'): ?><a href="<?php echo e(url('/auth/redirect/google')); ?>" data-tippy-content="<?php echo e(__('Login with Google')); ?>" class="btn mr-2" id="login-google"><i class="fa-brands fa-google"></i></a><?php endif; ?>	
                            <?php if(config('services.linkedin.enable') == 'on'): ?><a href="<?php echo e(url('/auth/redirect/linkedin')); ?>" data-tippy-content="<?php echo e(__('Login with Linkedin')); ?>" class="btn mr-2" id="login-linkedin"><i class="fa-brands fa-linkedin-in"></i></a><?php endif; ?>	
                        </div>
<?php endif; ?>
                     

                </form>
            </div>     
        </div>
    </div>
</div>
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

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var togglePasswordIcon = document.getElementById("togglePasswordIcon");
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            togglePasswordIcon.classList.remove("fa-eye");
            togglePasswordIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            togglePasswordIcon.classList.remove("fa-eye-slash");
            togglePasswordIcon.classList.add("fa-eye");
        }
    }
</script>

    <!-- Tippy css -->
    <script src="<?php echo e(URL::asset('plugins/tippy/popper.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('plugins/tippy/tippy-bundle.umd.min.js')); ?>"></script>
    <script>
        tippy('[data-tippy-content]', {
                animation: 'scale-extreme',
                theme: 'material',
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
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/auth/login.blade.php ENDPATH**/ ?>