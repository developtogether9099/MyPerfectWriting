@extends('layouts.auth')

@section('css')
	<!-- Data Table CSS -->
	<link href="{{URL::asset('plugins/awselect/awselect.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
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
	/* Set font size and color for the text inside <p> */
.fs-10 {
  font-size: 18px;
  color: black;
}

/* Define a new class to target the same element with higher specificity */
.text-info.hover-blue:hover {
  color: blue !important; /* Override the color with !important */
}

/* Initially set the color to blue */
.text-info {
  color: #0000FF !important;
}

/* Change color to black on hover */
.text-info:hover {
  color: #000000;
}



    </style>
    @if (config('frontend.maintenance') == 'on')			
        <div class="container h-100vh">
            <div class="row text-center h-100vh align-items-center">
                <div class="col-md-12">
                    <img src="{{ URL::asset('img/files/maintenance.png') }}" alt="Maintenance Image">
                    <h2 class="mt-4 font-weight-bold">{{ __('We are just tuning up a few things') }}.</h2>
                    <h5>{{ __('We apologize for the inconvenience but') }} <span class="font-weight-bold text-info">{{ config('app.name') }}</span> {{ __('is currenlty undergoing planned maintenance') }}.</h5>
                </div>
            </div>
        </div>
    @else
        @if (config('settings.registration') == 'enabled')
            <div class="container-fluid justify-content-center">
                <div class="row h-100vh align-items-center background-white">
					
                    <div class="col-md-7 col-sm-12 text-center background-special h-100 align-middle p-0" id="login-background">
						 <section id="main-wrapper">
            <div class="h-100vh justify-center min-h-screen" id="main-background">
                <div class="container h-100vh">
                    <div class="row h-100vh vertical-center">
                        <div class="col-sm-12 upload-responsive">
                            <div class="text-container text-center">
                                <h3 class="mb-4 font-weight-bold text-white" data-aos="fade-left" data-aos-delay="400" data-aos-once="true" data-aos-duration="700">{{ __('Meet') }}, {{ config('app.name') }}</span></h3>
                                <h1 class="text-white" data-aos="fade-left" data-aos-delay="500" data-aos-once="true" data-aos-duration="700">{{ __('The Future of Essay Writing') }}</span></h1>
                                <h1 class="mb-0 gradient fixed-height" id="typed" data-aos="fade-left" data-aos-delay="600" data-aos-once="true" data-aos-duration="900"></h1>
                                <p class="fs-18 text-white" data-aos="fade-left" data-aos-delay="700" data-aos-once="true" data-aos-duration="1100">{{ __('Get Academic Writing Service Only £6.99/page') }}</p>
                                <a href="{{ route('register') }}" class="btn btn-primary special-action-button" data-aos="fade-left" data-aos-delay="800" data-aos-once="true" data-aos-duration="1100">{{ __('Write My Essay Now') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </section>
                   
                    </div>
                    
                    <div class="col-md-5 col-sm-12 h-100" id="login-responsive">                
                        <div class="card-body pr-10 pl-10">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf                                
                              
   <div style="text-align: center;">
    <a class="header-brand" href="https://www.myperfectwriting.co.uk" target="_blank">
        <img src="{{URL::asset('img/brand/logo.png')}}" style="max-width: 230px;">
    </a>
</div>





                                <h3 class="text-center font-weight-bold mb-8">{{__('Sign Up to')}} <span class="text-info"><a href="{{ url('/') }}">{{ config('app.name') }}</a></span><p class="text-center"><br><strong>"Do not trust us, Test Us"</strong></p>
</h3>

                                @if (config('settings.oauth_login') == 'enabled')
                                    <div class="divider">
                                        <div class="divider-text text-muted">
                                            <small>{{__('Sign Up with')}}</small>
                                        </div>
                                    </div>

                                    <div class="actions-total text-center">
                                        @if(config('services.facebook.enable') == 'on')<a href="{{ url('/auth/redirect/facebook') }}" data-tippy-content="{{ __('Login with Facebook') }}" class="btn mr-2" id="login-facebook"><i class="fa-brands fa-facebook-f"></i></a>@endif
                                        @if(config('services.twitter.enable') == 'on')<a href="{{ url('/auth/redirect/twitter') }}" data-tippy-content="{{ __('Login with Twitter') }}" class="btn mr-2" id="login-twitter"><i class="fa-brands fa-twitter"></i></a>@endif	
                                        @if(config('services.google.enable') == 'on')<a href="{{ url('/auth/redirect/google') }}" data-tippy-content="{{ __('Login with Google') }}" class="btn mr-2" id="login-google"><i class="fa-brands fa-google"></i></a>@endif	
                                        @if(config('services.linkedin.enable') == 'on')<a href="{{ url('/auth/redirect/linkedin') }}" data-tippy-content="{{ __('Login with Linkedin') }}" class="btn mr-2" id="login-linkedin"><i class="fa-brands fa-linkedin-in"></i></a>@endif	
                                    </div>

                                    <div class="divider">
                                        <div class="divider-text text-muted">
                                            <small>{{ __('or Sign Up with email') }}</small>
                                        </div>
                                    </div>
                                @endif
								
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
    <div class="input-box">
    <label class="fs-12 font-weight-bold d-flex align-items-center justify-content-between">
        <span>{{ __('Username') }}<a id="info-icon"><i class="fas fa-info-circle"></i></a></span>
        <p class="fs-10 text-muted mt-2">
  Already have an account? Just <a class="text-info" href="{{ route('login') }}">{{ __('Login') }}</a>
</p>

    </label>
    <div class="d-flex align-items-center">
        <input type="text" class="form-control" name="username" id="username" value="{{$username}}" required autocomplete="off" readonly placeholder="{{ __('Username') }}">
        <a id="get-username" href="#"><i class="fas fa-undo"></i></a>
    </div>
</div>
</div>
								





                                <div class="input-box mb-4">                             
                                    <label for="name" class="fs-12 font-weight-bold text-md-right">{{ __('Full Name') }}</label>
                                    <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="off" autofocus placeholder="{{ __('First and Last Names') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror                            
                                </div>

                                <div class="input-box mb-4">  
									
                                    <label for="email" class="fs-12 font-weight-bold text-md-right">{{ __('Email Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off"  placeholder="{{ __('Email Address') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror                            
                                </div>

                                <div class="input-box mb-4">                             
                                    <label for="country" class="fs-12 font-weight-bold text-md-right">{{ __('Country') }}</label>
                                    <select id="user-country" name="country" data-placeholder="{{ __('Select Your Country') }}" required>	
                                        @foreach(config('countries') as $value)
											<option value="{{ $value }}" @if(config('settings.default_country') == $value) selected @endif>{{ $value }}</option>
										@endforeach										
                                    </select>
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror                            
                                </div>

                                <div class="input-box">
    <label for="password-input" class="fs-12 font-weight-bold text-md-right">{{ __('Password') }}</label>
    <div class="input-group">
        <input id="password-input" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off" placeholder="{{ __('Password') }}">
        <span class="input-icon password-toggle" onclick="togglePasswordVisibility('password-input')">
            <i class="fas fa-eye"></i>
        </span>
    </div>
    @error('password')
        <span class="invalid-feedback" role="alert">
            {{ $message }}
        </span>
    @enderror
</div>

<div class="input-box">
    <label for="password-confirm" class="fs-12 font-weight-bold text-md-right">{{ __('Confirm Password') }}</label>
    <div class="input-group">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off" placeholder="{{ __('Confirm Password') }}">
        <span class="input-icon password-toggle" onclick="togglePasswordVisibility('password-confirm')">
            <i class="fas fa-eye"></i>
        </span>
    </div>
</div>


                                <div class="form-group mb-3">  
                                    <div class="d-flex">                        
                                        <label class="custom-switch">
                                            <input type="checkbox" class="custom-switch-input" name="agreement" id="agreement" {{ old('remember') ? 'checked' : '' }} required>
                                            <span class="custom-switch-indicator"></span>
                                           <span class="custom-switch-description fs-10 text-muted" style="font-size: 18px;">
    {{__('By continuing, I agree with your')}}
    <a href="{{ route('terms') }}" class="text-info">{{__('Terms and Conditions')}}</a>
    {{__('and')}}
    <a href="{{ route('privacy') }}" class="text-info">{{__('Privacy Policies')}}</a>
</span>

                                        </label>   
                                    </div>
                                </div>

                                <input type="hidden" name="recaptcha" id="recaptcha">

                                <div class="form-group mb-0">                        
                                    <button type="submit" class="btn btn-primary mr-2">{{ __('Sign Up') }}</button> 
                                   <p class="fs-10 text-muted mt-2">
  or <a class="text-info" href="{{ route('login') }}">{{ __('Login') }}</a>
</p>



                                </div>
                            </form>
                        </div>       
                    </div>
                </div>
            </div>
        @else
            <h5 class="text-center pt-9">{{__('New user registration is disabled currently')}}</h5>
        @endif
    @endif
@endsection

@section('js')
 <script src="{{URL::asset('plugins/slick/slick.min.js')}}"></script>  
    <script src="{{URL::asset('plugins/aos/aos.js')}}"></script> 
    <script src="{{URL::asset('plugins/typed/typed.min.js')}}"></script>
    <script src="{{URL::asset('js/frontend.js')}}"></script>  
    <script type="text/javascript">
		$(function () {

            var typed = new Typed('#typed', {
                strings: ['<h1><span>{{ __('Fixed Pricing System') }}</span></h1>', 
                            '<h1><span>{{ __('Per Page Writing Services') }}</span></h1>',
                            '<h1><span>{{ __('Analytical Essay') }}</span></h1>',
                            '<h1><span>{{ __('Contrast Essay') }}</span></h1>',
                            '<h1><span>{{ __('Expository Essay') }}</span></h1>',
                            '<h1><span>{{ __('Narrative Essay') }}</span></h1>',
                            '<h1><span>{{ __('And Many More!') }}</span></h1>'],
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
	<script src="{{URL::asset('plugins/awselect/awselect.min.js')}}"></script>
	<script src="{{URL::asset('js/awselect.js')}}"></script>

    @if (config('services.google.recaptcha.enable') == 'on')
         <!-- Google reCaptcha JS -->
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.google.recaptcha.site_key') }}"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.google.recaptcha.site_key') }}', {action: 'contact'}).then(function(token) {
                    if (token) {
                    document.getElementById('recaptcha').value = token;
                    }
                });
            });
        </script>
    @endif

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
   
@endsection