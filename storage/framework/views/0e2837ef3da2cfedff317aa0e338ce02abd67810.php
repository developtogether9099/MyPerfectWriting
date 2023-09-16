

<?php $__env->startSection('css'); ?>
	<!-- Data Table CSS -->
	<link href="<?php echo e(URL::asset('plugins/awselect/awselect.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
	.input-group {
    position: relative;
}
	#password-input.form-control {
		border-top-right-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
	}
	#password-confirm.form-control {
		border-top-right-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
	}

.input-icon {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
}

	/* Styles for the icon */
  #get-username {
    display: inline-block;
    position: relative;
    cursor: pointer;
	  
  }

  #get-username i {
    font-size: 20px;
    color: #333;
    transition: all 0.5s ease;
	  padding: 10px;
  }

  /* Shadow effect on hover */
  #get-username:hover i {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
	  color: #f49d1d;
  }

  /* Animation while clicking */
  #get-username:active i {
    transform: scale(0.9);
  }
 #info-icon {
        margin-left: 5px;
        cursor: help;
    }
    
    #info-message {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        z-index: 9999;
    }
    
    #info-icon:hover + #info-message {
        display: block;
    }

        .h-100vh {
            height: 170vh !important;
        }
    </style>
    <?php if(config('frontend.maintenance') == 'on'): ?>			
        <div class="container h-100vh">
            <div class="row text-center h-100vh align-items-center">
                <div class="col-md-12">
                    <img src="<?php echo e(URL::asset('img/files/maintenance.png')); ?>" alt="Maintenance Image">
                    <h2 class="mt-4 font-weight-bold"><?php echo e(__('We are just tuning up a few things')); ?>.</h2>
                    <h5><?php echo e(__('We apologize for the inconvenience but')); ?> <span class="font-weight-bold text-info"><?php echo e(config('app.name')); ?></span> <?php echo e(__('is currenlty undergoing planned maintenance')); ?>.</h5>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php if(config('settings.registration') == 'enabled'): ?>
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
                        <div class="card-body pr-10 pl-10 pt-10">
                            <form method="POST" action="<?php echo e(route('register')); ?>">
                                <?php echo csrf_field(); ?>                                
                                
                                <h3 class="text-center font-weight-bold mb-8"><?php echo e(__('Sign Up to')); ?> <span class="text-info"><a href="<?php echo e(url('/')); ?>"><?php echo e(config('app.name')); ?></a></span><p class="text-center"><br><strong>"Do not trust us, Test Us"</strong></p>
</h3>

                                <?php if(config('settings.oauth_login') == 'enabled'): ?>
                                    <div class="divider">
                                        <div class="divider-text text-muted">
                                            <small><?php echo e(__('Register with Your Social Media Account')); ?></small>
                                        </div>
                                    </div>

                                    <div class="actions-total text-center">
                                        <?php if(config('services.facebook.enable') == 'on'): ?><a href="<?php echo e(url('/auth/redirect/facebook')); ?>" data-tippy-content="<?php echo e(__('Login with Facebook')); ?>" class="btn mr-2" id="login-facebook"><i class="fa-brands fa-facebook-f"></i></a><?php endif; ?>
                                        <?php if(config('services.twitter.enable') == 'on'): ?><a href="<?php echo e(url('/auth/redirect/twitter')); ?>" data-tippy-content="<?php echo e(__('Login with Twitter')); ?>" class="btn mr-2" id="login-twitter"><i class="fa-brands fa-twitter"></i></a><?php endif; ?>	
                                        <?php if(config('services.google.enable') == 'on'): ?><a href="<?php echo e(url('/auth/redirect/google')); ?>" data-tippy-content="<?php echo e(__('Login with Google')); ?>" class="btn mr-2" id="login-google"><i class="fa-brands fa-google"></i></a><?php endif; ?>	
                                        <?php if(config('services.linkedin.enable') == 'on'): ?><a href="<?php echo e(url('/auth/redirect/linkedin')); ?>" data-tippy-content="<?php echo e(__('Login with Linkedin')); ?>" class="btn mr-2" id="login-linkedin"><i class="fa-brands fa-linkedin-in"></i></a><?php endif; ?>	
                                    </div>

                                    <div class="divider">
                                        <div class="divider-text text-muted">
                                            <small><?php echo e(__('or register with email')); ?></small>
                                        </div>
                                    </div>
                                <?php endif; ?>
								
								<?php 
									$faker = Faker\Factory::create();
									$username = $faker->firstname;
								 	$check = DB::table('users')->where('username', $username)->first();
									if(!empty($check)){
										$faker = Faker\Factory::create();
										$username = $faker->firstname;
									}
								?>
								<div class="input-box">                            
    <label for="password-input" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Username')); ?><a id="info-icon"><i class="fas fa-info-circle"></i></a></label>
    <div class="d-flex align-items-center">
        <input type="text" class="form-control" name="username" id="username" value="<?php echo e($username); ?>" required autocomplete="off" readonly placeholder="<?php echo e(__('Username')); ?>"><a id="get-username" href="#"><i class="fas fa-undo"></i></a>

    </div>
</div>




                                <div class="input-box mb-4">                             
                                    <label for="name" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Full Name')); ?></label>
                                    <input id="name" type="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" autocomplete="off" autofocus placeholder="<?php echo e(__('First and Last Names')); ?>">
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

                                <div class="input-box mb-4">  
									
                                    <label for="email" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Email Address')); ?></label>
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

                                <div class="input-box mb-4">                             
                                    <label for="country" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Country')); ?></label>
                                    <select id="user-country" name="country" data-placeholder="<?php echo e(__('Select Your Country')); ?>" required>	
                                        <?php $__currentLoopData = config('countries'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($value); ?>" <?php if(config('settings.default_country') == $value): ?> selected <?php endif; ?>><?php echo e($value); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>										
                                    </select>
                                    <?php $__errorArgs = ['country'];
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
    <label for="password-input" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Password')); ?></label>
    <div class="input-group">
        <input id="password-input" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="off" placeholder="<?php echo e(__('Password')); ?>">
        <span class="input-icon password-toggle" onclick="togglePasswordVisibility('password-input')">
            <i class="fas fa-eye"></i>
        </span>
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

<div class="input-box">
    <label for="password-confirm" class="fs-12 font-weight-bold text-md-right"><?php echo e(__('Confirm Password')); ?></label>
    <div class="input-group">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off" placeholder="<?php echo e(__('Confirm Password')); ?>">
        <span class="input-icon password-toggle" onclick="togglePasswordVisibility('password-confirm')">
            <i class="fas fa-eye"></i>
        </span>
    </div>
</div>


                                <div class="form-group mb-3">  
                                    <div class="d-flex">                        
                                        <label class="custom-switch">
                                            <input type="checkbox" class="custom-switch-input" name="agreement" id="agreement" <?php echo e(old('remember') ? 'checked' : ''); ?> required>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description fs-10 text-muted"><?php echo e(__('By continuing, I agree with your')); ?> <a href="<?php echo e(route('terms')); ?>" class="text-info"><?php echo e(__('Terms and Conditions')); ?></a> <?php echo e(__('and')); ?> <a href="<?php echo e(route('privacy')); ?>" class="text-info"><?php echo e(__('Privacy Policies')); ?></a></span>
                                        </label>   
                                    </div>
                                </div>

                                <input type="hidden" name="recaptcha" id="recaptcha">

                                <div class="form-group mb-0">                        
                                    <button type="submit" class="btn btn-primary mr-2"><?php echo e(__('Sign Up')); ?></button> 
                                    <p class="fs-10 text-muted mt-2">or <a class="text-info" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a></p>                               
                                </div>
                            </form>
                        </div>       
                    </div>
                </div>
            </div>
        <?php else: ?>
            <h5 class="text-center pt-9"><?php echo e(__('New user registration is disabled currently')); ?></h5>
        <?php endif; ?>
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

<script>
    document.getElementById("info-icon").addEventListener("mouseover", function() {
        var message = "We prioritize your privacy and guarantee that your original name will remain completely confidential and never be disclosed or shown to anyone. From this point forward, your username will be used for all communications.";
        
        var infoMessage = document.createElement("div");
        infoMessage.id = "info-message";
        infoMessage.innerHTML = message;
        
        this.parentNode.appendChild(infoMessage);
    });
    
    document.getElementById("info-icon").addEventListener("mouseout", function() {
        var infoMessage = document.getElementById("info-message");
        if (infoMessage) {
            infoMessage.parentNode.removeChild(infoMessage);
        }
    });
</script>
<script>
  // JavaScript to handle click animation
  var getUserName = document.getElementById('get-username');

  getUserName.addEventListener('mousedown', function() {
    this.classList.add('clicked');
  });

  getUserName.addEventListener('mouseup', function() {
    this.classList.remove('clicked');
  });
</script>
<script>
function togglePasswordVisibility(inputId) {
    var passwordInput = document.getElementById(inputId);
    var passwordToggle = $(passwordInput).closest('.input-group').find('.password-toggle');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggle.html('<i class="fas fa-eye-slash"></i>');
    } else {
        passwordInput.type = 'password';
        passwordToggle.html('<i class="fas fa-eye"></i>');
    }
}
</script>

	<!-- Awselect JS -->
	<script src="<?php echo e(URL::asset('plugins/awselect/awselect.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('js/awselect.js')); ?>"></script>

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
$(document).ready(function() {
    // Handle click event
    $('#get-username').click(function() {
        // Make changes when clicked
        var i = '';

        $.ajax({
            url: '/get-username',
            method: 'GET',
            success: function(response) {
                i = response; 
				$('#username').val(response)
                
            }
        });
    });
});
	
</script>
   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/auth/register.blade.php ENDPATH**/ ?>