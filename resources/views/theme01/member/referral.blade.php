@extends('theme01.member.layout')
@section('content')
<div class="jumbotron">
  <h4>Table Data</h4>
  <table id="referral">
  <thead>
    <tr>
      <th>Nama</th>
      <th>Username</th>
      <th>Email</th>
    </tr>
  </thead>
</table>
</div>
@stop
@section('includejs')
  @parent 
  <link href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
@stop
@section('javascript')
  @parent    
    $('#referral').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('user.referralData') !!}'
    });
@stop





