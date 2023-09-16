@extends('layouts.frontend')

@section('css')
<style>
  
    .image-wrapper {
        position: relative;
    }

    .play-icon-wrapper {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .fa-play-circle {
        font-size: 100px;
        animation: changeColor 2s linear infinite; 
    }

    @keyframes changeColor {
        0% {
            font-size: 100px;
        }
        50% {
           font-size: 110px;
        }
        100% {
            font-size: 100px;
        }
    }
</style>

@endsection

@section('content')

    <section id="blog-wrapper">

        <div class="container pt-9">

           <div class="row justify-content-md-center align-items-center" style="margin-bottom:50px">
            <div class="col-md-6">
               
                <h6 style="font-size:40px; font-weight: 800;" class="fs-30 mt-6">Pricing</h6>
                <div class="row col-md-12 col-sm-12" style="padding: 0px;">
                   
                </div>
            </div>
			   
			   
             <div class="col-md-6 col-sm-12">
           
                    <img src="https://sweet-northcutt.35-221-213-75.plesk.page/img/blogs/Tc93yJ9BFB.jpg" alt="Image">
                <div class="play-icon-wrapper">
                            <i data-bs-toggle="modal" data-bs-target="#exampleModal" class="fa fa-play-circle text-success"></i>
                        </div>
            </div>
			   
			   
        </div>

           
        </div>


    </section>


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
@endsection

@section('js')

@endsection
