@extends('layouts.app')

@section('css')
<!-- Sweet Alert CSS -->
<link href="{{URL::asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet" />
@endsection


@section('content')
<!-- USER PROFILE PAGE -->

<form action="{{route('user.place_order')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <h4 class="mt-3 page-title">TYPE OF WORK AND DEADLINE</h4>
        <div class="form-group col-lg-9 mt-2">
            <label for="">Select Service</label>
            <select name="service_id" class="form-control">
                @foreach($services as $service)
                <option value="{{$service->id}}">{{$service->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-3 mt-2">
            <label for="">No. Of Pages</label>
            <input type="number" name="qty" class="form-control">
        </div>
        <div class="form-group col-lg-6 mt-2">
            <label for="">Work Level</label>
            <select name="work_level_id" class="form-control">
                @foreach($work_levels as $wl)
                <option value="{{$wl->id}}">{{$wl->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-6 mt-2">
            <label for="">Urgency</label>
            <select name="urgency_id" class="form-control">
                @foreach($urgencies as $Urgency)
                <option value="{{$Urgency->id}}">{{$Urgency->value}}{{$Urgency->type}}</option>
                @endforeach
            </select>
        </div>
        <h4 class="mt-3 page-title">ADDITIONAL PAPER DETAILS</h4>
        <div class="form-group col-lg-12 mt-2">
            <label for="">Title </label>
            <input type="text" name="title" class="form-control">
        </div>
        <div class="form-group col-lg-12 mt-2">
            <label for="">Formatting Style (MLA, APA, Chicago, Harvard and Other) </label>
            <input type="text" name="formatting" class="form-control">
        </div>
        <div class="form-group col-lg-12 mt-2">
            <label for="">Specific Instructions </label>
            <textarea name="specifications"  class="form-control"></textarea>
        </div>
        <div class="form-group col-lg-12 mt-2">
            <label for="">File</label>
            <input type="file" name="file" class="form-control">
        </div>
        <div class="form-group col-lg-12 mt-2">
            <button class="btn btn-success btn-block">Submit</button>
        </div>
    </div>
</form>

<!-- END USER PROFILE PAGE -->
@endsection