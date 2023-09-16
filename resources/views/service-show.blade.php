@extends('layouts.frontend')

@section('css')
	<!-- Data Table CSS -->
	<link href="{{URL::asset('plugins/awselect/awselect.min.css')}}" rel="stylesheet" />

@endsection

@section('content')

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
           
                <h6 style="font-size:54px" class="fs-28 mt-6">{{ $service->title }}</h6>
              
            </div>
            
        </div>
        <div class="row mt-4">
			<div class="col-md-8">
                <div class="fs-18 text-justify" id="blog-view-mobile">{!! $service->body !!}</div>
            </div>
            <div class="col-md-4">
                <p class="text-left">More Services</p>
				@foreach($popularservices as $service)
                <div class="card" data-aos="zoom-in" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">
                    <div class="card-body">
                       <a href="{{ route('services.show', $service->url) }}">
                        <h5 class="blog-title fs-16 text-left mb-3">{{ __($service->title) }}</h5>
                       </a>
                    </div>
                </div>
				@endforeach
			
           
            </div>
            
        </div>
    </div>

    </section>
@endsection

@section('js')
	<!-- Awselect JS -->
	<script src="{{URL::asset('plugins/awselect/awselect.min.js')}}"></script>
	<script src="{{URL::asset('js/awselect.js')}}"></script>  
    <script src="{{URL::asset('js/minimize.js')}}"></script> 

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
@endsection
