@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Entry Progress Studi</li>
  </ol>

</nav>

<div class="row d-flex justify-content-center mt-5 mb-2">
  <div class="col-md-auto">
    <h5>List Mahasiswa</h5>
  </div>
</div>

<div class="row">
  <div class="col-md-4">
    <input type="text" class="form-control" id="keyword" onkeyup="updateTableEntryProgressMHS()" placeholder="Cari Nama/NIM" autocomplete="off">
  </div>
  <div class="col-md-4">
    <select name="angkatan" class="form-control" id="angkatan" onchange="updateTableEntryProgressMHS()">
      <option value="" selected>Filter Angkatan</option>
      @foreach ($data_angkatan as $angkatan)
        <option value="{{ $angkatan }}">{{ $angkatan }}</option>
      @endforeach
    </select>
  </div>
</div>

<div class="row my-4">
  <div class="col">
    <div class="card bg-body-tertiary">
      <div id="tabelMHS">
        <table class="table table-stripped m-0">
          <tr>
            <th>No</th>
            <th>Nama Mahasiswa</th>
            <th>NIM</th>
            <th>Angkatan</th>
            <th>Status</th>
            <th>Action (Entry)</th>
          </tr>

          @php
            $i = 0;
          @endphp
        
          @foreach ($data_mhs as $mhs)
            {{-- @dd($mhs->user->password) --}}
            <tr>
              <td>{{ ++$i }}</td>
              <td>{{ $mhs->nama }}</td>
              <td>{{ $mhs->nim }}</td>
              <td>{{ $mhs->angkatan}}</td>
              <td>{{ $mhs->status}}</td>
              <td>
                <a class="btn btn-info btn-sm mb-1" href="/entryProgress/entryIRS/{{ $mhs->nim }}">IRS</a>
                <a class="btn btn-primary btn-sm mb-1" href="/entryProgress/entryKHS/{{ $mhs->nim }}">KHS</a>
                <a class="btn btn-warning btn-sm mb-1" href="/entryProgress/entryPKL/{{ $mhs->nim }}">PKL</a>
                <a class="btn btn-success btn-sm mb-1" href="/entryProgress/entrySkripsi/{{ $mhs->nim }}">Skripsi</a>
              </td>
            </tr>
          @endforeach
        </table>
      </div>

    </div>
  </div>
</div>

<script src="/js/ajax.js"></script>

@endsection