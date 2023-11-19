@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
  </ol>
</nav>

@if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="card bg-body-tertiary mb-3">
  <div class="row">
    <div class="col-md-auto m-4">
      @if (auth()->user()->departemen->foto_profil == null)
        <img src="/showFile/private/profile_photo/default.jpg" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
      @else
        <img src="/showFile/{{ auth()->user()->departemen->foto_profil }}" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
      @endif
    </div>
    <div class="col m-4">
      <h5><b>Departemen Informatika</b></h5>
      <hr>
      <table class="table">
        <tr>
          <td class="bg-transparent">Departemen ID</td>
          <td class="bg-transparent">: {{ auth()->user()->departemen->departemen_id }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">No Telp</td>
          <td class="bg-transparent">: {{ auth()->user()->departemen->no_telp }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">Email SSO</td>
          <td class="bg-transparent">: {{ auth()->user()->departemen->email_sso }}</td>
        </tr>
      </table>
      <a href="/profile/edit" class="btn btn-primary me-2" role="button">Edit Profil</a>
      <a href="/profile/edit-password" class="btn btn-secondary" role="button">Ganti Password</a>
    </div>
  </div>
</div>

@endsection