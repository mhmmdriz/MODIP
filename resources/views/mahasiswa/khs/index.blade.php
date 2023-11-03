@extends('templates.main')

@section('container')
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
      <p>Semester Aktif : {{ $semester }}</p>
    </div>
    <div class="col-auto  ms-auto">
      <p>IPK : {{ $SKSk }}</p>
    </div>
  </div>

  @for ($i = 1; $i <= $semester; $i++)
  <div class="row mx-3 mb-3">
    <div class="col bg-light-subtle rounded border">
      <div class="row ">
        <div class="col-2 border-end py-4 text-center">
          Semester {{ $i }}
        </div>
        <div class="col-2 py-4 text-center ">
          @if ($khs[$i-1] == null)
            Jumlah SKS: ~
          @else
            Jumlah SKS: {{ $khs[$i-1]->sks }}
          @endif
        </div>
        
        <div class="col-1 py-4 text-center ">
          @if ($khs[$i-1] == null)
            IPS: ~
          @else
            IPS: {{ $khs[$i-1]->ips }}
          @endif
        </div>
        
        <div class="col-3 py-4 text-center">

          @if ($khs[$i-1] == null)
            Scan KHS : <span class="text-danger">belum</span>
          @else
            Scan KHS : <span class="text-success">sudah</span>
          @endif    

        </div>
        
        <div class="col-3 py-4 text-center">

          @if ($khs[$i-1] == null)
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
          @if ($i == 1 || $khs[$i-2] != null)
            @if ($khs[$i-1] == null)
            <div class="modalKHSButton" type="button" data-bs-toggle="modal" data-bs-target="#modalKHS" data-smt="{{ $i }}">
            @else
            <div class="modalKHSButton" type="button" data-bs-toggle="modal" data-bs-target="#modalKHS" 
            data-smt="{{ $i }}" data-scan-khs="{{ $khs[$i-1]->scan_khs }}" data-sks="{{ $khs[$i-1]->sks }}" data-ips="{{ $khs[$i-1]->ips }}">
            @endif
          @else
            <div class="modalAlert" type="button" data-bs-toggle="modal" data-bs-target="#modalAlert">
          @endif

            <h4 class="m-0" >
              <i class="bi bi-pencil-square"></i>
            </h4>
          </div>
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
