{{-- @extends('templates.main')

@section('container')

<div class="row justify-content-center mb-3">
  <div class="col-auto">
    <h4>Praktik Kerja Lapangan</h4>
  </div>
</div>

<div class="card bg-body-tertiary mb-3">
  <div class="row m-2">
    <div class="col-auto ms-auto">
      <div class="modalPKLButton" type="button" data-bs-toggle="modal" data-bs-target="#modalPKL">
        <h3 class="m-0">
          <i class="bi bi-pencil-square"></i>
        </h3>
      </div>
    </div>    
  </div>

  <div class="row mx-3 mb-3">
    <div class="col bg-light-subtle rounded border">
      <div class="row">
        <div class="col-2 border-end py-4 text-center">
          Dosen Pembimbing
        </div>
        @if ($pkl && isset($pkl[0]))
          <div class="col-3 py-4 text-center">
            {{ $pkl[0]->dosen_pembimbing ?? '-' }}
          </div>
          <div class="col-3 py-4 text-center">
            Status PKL: {{ $pkl[0]->status ?? '-' }}
          </div>
          <div class="col-3 py-4 text-center">
            Nilai PKL: {{ $pkl[0]->nilai ?? '-' }}
          </div>
        @else
          <div class="col-3 py-4 text-center">
            Dosen Pembimbing: -
          </div>
          <div class="col-3 py-4 text-center">
            Status PKL: <span class="text-danger">belum</span>
          </div>
          <div class="col-3 py-4 text-center">
            Nilai PKL: <span class="text-danger">belum</span>
          </div>
        @endif
        <div class="col-1 bg-body-secondary text-center py-4">
          @if ($pkl && isset($pkl[0]))
            <div class="modalPKLButton" type="button" data-bs-toggle="modal" data-bs-target="#modalPKL" data-dospem="{{ $pkl[0]->dosen_pembimbing }}" data-status="{{ $pkl[0]->status }}" data-nilai="{{ $pkl[0]->nilai }}" data-tahun="{{ $pkl[0]->tahun }}" data-scan-berita-acara="{{ $pkl[0]->scan_berita_acara }}" data-validasi="{{ $pkl[0]->validasi }}">
          @else
            <div class="modalPKLButton" type="button" data-bs-toggle="modal" data-bs-target="#modalPKL">
          @endif
            <h4 class="m-0">
              <i class="bi bi-pencil-square"></i>
            </h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{</div>
@include('mahasiswa.pkl.modal_edit_pkl')
<script src="js/modal.js"></script>
@endsection --}}



@extends('templates.main')

@section('container')

<div class="row justify-content-center mb-3">
  <div class="col-auto">
    <h4>Praktik Kerja Lapangan</h4>
  </div>
</div>

<div class="card bg-body-tertiary mb-3">
  <div class="row m-2">
    <div class="col-auto ms-auto">
      <div class="modalPKLButton" type="button" data-bs-toggle="modal" data-bs-target="#modalPKL">
        <h3 class="m-0">
          <i class="bi bi-pencil-square"></i>
        </h3>
      </div>
    </div>    
  </div>

  <div class="row d-flex justify-content-center my-2 mx-2">
    <div class="col-4 border-end text-center py-3">
      <div class="row">
        <div class="col">
          <h5>Dosen Pembimbing</h5>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>-</h5>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>Tahun</h5>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>-</h5>
        </div>
      </div>
    </div>

    <div class="col-4 text-center py-3 ">
      <div class="row">
        <div class="col">
          <h5>Status</h5>
        </div>
      </div>
      <div class="row mt-3 justify-content-center">
        <div class="col-auto bg-body-secondary rounded border ">
          <h3>Belum Ambil</h3>
        </div>
      </div>
    </div>
    
    <div class="col-4 text-center py-3 border-start">
      <div class="row">
        <div class="col">
          <h5>Nilai</h5>
        </div>
      </div>
      <div class="row mt-3 justify-content-center">
        <div class="col-auto bg-body-secondary rounded border ">
          <h3>-</h3>
        </div>
      </div>
    </div>
  </div>
</div>
@include('mahasiswa.pkl.modal_edit_pkl')
<script src="js/modal.js"></script>
@endsection