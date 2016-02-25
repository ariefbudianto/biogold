@extends('theme01.member.layout')
@section('content')
<div class="jumbotron">
  <h4>Table Data</h4>
  <table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Nama</th>
      <th>Username</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
  <?php $no = $users->firstItem() - 1; ?>
  @foreach ($users as $user)
    <?php $no++; ?>
    <tr>
      <td>{{ $no }}</td>
      <td>{{ $user->first_name}}</td>
      <td>{{ $user->username}}</td>
      <td>{{ $user->email}}</td>
    </tr>
  @endforeach
  </tbody>
</table>
{!! str_replace('/?', '?', $users->render()) !!}
</div>
@stop




