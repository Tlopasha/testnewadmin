@extends("LaravelVueAdmin.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('LaravelVueAdmin.adminRoute') . '/pedicuristas') }}">Pedicurista</a> :
@endsection
@section("contentheader_description", $pedicurista->$view_col)
@section("section", "Pedicuristas")
@section("section_url", url(config('LaravelVueAdmin.adminRoute') . '/pedicuristas'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Pedicuristas Edit : ".$pedicurista->$view_col)

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

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($pedicurista, ['route' => [config('LaravelVueAdmin.adminRoute') . '.pedicuristas.update', $pedicurista->id ], 'method'=>'PUT', 'id' => 'pedicurista-edit-form']) !!}
					@lv_form($module)
					
					{{--
					@lv_input($module, 'nombre')
					@lv_input($module, 'apellidop')
					@lv_input($module, 'apellidom')
					@lv_input($module, 'sucursal_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('LaravelVueAdmin.adminRoute') . '/pedicuristas') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#pedicurista-edit-form").validate({
		
	});
});
</script>
@endpush
