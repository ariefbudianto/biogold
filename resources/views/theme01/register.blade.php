@extends('theme01/layout')
@section('content')
<div class="col-md-6 col-sm-6 col-xs-12">	
	<h2>{{"Register Form"}}</h2>
	<form method="POST" action="{{url('registerProccess')}}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<div class="input-group">
		    <span class="input-group-addon"><span class="input-text">Nama Lengkap </span></span>
		    <input type="text" name="first_name" class="form-control input-lg" placeholder="Nama lengkap sesuai KTP" value="{{ old('first_name') }}" />
		    {!!$errors->first('first_name', '<div class="alert alert-danger"><b>:message</b></div>')!!}
		</div><!-- End .input-group -->
		<div style="clear:both;width:100%;height:20px;"></div>

		<div class="input-group">
		    <span class="input-group-addon"><span class="input-text">Email </span></span>
		    <input type="text" name="email" class="form-control input-lg" placeholder="Email" value="{{ old('email') }}" />
		    {!!$errors->first('email', '<div class="alert alert-danger"><b>:message</b></div>')!!}
		</div><!-- End .input-group -->
		<div style="clear:both;width:100%;height:20px;"></div>

		<div class="input-group">
		    <span class="input-group-addon"><span class="input-text">Nomor Handphone </span></span>
		    <input type="text" name="handphone" class="form-control input-lg" placeholder="Nomor handphone aktif" />
		    {!!$errors->first('handphone', '<div class="alert alert-danger"><b>:message</b></div>')!!}
		</div><!-- End .input-group -->
		<div style="clear:both;width:100%;height:20px;"></div>

		<div class="sm-margin"></div><!-- space -->
		<button type="submit" name="aksi" class="btn btn-primary btn-lg"> Join Now</button>
	</form>
</div>
@stop