@extends('layouts.auth')

@section('content')
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
                <form method="POST" action="{{ route('login') }}">
                    @csrf                                       

					<div style="text-align: center;">
    <a class="header-brand" href="https://www.myperfectwriting.co.uk" target="_blank">
        <img src="{{URL::asset('img/brand/logo.png')}}" style="max-width: 230px;">
    </a>
</div>

					
                    <h3 class="text-center font-weight-bold mb-8">{{ __('Welcome Back to') }} <span class="text-info"><a href="{{ url('/') }}">{{ config('app.name') }}</a></span><p class="text-center"><br><strong>"Do not trust us, Test Us"</strong></p>
</h3>
	

                    @if ($message = Session::get('success'))
                        <div class="alert alert-login alert-success"> 
                            <strong><i class="fa fa-check-circle"></i> {{ $message }}</strong>
                        </div>
                        @endif

                        @if ($message = Session::get('error'))
                        <div class="alert alert-login alert-danger">
                            <strong><i class="fa fa-exclamation-triangle"></i> {{ $message }}</strong>
                        </div>
                    @endif
                    
					
					   <div class="divider">
    <div class="divider-text text-muted">
        <small style="font-size: 18px; font-weight: bold;">{{ __('login with email') }}</small>
    </div>
</div>

                   
                    

                    <div class="input-box mb-4">                             
                        <label for="email" class="fs-12 font-weight-bold text-md-right">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off" placeholder="{{ __('Email Address') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror                            
                    </div>

                    <div class="input-box">
    <label for="password" class="fs-12 font-weight-bold text-md-right">{{ __('Password') }}</label>
    <div class="input-group">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="off" placeholder="{{ __('Password') }}" required>
        <div class="input-group-append">
            <span class="input-group-text" onclick="togglePasswordVisibility()"><i id="togglePasswordIcon" class="fa fa-eye"></i></span>
        </div>
    </div>
    @error('password')
        <span class="invalid-feedback" role="alert">
            {{ $message }}
        </span>
    @enderror
</div>


                    <div class="form-group mb-3">  
                        <div class="d-flex">                        
                            <label class="custom-switch">
                                <input type="checkbox" class="custom-switch-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">{{ __('Keep me logged in') }}</span>
                            </label>   

                           <div class="ml-auto">
    @if (Route::has('password.request'))
        <a class="text-info fs-12" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
    @endif
</div>

                        </div>
                    </div>

                    <input type="hidden" name="recaptcha" id="recaptcha">

                    <div class="form-group mb-0">                        
                        <button type="submit" class="btn btn-primary mr-2">{{ __('Login') }}</button>       
                        @if (config('settings.registration') == 'enabled')
                            <a href="{{ route('register') }}"  class="btn btn-cancel">{{ __('Sign Up') }}</a> 
                        @endif                         
                                               
                    </div>

                   <p class="fs-14 text-muted pt-3" style="font-weight: bold; font-size: 14px;">
    {{ __('By continuing, you agree to our') }}
    <a href="{{ route('terms') }}" class="text-info">{{ __('Terms and Conditions') }}</a>
    {{ __('and') }}
    <a href="{{ route('privacy') }}" class="text-info">{{ __('Privacy Policy') }}</a>
</p>

                    @if (config('settings.oauth_login') == 'enabled')
                       <div class="divider">
    <div class="divider-text text-muted">
        <small style="font-size: 18px; font-weight: bold;">{{__('Or Login with')}}</small>
    </div>
</div>


                        <div class="actions-total text-center">
                            @if(config('services.facebook.enable') == 'on')<a href="{{ url('/auth/redirect/facebook') }}" data-tippy-content="{{ __('Login with Facebook') }}" class="btn mr-2" id="login-facebook"><i class="fa-brands fa-facebook-f"></i></a>@endif
                            @if(config('services.twitter.enable') == 'on')<a href="{{ url('/auth/redirect/twitter') }}" data-tippy-content="{{ __('Login with Twitter') }}" class="btn mr-2" id="login-twitter"><i class="fa-brands fa-twitter"></i></a>@endif	
                            @if(config('services.google.enable') == 'on')<a href="{{ url('/auth/redirect/google') }}" data-tippy-content="{{ __('Login with Google') }}" class="btn mr-2" id="login-google"><i class="fa-brands fa-google"></i></a>@endif	
                            @if(config('services.linkedin.enable') == 'on')<a href="{{ url('/auth/redirect/linkedin') }}" data-tippy-content="{{ __('Login with Linkedin') }}" class="btn mr-2" id="login-linkedin"><i class="fa-brands fa-linkedin-in"></i></a>@endif	
                        </div>
@endif
                     

                </form>
            </div>     
        </div>
    </div>
</div>
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
    <script src="{{URL::asset('plugins/tippy/popper.min.js')}}"></script>
    <script src="{{URL::asset('plugins/tippy/tippy-bundle.umd.min.js')}}"></script>
    <script>
        tippy('[data-tippy-content]', {
                animation: 'scale-extreme',
                theme: 'material',
            });
    </script>
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
    
@endsection