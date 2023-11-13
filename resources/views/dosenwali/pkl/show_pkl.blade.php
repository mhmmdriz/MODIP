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
    <h4>Praktik Kerja Lapangan</h4>
  </div>
</div>

<div class="card p-2 ps-3 mb-2 bg-body-tertiary">
  <div>Nama: {{ $nama }}</div>
  <div>NIM: {{ $nim }}</div>
</div>

<div class="card bg-body-tertiary mb-3">
  <div class="row m-2 position-absolute" style="right: 0">
    <div class="col-auto ms-auto">
      <h4 class="m-0" >
        @if (isset($dataPKL))
          <div class="modalPKLButton" type="button" data-bs-toggle="modal" data-bs-target="#modalPKL" data-status="{{ $dataPKL->status }}" data-semester="{{ $dataPKL->semester }}" data-tanggal-seminar="{{ $dataPKL->tanggal_seminar }}" data-nilai="{{ $dataPKL->nilai }}" data-scan-pkl="{{ $dataPKL->scan_basp }}">
        @else
          <div class="modalPKLButton" type="button" data-bs-toggle="modal" data-bs-target="#modalPKL" data-status="" data-semester="" data-tanggal-seminar="" data-nilai="" data-scan-pkl="">
        @endif
        <i class="bi bi-pencil-square"></i>
      </h4>
    </div>
  </div>

  <div class="row m-2 position-absolute" style="bottom: 0;right: 0">
    @if (isset($dataPKL))
      @if ($dataPKL->status == "Lulus")
        @if ($dataPKL->validasi == 0)
          <a href="/pklPerwalian/{{ $angkatan }}/{{ $nim }}/validatePKL/1" class="btn btn-success btn-sm" type="button">
            Validasi
          </a>
        @else
          <a href="/pklPerwalian/{{ $angkatan }}/{{ $nim }}/validatePKL/0" class="btn btn-danger btn-sm" type="button">
            Batal Validasi
          </a>
        @endif
      @endif
    @endif
  </div>

  <div class="row d-flex justify-content-center align-items-center my-2 mx-2">
    <div class="col-4 border-end text-center py-3">
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

    <div class="col-4 text-center py-3">
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
    
    <div class="col-4 text-center py-3 border-start">
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
        @if (isset($dataPKL) && !is_null($dataPKL->scan_basp))
          <div class="col">
            <h6 class="m-0">Scan BASS: <a href="/scan-pkl/{{ $dataPKL->scan_basp }}">scan-basp.pdf</a></h6>
          </div>
        @else
          <div class="col">
            <h6 class="m-0">Scan BASS: ~</h6>
          </div>
        @endif
      </div>
      <div class="row my-3">
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

@include('dosenwali.pkl.modal_edit_pkl')
<script src="/js/modal.js"></script>

@endsection