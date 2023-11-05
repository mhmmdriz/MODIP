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
              @if ($khs[$i-1] == null)
                Jumlah SKS: ~
              @else
                Jumlah SKS: {{ $khs[$i-1]->sks }}
              @endif
            </div>

            <div class="col-auto text-center ">
              @if ($khs[$i-1] == null)
                IPs: ~
              @else
                IPs: {{ $khs[$i-1]->ips }}
              @endif
            </div>
            
            <div class="col-auto text-center">
              @if ($khs[$i-1] == null)
                Scan IRS : <span class="text-danger">belum</span>
              @else
                Scan IRS : 
                <a href="/scan-khs/{{ $khs[$i-1]->scan_khs }}" target="__blank" class="text-success text-decoration-none">
                  scanKHS{{ $i }}.pdf
                </a>
              @endif    
            </div>
            
            <div class="col-auto text-center">
              @if ($khs[$i-1] == null)
                Validasi : <span class="text-danger">belum</span>
              @else
                @if ($khs[$i-1]->validasi == 0)
                  Validasi : <span id="info_validasi{{ $i }}" class="text-danger">belum</span>
                @else
                  Validasi : <span id="info_validasi{{ $i }}" class="text-success">sudah</span>
                @endif
              @endif    
    
            </div>
          </div>
        </div>
        
        <div class="col-auto my-auto ms-auto">
          @if ($khs[$i-1] != null)
            @if ($khs[$i-1]->validasi == 0)
              <button type="button" class="btn btn-success btn-sm validasi" data-nim="{{ $nim }}" data-smt="{{ $i }}" data-progress="khs">Validasi</button>
            @else
              <button type="button" class="btn btn-danger btn-sm validasi" data-nim="{{ $nim }}" data-smt="{{ $i }}" data-progress="khs">Batalkan Validasi</button>
            @endif
          @endif
        </div>

        <div class="col-1 my-auto ms-auto me-2">
          @if ($khs[$i-1] == null)
          <div class="modalKHSButton" type="button" data-bs-toggle="modal" data-bs-target="#modalKHS" data-smt="{{ $i }}">
          @else
          <div class="modalKHSButton" type="button" data-bs-toggle="modal" data-bs-target="#modalKHS" 
          data-smt="{{ $i }}" data-scan-khs="{{ $khs[$i-1]->scan_khs }}" data-sks="{{ $khs[$i-1]->sks }}" data-ips="{{ $khs[$i-1]->ips }}">
          @endif
          <h4 class="m-0">
            <i class="bi bi-pencil-square"></i>
          </h4>
          </div>
        </div>
        
      </div>
    </div>
  </div>
      
  @endfor

</div>

<script src="/js/modal.js"></script>
@include('dosenwali.khs.modal_edit_khs')
<script src="/js/validasi.js"></script>

@endsection

