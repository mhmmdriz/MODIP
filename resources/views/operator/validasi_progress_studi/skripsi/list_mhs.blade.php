@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/validasiProgress">Validasi Progress Studi</a></li>
    <li class="breadcrumb-item"><a href="/validasiProgress/validasiSkripsi">Validasi Skripsi</a></li>
    <li class="breadcrumb-item active" aria-current="page">List Angkatan {{ $angkatan }}</li>
  </ol>
</nav>

<div class="row d-flex justify-content-center mt-5 mb-2">
  <div class="col-md-auto">
    <h5>Daftar Skripsi Mahasiswa Angkatan {{ $angkatan }}</h5>
  </div>
</div>

<div class="row">
  <div class="col-md-4">
    <form action="/validasiProgress/validasiSkripsi/{{ $angkatan }}" method="get">
      <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Cari Akun">
    </form>
  </div>
</div>

<div class="row my-4">
  <div class="col">
    <div id="tabelMHS" class="card table-responsive px-1">
      <table class="table m-0">
        <tr>
          <th>No</th>
          <th>Nama Mahasiswa</th>
          <th>NIM/Username</th>
          <th>Status</th>
          <th>Validasi</th>
          <th>Action</th>
        </tr>

        @php
          $i = 0;
        @endphp
      
        @foreach ($data_mhs as $mhs)
          <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $mhs->nama }}</td>
            <td>{{ $mhs->nim }}</td>
            <td>{{ $mhs->status}}</td>
            @if (isset($data_skripsi[$mhs->nim]))
              @if ($data_skripsi[$mhs->nim] == 1)
                <td class="text-success">Sudah</td>
              @else
                <td class="text-danger">Belum</td>
              @endif
            @else
              <td>~</td>
            @endif
            <td>
              <a class="btn btn-primary btn-sm" href="/validasiProgress/validasiSkripsi/{{ $mhs->angkatan }}/{{ $mhs->nim }}">Detail Skripsi</a>
            </td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>

@endsection