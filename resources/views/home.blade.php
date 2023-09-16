@extends('layouts.frontend')

@section('css')
    <link href="{{URL::asset('plugins/slick/slick.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/slick/slick-theme.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('plugins/aos/aos.css')}}" rel="stylesheet" />


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
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12" >
        <section id="main-wrapper">
            <div class="h-100vh justify-center min-h-screen" id="main-background">
                <div class="container h-100vh" style="padding: 20px;">
                    <div class="row h-100vh vertical-center">
                        <div class="col-sm-8 upload-responsive">
                            <div class="text-container">
                                <h3 class="mb-4 font-weight-bold text-white" data-aos="fade-left" data-aos-delay="400" data-aos-once="true" data-aos-duration="700">{{ __('Meet') }}, {{ config('app.name') }}</h3>
                                <h1 class="text-white" data-aos="fade-left" data-aos-delay="500" data-aos-once="true" data-aos-duration="700">{{ __('The Future of Essay Writing') }}</h1>
                                <h1 class="mb-0 gradient fixed-height" id="typed" data-aos="fade-left" data-aos-delay="600" data-aos-once="true" data-aos-duration="900"></h1>
                                <p class="fs-18 text-white" data-aos="fade-left" data-aos-delay="700" data-aos-once="true" data-aos-duration="1100"> Get Academic Writing Service Only <i class="fa {{format_amount(1)['icon']}}"></i>{{format_amount(6.99)['amount']}}/page </p>
                                <a href="{{ route('register') }}" class="btn btn-primary special-action-button" data-aos="fade-left" data-aos-delay="800" data-aos-once="true" data-aos-duration="1100">{{ __('Write My Essay Now') }}</a>
                            </div>
							 
                                        
                                        <div style="margin-top: 30px;">
                                            <img src="{{ URL::asset('img/files/tp.png') }}" alt="" style="width: 20%; margin-right: 20px;">
											<img src="{{ URL::asset('img/files/tp.png') }}" alt="" style="width: 20%; margin-right: 20px;">
											<img src="{{ URL::asset('img/files/tp.png') }}" alt="" style="width: 20%;">
                                        </div>
                                   
                        </div>
						<div class="col-sm-4 upload-responsive">
						     <div class="card border-0 " style="background-color: #3C3465;">
                        <div class="card-body p-2 ">
                            <!-- BOX CONTENT -->
                            <div class="box-content" style="color: #ffffff;">
                                <form id="submit-order" method="post" enctype="multipart/form-data" class="row">
                                    @csrf
                                    <div class="col-md-12">
                                        <h4 class="mt-1 page-title text-center" style="color: #f49d1d;">Calculate Price</h4>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group ">
                                            <select name="service_id" class="form-control" id="f-service" required>
                                                <option value="" disabled selected>What can we do for you?</option>
                                                @foreach($services as $service)
                                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <select name="work_level_id" class="form-control" id="f-wl" required>
                                                <option value="" disabled selected>You study at?</option>
                                                @foreach($work_levels as $wl)
                                                    <option value="{{$wl->id}}">{{$wl->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="pp" value="{{format_amount(6.99)['amount']}}">
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
                                            <input type="date" name="deadline_date" id="deadline-date" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 mt-2">
                                        <div class="form-group">
                                            <label for="deadline-time">Time</label>
                                            <select name="deadline_time" id="deadline-time" class="form-control" required>
                                                @php
                                                    $currentHour = date('H');
                                                    $currentMinute = (int) date('i');
                                                    $currentMinute = $currentMinute - ($currentMinute % 15); // Round down to the nearest 15 minutes
                                                @endphp
                                                @for ($hour = 0; $hour < 24; $hour++)
                                                    @for ($minute=0; $minute < 60; $minute +=15)
                                                        @php
                                                            $optionValue = sprintf('%02d:%02d', $hour, $minute);
                                                            $disabled = ($hour < $currentHour || ($hour === $currentHour && $minute < $currentMinute)) ? 'disabled' : '';
                                                            $selected = ($hour === $currentHour && $minute === $currentMinute) ? 'selected' : '';
                                                        @endphp
                                                        <option value="{{ $optionValue }}" {{ $disabled }} {{ $selected }}>
                                                            {{ $optionValue }}
                                                        </option>
                                                    @endfor
                                                @endfor
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
                                               
                                                    <p class="text-left">Total Amount <span class="float-right"> <i class="fa {{format_amount(1)['icon']}}"></i><span id="total">0</span></span>  </p>
                                                    <p class="text-left">No. of Pages <span class="float-right" id="qty">0</span>  </p>
													<div style="width:220px; margin:0 auto">
												
														<a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary"><i class="fas fa-video"></i> Play Video</a>
														@if(auth()->user())
															<a href="{{route('user.services')}}" class="btn btn-primary">Write My Essay</a>
														@else
															<a href="{{route('login')}}" class="btn btn-primary">Write My Essay</a>
														@endif
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
                        <h6>{{ __('Our') }} <span>{{ __('Partners') }}</span></h6>
                        <p class="mb-0">{{ __('Be among the many that trust us') }}</p>
                    </div>

                </div> <!-- END SECTION TITLE -->

                <div class="row" id="partners">
                            
                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/Icon1.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div>    
                    
                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/Icon2.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/Icon3.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/Icon4.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/Icon5.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/Icon6.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/Icon7.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 
                </div>
            </div>

        </section> <!-- END SECTION BANNER -->

        <!-- SECTION - FEATURES
        ========================================================-->
        @if (config('frontend.features_section') == 'on')
            <section id="features-wrapper">

                {!! adsense_frontend_features_728x90() !!}
                

                <div class="container">

                    <div class="row text-center mt-8 mb-8">
                        <div class="col-md-12 title">
                            <h6><span>{{ config('app.name') }}</span> {{ __('Benefits') }}</h6>
                            <p>{{ __('Enjoy the full flexibility of the platform with ton of features') }}</p>
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
                                            <img src="{{ URL::asset('img/files/01.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __('Essays: Fixed Price, No Deadline Fees!') }}</h5>
                                        
                                        <p>Experience academic excellence and affordability with MyPerfectWriting's exceptional custom essay writing service. Our professional writers deliver top-quality papers on time without any additional charges for deadlines, making your success their priority.</p>

                                    </div>                         

                                </div>

                            </div> <!-- END SOLUTION -->
                            
                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="1500" data-aos-once="true" data-aos-duration="1500">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="{{ URL::asset('img/files/09.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __('Academic Writing: Same Price, All Education Levels!') }}</h5>
                                        
                                        <p> </p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->

                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="2000" data-aos-once="true" data-aos-duration="2000">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="{{ URL::asset('img/files/06.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __(' ') }}</h5>
                                        
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
                                            <img src="{{ URL::asset('img/files/05.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __(' ') }}</h5>
                                        
                                        <p> </p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->


                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="1500" data-aos-once="true" data-aos-duration="1500">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="{{ URL::asset('img/files/03.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __(' ') }}</h5>
                                        
                                        <p> </p>

                                    </div>                                

                                </div>

                            </div> <!-- END SOLUTION -->


                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="2000" data-aos-once="true" data-aos-duration="2000">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="{{ URL::asset('img/files/04.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __(' ') }}</h5>
                                        
                                        <p> </p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->
                        </div>

                        <div class="col-md-4 col-sm-12 d-flex">

                            <div class="feature-text">
                                <div>
                                    <h4><span class="text-primary">{{ config('app.name') }}</span> {{ __(' ') }}</h4>
                                </div>
                                
                                <p> </p>
                                <p> </p>
                            </div>
                            
                        </div>
                        
                    </div> <!-- END LIST OF SOLUTIONS -->
         

                </div>

            </section>
        @endif


       


        <!-- SECTION - CUSTOMER FEEDBACKS
        ========================================================-->
        @if (config('frontend.reviews_section') == 'on')
            <section id="feedbacks-wrapper">

                <div class="container pt-4 text-center">


                    <!-- SECTION TITLE -->
                    <div class="row mb-8" style="margin-top: 100px;">

                        <div class="title">
                            <h6>{{ __('Customer') }} <span>{{ __('Reviews') }}</span></h6>
                            <p>{{ __('We guarantee that you will be one of our happy customers as well') }}</p>
                        </div>

                    </div> <!-- END SECTION TITLE -->

                    @if ($review_exists)

                        <div class="row" id="feedbacks">
                            
                            @foreach ($reviews as $review)
                                <div class="feedback" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                                    <!-- MAIN COMMENT -->
                                    <p class="comment"><sup><span class="fa fa-quote-left"></span></sup> {{ __($review->text) }} <sub><span class="fa fa-quote-right"></span></sub></p>

                                    <!-- COMMENTER -->
                                    <div class="feedback-image d-flex">
                                        <div>
                                            <img src="{{ URL::asset($review->image_url) }}" alt="Feedback" class="rounded-circle"><span class="small-quote fa fa-quote-left"></span>
                                        </div>

                                        <div class="pt-3">
                                            <p class="feedback-reviewer">{{ __($review->name) }}</p>
                                            <p class="fs-12">{{ __($review->position) }}</p>
                                        </div>
                                    </div>	
                                </div> 
                            @endforeach                                                       
                        </div>

                        <!-- ROTATORS BUTTONS -->
                        <div class="offers-nav">
                            <a class="offers-prev"><i class="fa fa-chevron-left"></i></a>
                            <a class="offers-next"><i class="fa fa-chevron-right"></i></a>                                
                        </div>

                    @else
                        <div class="row text-center">
                            <div class="col-sm-12 mt-6 mb-6">
                                <h6 class="fs-12 font-weight-bold text-center">{{ __('No customer reviews were published yet') }}</h6>
                            </div>
                        </div>
                    @endif

                    
                    
                </div> <!-- END CONTAINER -->
                
            </section> <!-- END SECTION CUSTOMER FEEDBACK -->
        @endif
        
        
         


        <!-- SECTION - PRICING
        ========================================================-->
        @if (config('frontend.pricing_section') == 'on')
            
        @endif


  		<!-- SECTION - SERVICES
        ========================================================-->
        @if (config('frontend.services_section') == 'on')
         <div  style="margin-bottom: 100px;"> 
<section id="service-wrapper">
    <div class="container text-center">
        <!-- SECTION TITLE -->
        <div class="row mb-8 mt-5">
            <div class="title w-100">
                <h6><span>{{ __('Our Academic Writing') }}</span> {{ __('Services') }}</h6>
                <p>{{ __('Unleashing the power of words to bring your ideas to life with creativity and precision') }}</p>
				<form class="row justify-content-center" action="{{route('services')}}" method="get">
					<div class="text-container text-center col-lg-4 col-12 d-flex">
						<input type="text" name="search" class="typeahead form-control" placeholder="Search Services here..." />
						<button class="btn btn-primary" style="border-radius:5px !important">Search</button>
					</div>
				</form>
            </div>
        </div> <!-- END SECTION TITLE -->

        @if ($dservice_exists)
            <!-- Services -->
            <div class="row" id="dservices">
                @foreach($dservices as $ds)
                    <div class="col-md-4 mb-3 service-item">
                        <div class="card">
                            <a href="{{ route('services.show', $ds->url) }}">
                                <div class="card-body">
                                    {{ $ds->title }}
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
		<a class="btn btn-primary" href="{{route('services')}}"> View All </a>
        @endif

    </div> <!-- END CONTAINER -->
</section> <!-- END SECTION SERVICES -->
        @endif
      <!-- SECTION - FAQ
        ========================================================-->
        @if (config('frontend.faq_section') == 'on')
            <section id="faq-wrapper">    
                <div class="container pt-7">

                    <div class="row text-center mb-8 mt-7">
                        <div class="col-md-12 title">
                            <h6>{{ __('Frequently Asked') }} <span>{{ __('Questions') }}</span></h6>
                            <p>{{ __('Got questions? We have you covered.') }}</p>
                        </div>
                    </div>

                    <div class="row justify-content-md-center">
        
                        @if ($faq_exists)

                            <div class="col-md-10">
        
                                @foreach ( $faqs as $faq )

                                    <div id="accordion" data-aos="fade-left" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                                        <div class="card">
                                            <div class="card-header" id="heading{{ $faq->id }}">
                                                <h5 class="mb-0">
                                                <span class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="false" aria-controls="collapse-{{ $faq->id }}">
                                                    {{ __($faq->question) }}
                                                </span>
                                                </h5>
                                            </div>
                                        
                                            <div id="collapse-{{ $faq->id }}" class="collapse" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordion">
                                                <div class="card-body">
                                                    {!! __($faq->answer) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                    
        
                        @else
                            <div class="row text-center">
                                <div class="col-sm-12 mt-6 mb-6">
                                    <h6 class="fs-12 font-weight-bold text-center">{{ __('No FAQ answers were published yet') }}</h6>
                                </div>
                            </div>
                        @endif
            
                    </div>        
                </div>
        
            </section> <!-- END SECTION FAQ -->
        @endif

        <!-- SECTION - BLOGS
        ========================================================-->
        @if (config('frontend.blogs_section') == 'on')
            <section id="blog-wrapper">

                <div class="container text-center">


                    <!-- SECTION TITLE -->
                    <div class="row mb-8 mt-5">

                        <div class="title w-100" style="margin-top: 100px;">
                            <h6><span>{{ __('Latest') }}</span> {{ __('Blogs') }}</h6>
                            <p>{{ __('Unlocking Knowledge: Your Premier Source for Expert Essay Insights and Academic Excellence') }}</p>
							<form class="row justify-content-center" action="{{route('blogs')}}" method="get">
								<div class="text-container text-center col-lg-4 col-12 d-flex">
									<input type="text" name="search" class="typeahead form-control" placeholder="Search Blogs here..." />
									<button class="btn btn-primary" style="border-radius:5px !important">Search</button>
								</div>
							</form>
                        </div>

                    </div> <!-- END SECTION TITLE -->

                    @if ($blog_exists)
                        
                        <!-- BLOGS -->
                        <div class="row" id="blogs">
                            @foreach ( $blogs as $blog )
                            <div class="blog" data-aos="zoom-in" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">			 							<a href="{{ route('blogs.show', $blog->url) }}">
                                <div class="blog-box">
                                    <div class="blog-img">
                                       <img src="{{ URL::asset($blog->image) }}" alt="Blog Image">
                                    </div>
                                    <div class="blog-info">
                                        <h6 class="blog-date text-left text-muted mt-3 pt-1 mb-4"><span class="mr-2">{{ $blog->created_by }}</span> | <i class="mdi mdi-alarm mr-2"></i>{{ date('j F Y', strtotime($blog->created_at)) }}</h6>
                                        <h5 class="blog-title fs-16 text-left mb-3">{{ __($blog->title) }}</h5>                                     
                                    </div>
                                </div>  
								</a>
                            </div> 
                            @endforeach
                        </div> 
                        

                        <!-- ROTATORS BUTTONS -->
                        <div class="blogs-nav">
                            <a class="blogs-prev"><i class="fa fa-chevron-left"></i></a>
                            <a class="blogs-next"><i class="fa fa-chevron-right"></i></a>                                
                        </div>

                    @else
                        <div class="row text-center">
                            <div class="col-sm-12 mt-6 mb-6">
                                <h6 class="fs-12 font-weight-bold text-center">{{ __('No blog articles were published yet') }}</h6>
                            </div>
                        </div>
                    @endif

				<a class="btn btn-primary text-center" href="{{route('blogs')}}"> View All </a>
                </div> <!-- END CONTAINER -->

                {!! adsense_frontend_blogs_728x90() !!}
                
            </section> <!-- END SECTION BLOGS -->
        @endif




  

        
        <!-- SECTION - CONTACT US
        ========================================================-->
        @if (config('frontend.contact_section') == 'on')
            <section id="contact-wrapper">

                <div class="container pt-9">       
                    
                    <!-- SECTION TITLE -->
                    <div class="row mb-8 text-center">

                        <div class="title w-100">
                            <h6><span>{{ __('Contact') }}</span> {{ __('With Us') }}</h6>
                            <p>{{ __('Reach out to us for additional information') }}</p>
                        </div>

                    </div> <!-- END SECTION TITLE -->

                    
                    <div class="row">                
                        
                        <div class="col-md-6 col-sm-12" data-aos="fade-left" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                            <img class="w-70" src="{{ URL::asset('img/files/about.svg') }}" alt="">
                        </div>

                        <div class="col-md-6 col-sm-12" data-aos="fade-right" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                            <form id="" action="{{ route('contact') }}" method="POST" enctype="multipart/form-data">
                                @csrf
        
                                <div class="row justify-content-md-center">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="off" placeholder="{{ __('First Name') }}" required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" autocomplete="off" placeholder="{{ __('Last Name') }}" required>
                                            @error('lastname')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror                            
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row justify-content-md-center">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off"  placeholder="{{ __('Email Address') }}" required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="off"  placeholder="{{ __('Phone Number') }}" required>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror                            
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="input-box">							
                                            <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="10" required placeholder="{{ __('Message') }}"></textarea>
                                            @error('message')
                                                <p class="text-danger">{{ $errors->first('message') }}</p>
                                            @enderror	
                                        </div>
                                    </div>
                                </div>
        
                                <input type="hidden" name="recaptcha" id="recaptcha">
                                
                                <div class="row justify-content-md-center text-center">
                                    <!-- ACTION BUTTON -->
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary special-action-button">{{ __('Send Message') }}</button>							
                                    </div>
                                </div>
                            
                            </form>
        
                        </div>                   
                        
                    </div>
                
                </div>
        
            </section>
        @endif

@endsection

@section('js')

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
        var page = 1;
        var hasMoreServices = {{ $hasMoreServices ? 'true' : 'false' }};

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


@endsection
