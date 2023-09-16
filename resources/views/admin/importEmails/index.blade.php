@extends('layouts.app')

@section('css')
<!-- Data Table CSS -->
<link href="{{URL::asset('plugins/datatable/datatables.min.css')}}" rel="stylesheet" />
<!-- Sweet Alert CSS -->
<link href="{{URL::asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
<!-- PAGE HEADER -->
<div class="page-header mt-5-7">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">{{ __('All Emails') }}</h4>

    </div>
    <div class="page-rightheader">


        <div class="page-rightheader">
            <a href="{{ route('admin.email.create') }}" class="select_all btn btn-primary mt-1">{{ __('Send Email') }}</a>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Import Excel File
            </button>
        </div>
    </div>
</div>
<!-- END PAGE HEADER -->
@endsection

@section('content')
<!-- USERS LIST DATA TABEL -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-xm-12">
        <div class="card border-0">

            <div class="card-body pt-2">
                <!-- BOX CONTENT -->
                <div class="box-content">

                    <!-- DATATABLE -->
                    <table id='listUsersTable' class='table listUsersTable' width='100%'>
                        <thead>
                            <tr>
                                <th> <input type="checkbox" id="master"> </th>
                                <th>{{ __('First Name') }}</th>
                                <th>{{ __('Last Name') }}</th>
                                <th>{{ __('Email') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($emails as $email)
                            <tr>
                                <td>
                                   <input type="checkbox" class="sub_chk" data-id="{{$email->id}}">
                                </td>
                                <td>
                                    {{$email->firstname}}
                                </td>
                                <td>
                                    {{$email->lastname}}
                                </td>
                                <td>
                                    {{$email->email}}
                                </td>
    
                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- END DATATABLE -->

                </div> <!-- END BOX CONTENT -->
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Excel File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <button type="submit" class="btn btn-primary mt-3">IMPORT</button>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- END USERS LIST DATA TABEL -->
@endsection

@section('js')




<script type="text/javascript">
    $(document).ready(function () {


        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });


        $('.select_all').on('click', function(e) {


            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  
  


                var check = confirm('Email will be sent to '+allVals.length+' users');  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({
                        url: "{{route('admin.addEmailId')}}",
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                 
                            conole('Done');
                            
                        }
                    });


                 
                
            }  
        });


     
    });
</script>
@endsection