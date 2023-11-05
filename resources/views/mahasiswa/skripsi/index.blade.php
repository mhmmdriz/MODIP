@extends('templates.main')

@section('container')

@section('container')
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

<div class="card bg-body-tertiary mb-3">
  <div class="row m-2 position-absolute" style="right: 0">
    <div class="col-auto ms-auto">
      <h4 class="m-0" >
        <div class="modalSkripsiButton" type="button" data-bs-toggle="modal" data-bs-target="#modalSkripsi" data-status="{{ $dataSkripsi->status }}" data-tanggal-sidang="{{ $dataSkripsi->tanggal_sidang }}" data-tanggal-lulus="{{ $dataSkripsi->tanggal_lulus }}" data-nilai="{{ $dataSkripsi->nilai }}" data-scan-skripsi="{{ $dataSkripsi->scan_bass }}">
        <i class="bi bi-pencil-square"></i>
      </h4>
    </div>
  </div>
  <div class="row d-flex justify-content-center align-items-center my-2 mx-2">
    <div class="col-4 border-end text-center py-3">
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
      <div class="row">
        <div class="col">
          <h6>Tanggal Lulus</h6>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>{{ (isset($dataSkripsi->tanggal_lulus))?$dataSkripsi->tanggal_lulus:"~" }}</h5>
        </div>
      </div>
    </div>

    <div class="col-4 text-center py-3 ">
      <div class="row">
        <div class="col">
          <h5>Status</h5>
        </div>
      </div>
      <div class="row mb-3 justify-content-center">
        <div class="col-auto bg-body-secondary rounded border ">
          <h3>{{ $dataSkripsi->status }}</h3>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h6>Lama Studi (Dalam Semester)</h6>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h4>{{ $semester }}</h4>
        </div>
      </div>
    </div>
    
    <div class="col-4 text-center py-3 border-start">
      <div class="row">
        <div class="col">
          <h5>Nilai</h5>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-auto bg-body-secondary rounded border">
          <h3>{{ (isset($dataSkripsi->nilai))?$dataSkripsi->nilai:"~" }}</h3>
        </div>
      </div>
      <div class="row mt-3">
        @if ($dataSkripsi->validasi == 1)
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
<script src="js/modal.js"></script>

@endsection