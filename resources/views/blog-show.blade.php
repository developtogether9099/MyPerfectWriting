@extends('layouts.frontend')

@section('css')
<link href="{{URL::asset('plugins/slick/slick.css')}}" rel="stylesheet" />
<link href="{{URL::asset('plugins/slick/slick-theme.css')}}" rel="stylesheet" />
<link href="{{URL::asset('plugins/aos/aos.css')}}" rel="stylesheet" />
<style>
    .blogsss img {
        min-height: 270px;
        padding: 0.5rem;
        border-radius: 16px;
        background-color: #fff;
        box-shadow: 0 3px 7px 0 rgba(0, 0, 0, 0.08), 0 3px 3px 0 rgba(0, 0, 0, 0.1), 0 3px 2.5px -5px rgba(0, 0, 0, 0.16);
        transition: all 0.5s;
    }

    #blog-wrapper .blog {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }

    /* Add custom styling for the sticky sidebar */
    .sticky-sidebar {
        position: -webkit-sticky;
        position: sticky;
        top: 90px;
        /* Adjust this value to control the sticky position */
        z-index: 999;
        /* Ensure the sidebar appears above other elements */

    }

    /* Optional styling to adjust the appearance of the sidebar links */
    .sticky-sidebar ul {
        list-style: none;
        padding-left: 0;
    }

    .sticky-sidebar li {
        margin-bottom: 5px;
    }

    .sticky-sidebar li:last-child {
        margin-bottom: 0;
    }

    .sticky-sidebar a {
        color: #1e1e2d;
        text-decoration: none;
        transition: color 0.3s;
    }

    .sticky-sidebar a:hover {
        color: #f49d1d;
    }

    @media (max-width: 767px) {
        .related-articles {
            display: none;
        }


    }
</style>
@endsection

@section('content')

<section id="blog-wrapper">

    <div class="container pt-9">

        <div class="row justify-content-md-center align-items-center" style="margin-bottom:50px">
            <div class="col-md-7">
                <p>Written By <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=400&q=60" style="width:50px;height:50px;border-radius:50%"> {{ $blog->created_by }}</p>
                <h6 style="font-size:40px; ">{{ $blog->title }}</h6>
                <div class="row col-md-12 col-sm-12 justify-content-center" style="padding: 0px;">
                    <div class="col-md-2">
                        <p class="fs-11">{{ $readTime }} min read</p>
                    </div>
                    <div class="col-md-4">
                        <p class="fs-11">Published on: {{ date('j F Y', strtotime($blog->created_at)) }}</p>
                    </div>

                    <div class="col-md-4">

                        <p class="fs-11">Last updated on: {{ date('j F Y', strtotime($blog->updated_at)) }}</p>

                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12">
                <div class="blogsss">
                    <img src="{{ URL::asset($blog->image) }}" alt="Blog Image">
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-3">

                <div class="table-of-contents sticky-sidebar">
                    <div style="margin-bottom:50px">
                        <p class="text-left" style="font-size:20px; font-weight: 800;">Table of Content</p>
                        <ul id="table-of-contents-list">

                        </ul>
                    </div>


                </div>

            </div>

            <div class="col-md-6" id="body">
                <div class="fs-14" id="blog-view-mobile">{!! $blog->body !!}</div>

            </div>

            <div class="col-md-3">
                <div class="sticky-sidebar">
                    <div class="mb-3">
                        <p class="text-left" style="font-size:20px; font-weight: 800;">Share this Article</p>
                        <div class="sharethis-inline-share-buttons"></div>
                    </div>
                    <p class="text-left" style="font-size:20px; font-weight: 800;">Popular Articles</p>
                    @foreach($popularBlogs as $pblog)
                    <div class="blog my-2">
                        <a href="{{ route('blogs.show', $pblog->url) }}">
                            <div class="blog-box">
                                <div class="blog-img">
                                    <img src="{{ URL::asset($pblog->image) }}" alt="Blog Image">
                                </div>
                                <div class="blog-info">
                                    <h6 class="blog-date text-left text-muted mt-3 pt-1 mb-4"><span class="mr-2">{{ $pblog->created_by }}</span> | <i class="mdi mdi-alarm mr-2"></i>{{ date('j F Y', strtotime($blog->created_at)) }}</h6>
                                    <h5 class="blog-title fs-14 text-left mb-3">{{ Str::limit($pblog->title, 30) }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach


                </div>
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


<script>
    // JavaScript to generate the table of contents dynamically
    document.addEventListener("DOMContentLoaded", function() {
        const headings = document.querySelectorAll("#blog-view-mobile h2");
        const tableOfContentsList = document.getElementById("table-of-contents-list");

        headings.forEach(function(heading, index) {
            const text = heading.textContent;
            const slug = text.toLowerCase().replace(/ /g, "-") + "-" + (index + 1);

            // Add an anchor link to the heading
            heading.id = slug;

            // Create the table of contents link
            const listItem = document.createElement("li");
            const link = document.createElement("a");
            link.href = "#" + slug;
            link.textContent = text;

            // Append the link to the list item and the list item to the table of contents list
            listItem.appendChild(link);
            tableOfContentsList.appendChild(listItem);
        });
    });
</script>

<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=64bf887d1734a80012bd60b6&product=inline-share-buttons&source=platform" async="async"></script>
@endsection