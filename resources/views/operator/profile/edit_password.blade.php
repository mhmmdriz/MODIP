@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/profile">Profile</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Password</li>
  </ol>
</nav>

{{-- <div class="row d-flex justify-content-center"> --}}
  <div class="card p-0 mb-3">
    <div class="card-header">Edit Password</div>
    <div class="card-body">
      <form action="/profile/edit-password" method="POST" class="needs-validation">
        @csrf
        @method('put')
        <div class="mb-3">
          <label for="password_lama" class="form-label">Password Lama</label>
          <input type="password" class="form-control @error('password_lama') is-invalid @enderror" id="password_lama" name="password_lama" value="{{ old('password_lama') }}">
          @error('password_lama')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="password_baru" class="form-label">Password Baru</label>
          <input type="password" class="form-control @error('password_baru') is-invalid @enderror" id="password_baru" name="password_baru" value="{{ old('password_baru') }}">
          @error('password_baru')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
          <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror" id="konfirmasi_password" name="konfirmasi_password" value="{{ old('konfirmasi_password') }}">
          @error('konfirmasi_password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary me-2">Simpan</button>
        <a href="/profile" class="btn btn-danger">Batal</a>
    </div>
  </div>
{{-- </div> --}}

@endsection