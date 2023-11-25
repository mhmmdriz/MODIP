@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">PKL</li>
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
    <h4>Praktik Kerja Lapangan</h4>
  </div>
</div>

<div class="card bg-body-tertiary mb-3">
  <div class="row m-2 position-absolute" style="right: 0">
    <div class="col-auto ms-auto">
        @if (isset($dataPKL) && $is_eligible)
          @if ($dataPKL->validasi == 0)
          <div class="modalPKLButton" type="button" data-bs-toggle="modal" data-bs-target="#modalPKL" data-status="{{ $dataPKL->status }}" data-semester="{{ $dataPKL->semester }}" data-tanggal-seminar="{{ $dataPKL->tanggal_seminar }}" data-nilai="{{ $dataPKL->nilai }}" data-scan-pkl="{{ $dataPKL->scan_basp }}">
            <h4 class="m-0" >
              <i class="bi bi-pencil-square"></i>
            </h4>
          </div>
          @else
          <div>
            <h4 class="m-0" >
              <i class="bi bi-check-square"></i>
            </h4>
          </div>
          @endif
        @else
          @if ($is_eligible)
            <div class="modalPKLButton" type="button" data-bs-toggle="modal" data-bs-target="#modalPKL" data-status="" data-semester="" data-tanggal-seminar="" data-nilai="" data-scan-pkl="">
              <h4 class="m-0" >
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
          <h6>Tanggal Seminar</h6>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col">
          <h5>{{ (isset($dataPKL->tanggal_seminar))?$dataPKL->tanggal_seminar:"~" }}</h5>
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
        <div class="col-auto {{ (isset($dataPKL->status) && $dataPKL->status == "Lulus")?"bg-success":"bg-body-secondary" }} rounded border text-white">
          <h3 class="my-1">{{ (isset($dataPKL->status))?$dataPKL->status:"~" }}</h3>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h6>Semester PKL</h6>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h4>{{ (isset($dataPKL->semester))?$dataPKL->semester:"~" }}</h4>
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
          <h3 class="my-1">{{ (isset($dataPKL->nilai))?$dataPKL->nilai:"~" }}</h3>
        </div>
      </div>
      <div class="row mt-3">
        @if ((isset($dataPKL->validasi) && $dataPKL->validasi == 1))
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

@if ($is_eligible)
@include('mahasiswa.pkl.modal_edit_pkl')
@else
@include('mahasiswa.pkl.modal_alert')
@endif
<script src="/js/modal.js"></script>

@endsection
