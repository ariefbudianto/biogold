@extends('theme01.layout')
@section('content')
{{"Message"}}
<br />
@if(Session::get('flash_message'))
  <div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {!! Session::get('flash_message') !!}
  </div>
@endif
@stop