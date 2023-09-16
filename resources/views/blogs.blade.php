@extends('layouts.frontend')

@section('css')


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
                        
					<div class="col-md-6 upload-responsive">
						<form action="{{route('blogs')}}" method="get">
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


@if (config('frontend.blogs_section') == 'on')
<section id="blog-wrapper">

    <div class="container text-center">


        <!-- SECTION TITLE -->
        <div class="row mb-8 ">

            <div class="title w-100" style="margin-top: 100px;">
                <h6><span>{{ __('Our') }}</span> {{ __('Blogs') }}</h6>
                <p>{{ __('Read our unique blog articles about various data archiving solutions and secrets') }}</p>
            </div>

        </div> <!-- END SECTION TITLE -->

        @if ($blog_exists)

        <!-- BLOGS -->
        <div class="row">
            @foreach ( $blogs as $blog )
            <div class="blog col-md-4 my-3" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">
               <a href="{{ route('blogs.show', $blog->url) }}">
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


   		<div class="d-flex justify-content-center" style="margin-top: 60px;"> {{$blogs->links()}}</div>

        @else
        <div class="row text-center">
            <div class="col-sm-12 mt-6 mb-6">
                <h6 class="fs-12 font-weight-bold text-center">{{ __('No blog articles were published yet') }}</h6>
            </div>
        </div>
        @endif

    </div> <!-- END CONTAINER -->

    {!! adsense_frontend_blogs_728x90() !!}

</section> <!-- END SECTION BLOGS -->
@endif

@endsection

@section('js')


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<script type="text/javascript">
    var path = "{{ route('blogs.search') }}";
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