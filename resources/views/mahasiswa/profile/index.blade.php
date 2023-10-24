@extends('templates.main')

@section('container')
<div class="card bg-body-tertiary mb-3">
  <div class="row">
    <div class="col-md-auto m-4">
      <img src="{{ asset("storage/profile_photo/default.jpg") }}" alt="" style="border-radius:50%; width:120px">
    </div>
    <div class="col m-4">
      <h5><b>{{ auth()->user()->mahasiswa->nama }}</b></h5>
      <hr>
      <table class="table">
        <tr>
          <td class="bg-transparent">NIM</td>
          <td class="bg-transparent">: {{ auth()->user()->mahasiswa->nim }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">Angkatan</td>
          <td class="bg-transparent">: {{ auth()->user()->mahasiswa->angkatan }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">Jalur Masuk</td>
          <td class="bg-transparent">: {{ auth()->user()->mahasiswa->jalur_masuk }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">Status</td>
          <td class="bg-transparent">: {{ auth()->user()->mahasiswa->status }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">No Telp</td>
          <td class="bg-transparent">: {{ auth()->user()->mahasiswa->no_telp }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">Email SSO</td>
          <td class="bg-transparent">: {{ auth()->user()->mahasiswa->email_sso }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">Email Pribadi</td>
          <td class="bg-transparent">: {{ auth()->user()->mahasiswa->email_pribadi }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">Alamat</td>
          <td class="bg-transparent">: {{ auth()->user()->mahasiswa->alamat }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">Kabupaten/Kota</td>
          <td class="bg-transparent">: {{ auth()->user()->mahasiswa->kabupaten_kota }}</td>
        </tr>
        <tr>
          <td class="bg-transparent">Provinsi</td>
          <td class="bg-transparent">: {{ auth()->user()->mahasiswa->provinsi }}</td>
        </tr>
      </table>
      <a href="/profile-edit" class="btn btn-primary me-2" role="button">Edit Profil</a>
      <a href="/profile-account" class="btn btn-secondary" role="button">Ganti Password</a>
    </div>
  </div>
</div>

@endsection