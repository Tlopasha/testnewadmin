@extends("LaravelVueAdmin.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('LaravelVueAdmin.adminRoute') . '/sucursals') }}">Sucursal</a> :
@endsection
@section("contentheader_description", $sucursal->$view_col)
@section("section", "Sucursals")
@section("section_url", url(config('LaravelVueAdmin.adminRoute') . '/sucursals'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Sucursals Edit : ".$sucursal->$view_col)

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
				{!! Form::model($sucursal, ['route' => [config('LaravelVueAdmin.adminRoute') . '.sucursals.update', $sucursal->id ], 'method'=>'PUT', 'id' => 'sucursal-edit-form']) !!}
					@lv_form($module)
					
					{{--
					@lv_input($module, 'nombre')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('LaravelVueAdmin.adminRoute') . '/sucursals') }}">Cancel</a></button>
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
	$("#sucursal-edit-form").validate({
		
	});
});
</script>
@endpush
