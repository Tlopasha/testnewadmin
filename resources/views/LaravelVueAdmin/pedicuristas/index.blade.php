@extends("LaravelVueAdmin.layouts.app")

@section("contentheader_title", "Pedicuristas")
@section("contentheader_description", "Pedicuristas listing")
@section("section", "Pedicuristas")
@section("sub_section", "Listing")
@section("htmlheader_title", "Pedicuristas Listing")

@section("headerElems")
@lv_access("Pedicuristas", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Pedicurista</button>
@endlv_access
@endsection

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>Actions</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>

@lv_access("Pedicuristas", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Pedicurista</h4>
			</div>
			{!! Form::open(['action' => 'LaravelVueAdmin\PedicuristasController@store', 'id' => 'pedicurista-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @lv_form($module)
					
					{{--
					@lv_input($module, 'nombre')
					@lv_input($module, 'apellidop')
					@lv_input($module, 'apellidom')
					@lv_input($module, 'sucursal_id')
					--}}
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endlv_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('LaravelVueAdmin/assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('LaravelVueAdmin/assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('LaravelVueAdmin.adminRoute') . '/pedicurista_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#pedicurista-add-form").validate({
		
	});
});
</script>
@endpush
