@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    @if (auth()->user()->level == 'operator')
      <li class="breadcrumb-item"><a href="/entryProgress">Entry Progress Studi</a></li>
    @endif
    <li class="breadcrumb-item active" aria-current="page">Skripsi</li>
  </ol>
</nav>

@if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="row justify-content-center mb-3">
  <div class="col-auto">
    <h4>Skripsi</h4>
  </div>
</div>

@if (auth()->user()->level == 'operator')
  <div class="card p-2 ps-3 mb-2 bg-body-tertiary">
    <div>Nama: {{ $mahasiswa->nama }}</div>
    <div>NIM: {{ $mahasiswa->nim }}</div>
  </div>
@endif

<div class="card bg-body-tertiary mb-3">
  <div class="row m-2 position-absolute" style="right: 0">
    <div class="col-auto ms-auto">
      @if (isset($dataSkripsi) && $is_eligible)
        @if ($dataSkripsi->validasi == 0)
        <div class="modalSkripsiButton" type="button" data-bs-toggle="modal" data-bs-target="#modalSkripsi" data-status="{{ $dataSkripsi->status }}" data-semester="{{ $dataSkripsi->semester }}" data-tanggal-sidang="{{ $dataSkripsi->tanggal_sidang }}" data-nilai="{{ $dataSkripsi->nilai }}" data-scan-skripsi="{{ $dataSkripsi->scan_bass }}">
          <h4 class="m-0">
            <i class="bi bi-pencil-square"></i>
          </h4>
        </div>
          @else
          <div>
            <h4 class="m-0">
              <i class="bi bi-check-square"></i>
            </h4>
          </div>
          @endif
      @else
        @if ($is_eligible)
          <div class="modalSkripsiButton" type="button" data-bs-toggle="modal" data-bs-target="#modalSkripsi" data-status=""
          data-semester="" data-tanggal-sidang="" data-nilai="" data-scan-skripsi="">
            <h4 class="m-0">
              <i class="bi bi-pencil-square"></i>
            </h4>
          </div>
        @else
          <div class="modalAlert" type="button" data-bs-toggle="modal" data-bs-target="#modalAlert"><h4 class="m-0" >
            <h4 class="m-0" >
              <i class="bi bi-x-square"></i>
            </h4>
          </div>
        @endif
      @endif
    </div>
  </div>
  <div class="row d-flex justify-content-center align-items-center my-2 mx-2">
    <div class="col-4 text-center py-3">
      <div class="row">
        <div class="col">
          <h6>Tanggal Sidang</h6>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col">
          <h5>{{ (isset($dataSkripsi->tanggal_sidang))?$dataSkripsi->tanggal_sidang:"~" }}</h5>
        </div>
      </div>
    </div>

    <div class="col-4 text-center py-3 border-end border-start">
      <div class="row">
        <div class="col">
          <h5>Status</h5>
        </div>
      </div>
      <div class="row mb-3 justify-content-center">
        <div class="col-auto {{ (isset($dataSkripsi->status) && $dataSkripsi->status == "Lulus")?"bg-success":"bg-body-secondary" }} rounded border text-white">
          <h3 class="my-1">{{ (isset($dataSkripsi->status))?$dataSkripsi->status:"~" }}</h3>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h6>Semester Skripsi</h6>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h4>{{ (isset($dataSkripsi->semester))?$dataSkripsi->semester:"~" }}</h4>
        </div>
      </div>
    </div>
    
    <div class="col-4 text-center py-3">
      <div class="row">
        <div class="col">
          <h5>Nilai</h5>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-auto bg-body-secondary rounded border">
          <h3 class="my-1">{{ (isset($dataSkripsi->nilai))?$dataSkripsi->nilai:"~" }}</h3>
        </div>
      </div>
      <div class="row mt-3">
        @if (isset($dataSkripsi) && $dataSkripsi->validasi == 1)
          <div class="col">
            <h6>Validasi: <span class="text-success">Sudah</span></h6>
          </div>
        @else
          <div class="col">
            <h6>Validasi: <span class="text-danger">Belum</span></h6>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

@include('mahasiswa.skripsi.modal_edit_skripsi')
@include('mahasiswa.skripsi.modal_alert')
<script src="/js/modal.js"></script>

@endsection