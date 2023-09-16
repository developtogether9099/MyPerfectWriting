@extends('layouts.frontend')

@section('css')
<link href="{{URL::asset('plugins/slick/slick.css')}}" rel="stylesheet" />
<link href="{{URL::asset('plugins/slick/slick-theme.css')}}" rel="stylesheet" />
<link href="{{URL::asset('plugins/aos/aos.css')}}" rel="stylesheet" />
<style>
	 .pageBg {
		 background:black;
    background-image: url("https://img.freepik.com/free-photo/3d-dark-grunge-display-background-with-smoky-atmosphere_1048-16218.jpg");
	}
</style>

@endsection

@section('content')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <section id="main-wrapper">
			
            <div class="h-50vh justify-center min-h-screen pageBg">
                <div class="container" style="padding-top: 160px; padding-bottom: 100px;">
                       <div class="row align-items-center justify-content-center h-50vh vertial-center">
                       
                        	<div class="col-sm-6 upload-responsive">
							<form action="{{route('services')}}" method="get">
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


@if (config('frontend.blogs_section') == 'on')
<section id="blog-wrapper">

    <div class="container text-center">


       
        <div class="row mb-8">

            <div class="title w-100" style="margin-top: 100px;">
                <h6><span>{{ __('Our') }}</span> {{ __('Services') }}</h6>
                <p>{{ __('Unleashing the power of words to bring your ideas to life with creativity and precision') }}</p>
            </div>

        </div> 

        @if ($service_exists)

       
        <div class="row">
            @foreach ( $services as $service )
                 <div class="col-md-4 mb-3 service-item">
                        <div class="card">
                            <a href="{{ route('services.show', $service->url) }}">
                                <div class="card-body">
									<p>{{ request()->segment(22) }}</p>
                                    {{ $service->title }}
                                </div>
                            </a>
                        </div>
                    </div>
            @endforeach
			
			
        </div>


   		<div class="d-flex justify-content-center" > {{$services->links()}}</div>

        @else
        <div class="row text-center">
            <div class="col-sm-12 mt-6 mb-6">
                <h6 class="fs-12 font-weight-bold text-center">{{ __('No Services were published yet') }}</h6>
            </div>
        </div>
        @endif

    </div> 



</section> 
@endif

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<script type="text/javascript">
    var path = "{{ route('services.search') }}";
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
@endsection
