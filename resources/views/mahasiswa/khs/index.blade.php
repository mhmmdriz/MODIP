@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">KHS</li>
  </ol>
</nav>

@if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="card bg-body-tertiary mb-3">
  <div class="row d-flex justify-content-center mt-3">
    <div class="col-auto">
      <h5>Data KHS</h5>
    </div>
  </div>

  <div class="row mx-3">
    <div class="col-auto">
      <p>Semester Aktif: {{ $semester }}</p>
    </div>
    <div class="col-auto ms-auto">
      SKSk: {{ $SKSk }}
    </div>
    <div class="col-auto">
      IPk: {{ number_format($IPk, 2) }}
    </div>
  </div>

  @for ($i = 1; $i <= $semester; $i++)
  <div class="row mx-3 mb-3">
    <div class="col bg-light-subtle rounded border">
      <div class="row">
        <div class="col-2 border-end d-flex justify-content-center align-items-center">
          Semester {{ $i }}
        </div>
        <div class="col-2 py-4 d-flex justify-content-center align-items-center flex-column">
          <div>
            @if (!isset($khs[$i-1]))
              SKS: ~
            @else
              SKS: {{ $khs[$i-1]->sks }}
            @endif
          </div>
          <div>
            @if (!isset($khs[$i-1]))
              SKSk: ~
            @else
              SKSk: {{ $khs[$i-1]->sksk }}
            @endif
          </div>
        </div>
        
        <div class="col-2 py-4 d-flex justify-content-center align-items-center flex-column">
          <div>
            @if (!isset($khs[$i-1]))
              IPs: ~
            @else
              IPs: {{ number_format($khs[$i-1]->ips,2) }}
            @endif
          </div>
          <div>
            @if (!isset($khs[$i-1]))
              IPk: ~
            @else
              IPk: {{ number_format($khs[$i-1]->ipk,2) }}
            @endif
          </div>
        </div>
        
        <div class="col-2 py-4 text-center">
          @if (!isset($khs[$i-1]))
            Scan KHS : <span class="text-danger">belum</span>
          @else
            Scan KHS : <span class="text-success">sudah</span>
          @endif
        </div>
        
        <div class="col-3 py-4 text-center">
          @if (!isset($khs[$i-1]))
            Validasi : <span class="text-danger">belum</span>
          @else
            @if ($khs[$i-1]->validasi == 0)
              Validasi : <span class="text-danger">belum</span>
            @else
              Validasi : <span class="text-success">sudah</span>
            @endif
          @endif    
        </div>

        <div class="col-1 bg-body-secondary text-center py-4">
          @if (($i == 1 || isset($khs[$i-2])) && isset($irs[$i-1]))
            @if (!isset($khs[$i-1]))
            <div class="modalKHSButton" type="button" data-bs-toggle="modal" data-bs-target="#modalKHS" data-smt="{{ $i }}">
              <h4 class="m-0" >
                <i class="bi bi-pencil-square"></i>
              </h4>
            </div>
            @else
              @if ($khs[$i-1]->validasi == 0)
              <div class="modalKHSButton" type="button" data-bs-toggle="modal" data-bs-target="#modalKHS" 
              data-smt="{{ $i }}" data-scan-khs="{{ $khs[$i-1]->scan_khs }}" data-sks="{{ $khs[$i-1]->sks }}" data-ips="{{ $khs[$i-1]->ips }}" data-sksk="{{ $khs[$i-1]->sksk }}" data-ipk="{{ $khs[$i-1]->ipk }}">
                <h4 class="m-0" >
                  <i class="bi bi-pencil-square"></i>
                </h4>
              </div>
              @else
              <div><h4 class="m-0" >
                  <i class="bi bi-check-square"></i>
                </h4>
              </div>
              @endif
            @endif
          @else
            <div class="modalAlert" type="button" data-bs-toggle="modal" data-bs-target="#modalAlert"><h4 class="m-0" >
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

@include('mahasiswa.khs.modal_alert')
@include('mahasiswa.khs.modal_edit_khs')
<script src="js/modal.js"></script>

@endsection
