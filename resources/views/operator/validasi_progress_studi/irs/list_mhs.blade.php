@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/validasiProgress">Validasi Progress Studi</a></li>
    <li class="breadcrumb-item"><a href="/validasiProgress/validasiIRS">Validasi IRS</a></li>
    <li class="breadcrumb-item active" aria-current="page">List Angkatan {{ $angkatan }}</li>
  </ol>
</nav>

<div class="row d-flex justify-content-center my-2">
  <div class="col-md-auto">
    <h5>Data IRS Mahasiswa Angkatan {{ $angkatan }}</h5>
  </div>
</div>

<div class="row">
  <div class="col-md-4">
    <form action="/validasiProgress/validasiIRS/{{ $angkatan }}" method="get">
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
          <th>SKSk</th>
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
            <td>{{ $mhs->status }}</td>
            @if (isset($data_irs[$mhs->nim]))
              <td>{{ $data_irs[$mhs->nim]['sksk'] }}</td>
            @else
              <td>~</td>
            @endif
            <td>
              <a class="btn btn-primary btn-sm" href="/validasiProgress/validasiIRS/{{ $angkatan }}/{{ $mhs->nim }}">Detail IRS</a>
            </td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection