@extends('theme01.layout')
@section('content')
<div class="jumbotron">
  <div class="row centered-form">
    <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title">Login</h3>
        </div>
        <div class="panel-body">
          @if(Session::get('errors'))
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             @foreach($errors->all('<li>:message</li>') as $message)
               {!! $message !!}
              @endforeach
            </div>
          @endif
            <form role="form" method="POST" action="{{ route('user.authorization') }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}" />
              <div class="form-group {!! Session::get('add_class_error') !!}">
                <input type="email" name="email" class="form-control input-sm" placeholder="Email" value="{{ old('email') }}" >
              </div>

              <div class="form-group {!! Session::get('add_class_error') !!}">
                <input type="password" name="password" class="form-control input-sm" placeholder="Password" value="{{ old('password') }}">
              </div>
              <div class="checkbox">
                <label>
                  <input name="remember" type="checkbox" value="1"> Remember Me
                </label>
                  <a href="{{ route('user.passwordreset') }}" class="pull-right">Lupa Password?</a>
              </div>
              <button type="submit" name="aksi" class="btn btn-info btn-block"> Login</button>
            </form>
        </div><!--END div panel-body-->
        <div class="text-center">
        <a href="{{ route('user.signup') }}" >Belum punya akun? Register</a>
        </div>
      </div><!--END div panel-default-->
    </div><!--END div col-xs-12..-->
  </div><!--END div centered-form-->
</div>
@stop
<style>
.centered-form{
margin-top: 60px;
}
.centered-form .panel{
background: rgba(255, 255, 255, 0.8);
box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
color: #4e5d6c;
}
</style>