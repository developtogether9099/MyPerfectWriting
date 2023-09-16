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
        <h4 class="page-title mb-0">{{ __('All Unassigned Orders') }}</h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-id-badge mr-2 fs-12"></i>{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{ __('Unassigned Orders List') }}</li>
        </ol>
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
                                <th>Title</th>
                                <th>Service Type</th>
                                <th>Posted</th>
                                <th>Deadline</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                       
                        </tbody>
                    </table>
                    <!-- END DATATABLE -->

                </div> <!-- END BOX CONTENT -->
            </div>
        </div>
    </div>
</div>
<!-- END USERS LIST DATA TABEL -->
@endsection
@section('js')
	<!-- Data Tables JS -->
	<script src="{{URL::asset('plugins/datatable/datatables.min.js')}}"></script>
	<script src="{{URL::asset('plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
	<script type="text/javascript">
		$(function () {

			"use strict";
			
			var table = $('#listUsersTable').DataTable({
				"lengthMenu": [[10, 50, 100, -1], [25, 50, 100, "All"]],
				responsive: true,
				colReorder: true,
				"order": [[ 0, "desc" ]],
				language: {
					search: "<i class='fa fa-search search-icon'></i>",
					lengthMenu: '_MENU_ ',
					paginate : {
						first    : '<i class="fa fa-angle-double-left"></i>',
						last     : '<i class="fa fa-angle-double-right"></i>',
						previous : '<i class="fa fa-angle-left"></i>',
						next     : '<i class="fa fa-angle-right"></i>'
					}
				},
				pagingType : 'full_numbers',
				processing: true,
				serverSide: true,
				ajax: "{{ route('admin.assign') }}",
				columns: [
					{
						data: 'title',
						name: 'title',
						orderable: true,
						searchable: true
					},
				
					{
						data: 'service',
						name: 'service',
						orderable: true,
						searchable: true
					},
					{
						data: 'posted',
						name: 'posted',
						orderable: true,
						searchable: true
					},
					{
						data: 'deadline',
						name: 'deadline',
						orderable: true,
						searchable: true
					},
					
				]
			});

		
	
		});
	</script>
@endsection