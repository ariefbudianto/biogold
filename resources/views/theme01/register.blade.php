@extends('theme01/layout')
@section('content')
{{"Register Form"}}
@if (count($errors) > 0)
	<ul>
	@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
	@endforeach
	</ul>
@endif
<form method="POST" action="{{url('registerproses')}}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12">	
		<div class="input-group">
		    <span class="input-group-addon"><span class="input-text">Email </span></span>
		    <input type="text" name="email" class="form-control input-lg" placeholder="Email" value="">
		</div><!-- End .input-group -->
		<div style="clear:both;width:100%;height:20px;">

		<div class="input-group">
		    <span class="input-group-addon"><span class="input-text">Username </span></span>
		    <input type="text" name="username" class="form-control input-lg" placeholder="Username">
		</div><!-- End .input-group -->
		<div style="clear:both;width:100%;height:20px;">

		<div class="input-group">
		    <span class="input-group-addon"><span class="input-text">Password </span></span>
		    <input type="password" name="password" class="form-control input-lg" placeholder="Password">
		</div><!-- End .input-group -->
		<div style="clear:both;width:100%;height:20px;">
		
		<div class="input-group">
		    <span class="input-group-addon"><span class="input-text">Ulangi Password </span></span>
		    <input type="password" name="password_confirm" class="form-control input-lg" placeholder="Konfirmasi password">
		</div><!-- End .input-group -->
		<div style="clear:both;width:100%;height:20px;">

		<div class="sm-margin"></div><!-- space -->
		<button type="submit" name="aksi" class="btn btn-primary btn-lg"> Join Now</button>
		</div>
	</div>
</form>


@stop