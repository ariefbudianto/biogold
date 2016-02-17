@extends('theme01.layout')
@section('content')
<div class="jumbotron">
<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Join Sekarang <small>BioGold network!</small></h3>
      </div>
      <div class="panel-body">
        <form role="form" method="POST" action="{{url('registerProccess')}}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <div class="form-group {!! Session::get('add_class_error') !!}">
          	{!! $errors->first('first_name', '<label class="control-label" for="inputError">:message</label>') !!}
            <input type="text" name="first_name" class="form-control input-sm" placeholder="Nama lengkap sesuai KTP" value="{{ old('first_name') }}">
          </div>

          <div class="form-group {!! Session::get('add_class_error') !!}">
          	{!! $errors->first('email', '<label class="control-label" for="inputError">:message</label>') !!}
            <input type="email" name="email" class="form-control input-sm" placeholder="Alamat email" value="{{ old('email') }}" >
          </div>

          <div class="form-group {!! Session::get('add_class_error') !!}">
          	{!! $errors->first('handphone', '<label class="control-label" for="inputError">:message</label>') !!}
            <input type="text" name="handphone" class="form-control input-sm" placeholder="Nomor handphone aktif" value="{{ old('handphone') }}">
          </div>
		  <button type="submit" name="aksi" class="btn btn-info btn-block"> Join Now</button>

        </form>
      </div>
    </div>
  </div>
</div>
</div>
@stop
<style>
.centered-form .panel{
  background: rgba(255, 255, 255, 0.8);
  box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
}

.centered-form{
  margin-top: 60px;
}
</style>