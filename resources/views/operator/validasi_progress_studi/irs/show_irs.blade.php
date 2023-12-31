@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/validasiProgress">Validasi Progress Studi</a></li>
    <li class="breadcrumb-item"><a href="/validasiProgress/validasiIRS">Validasi IRS</a></li>
    <li class="breadcrumb-item"><a href="/validasiProgress/validasiIRS/{{ $angkatan }}">List Angkatan {{ $angkatan }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail IRS {{ $mahasiswa->nim }}</li>
  </ol>
</nav>

@if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="card p-2 ps-3 mb-2 bg-body-tertiary">
  <div>Nama: {{ $mahasiswa->nama }}</div>
  <div>NIM: {{ $nim }}</div>
</div>

<div class="card bg-body-tertiary my-2">
  <div class="row d-flex justify-content-center mt-3">
    <div class="col-auto">
      <h5>Data IRS</h5>
    </div>
  </div>

  <div class="row mx-3">
    <div class="col-auto">
      <p>Semester Aktif : {{ $semester }}</p>
    </div>
    <div class="col-auto  ms-auto">
      <p>SKSk : {{ $SKSk }}</p>
    </div>
  </div>

  @for ($i = 1; $i <= $semester; $i++)
  <div class="row mx-3 mb-3">
    <div class="col bg-light-subtle rounded border">
      <div class="row">
        <div class="col-6 col-md-auto">
          <div class="row my-2">
            <div class="col">
              Semester {{ $i }}
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-auto text-center ">
              @if (!isset($irs[$i-1]))
                Jumlah SKS: ~
              @else
                Jumlah SKS: {{ $irs[$i-1]->sks }}
              @endif
            </div>
            
            <div class="col-auto text-center">
              @if (!isset($irs[$i-1]))
                Scan IRS : <span class="text-danger">belum</span>
              @else
                Scan IRS : 
                <a href="/showFile/{{ $irs[$i-1]->scan_irs }}" target="__blank" class="text-success text-decoration-none">
                  scanIrs{{ $i }}.pdf
                </a>
              @endif    
            </div>
            
            <div class="col-auto text-center">
    
              @if (!isset($irs[$i-1]))
                Validasi : <span class="text-danger">belum</span>
              @else
                @if ($irs[$i-1]->validasi == 0)
                  Validasi : <span id="info_validasi{{ $i }}" class="text-danger">belum</span>
                @else
                  Validasi : <span id="info_validasi{{ $i }}" class="text-success">sudah</span>
                @endif
              @endif    
    
            </div>
          </div>
        </div>
        
        <div class="col-auto my-auto ms-auto">
          @if (isset($irs[$i-1]))
            @if ($irs[$i-1]->validasi == 0)
              <button type="button" class="btn btn-success btn-sm validasi" data-nim="{{ $nim }}" data-smt="{{ $i }}" data-progress="irs">Validasi</button>
            @else
              <button type="button" class="btn btn-danger btn-sm validasi" data-nim="{{ $nim }}" data-smt="{{ $i }}" data-progress="irs">Batalkan Validasi</button>
            @endif
          @endif
        </div>

        <div class="col-auto my-auto">
          @if (isset($irs[$i-1]))
            <div class="modalIRSButton" type="button" data-bs-toggle="modal" data-bs-target="#modalIRS" data-smt="{{ $i }}" data-scan-irs="{{ $irs[$i-1]->scan_irs }}" data-sks="{{ $irs[$i-1]->sks }}">
              <h4 class="m-0">
                <i class="bi bi-pencil-square"></i>
              </h4>
            </div>
          @endif
        </div>
        
      </div>
    </div>
  </div>
      
  @endfor

</div>

<script src="/js/modal.js"></script>
@include('operator.validasi_progress_studi.irs.modal_edit_irs')
<script src="/js/validasi.js"></script>
{{-- <script src="/js/operator.js"></script> --}}

@endsection

