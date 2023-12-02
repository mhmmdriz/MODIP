@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb m-0">
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
  </ol>
</nav>

<div class="row d-flex justify-content-center">
  <div class="col my-2">
    <div class="card mb-3 bg-body-tertiary">
      <a href="/profile" style="text-decoration: none; color: inherit;" class="bi bi-pencil-square position-absolute end-0 m-2"></a>
      <div class="row">
        <div class="col-md-auto m-4">
          @if (auth()->user()->mahasiswa->foto_profil == null)
            <img src="/showFile/private/profile_photo/default.jpg" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
          @else
            <img src="/showFile/{{ auth()->user()->mahasiswa->foto_profil }}" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
          @endif
        </div>
        <div class="col m-4">
          <div class="row">
            <div class="col">
              <h5><b>{{ auth()->user()->mahasiswa->nama }}</b></h5>
            </div>
          </div>
          <hr>
          <div>NIM: {{ auth()->user()->mahasiswa->nim }}</div>
          <div>Angkatan: {{ auth()->user()->mahasiswa->angkatan }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row d-flex gx-4 gy-4 mb-2">
  <div class="col-md-4 col-sm-5">
    <div class="card bg-body-tertiary d-flex align-items-center py-2">      
      <div class="d-flex justify-content-center align-items-end" style="height: 2rem"><h5><b>Prestasi Akademik</b></h5></div>
      <div class="d-flex col-12" style="height: 5rem">
        <div class="d-flex col-6 flex-column justify-content-center align-items-center">
          <div>IPk</div>
          <div>{{ number_format($IPk,2) }}</div>
        </div>
        <div class="d-flex col-6 flex-column justify-content-center align-items-center">
          <div>SKSk</div>
          <div>{{ $SKSk }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8 col-sm-7">
      <div class="card bg-body-tertiary d-flex align-items-center py-2">      
        <div class="d-flex justify-content-center align-items-end" style="height: 2rem"><h5><b>Status Akademik</b></h5></div>
        <div class="d-flex col-12" style="height: 5rem">
          <div class="d-flex col-5 flex-column justify-content-center align-items-center">
            <div>{{ $thn_ajar }} {{ $smt }}</div>
          </div>
          <div class="d-flex col-2 flex-column justify-content-center align-items-center">
            <div>Semester {{ $semester }}</div>
          </div>
          <div class="d-flex col-5 flex-column justify-content-center align-items-center">
            <div>Status: {{ auth()->user()->mahasiswa->status }}</div>
          </div>
        </div>
      </div>
  </div>

  <div class="col-12">
    <div class="card bg-body-tertiary p-4">
      <div class="text-center mb-2"><h5><b>Progress Studi</b></h5></div>
      <div class="row">
        <div class="col mb-1">
          <p class="text-secondary">
            *Semua data yang tampil disini sudah divalidasi
          </p>
        </div>
      </div>
      <div class="row d-flex gx-4 gy-4">
        @for ($i = 0; $i <= 13; $i++)
        <div class="col-md-2 col-sm-6">
          @if ((!isset($arrIRS[$i]) || $arrIRS[$i]->validasi == 0) && (!isset($arrKHS[$i]) || $arrKHS[$i]->validasi == 0))
            <div class="modalButton">
          @else
            <div class="modalButton" type="button" data-bs-toggle="modal" data-bs-target="#modalMain" 
            data-smt="{{ $i + 1 }}"
            data-irs="{{ isset($arrIRS[$i]) ? $arrIRS[$i] : ''}}"
            data-khs="{{ isset($arrKHS[$i]) ? $arrKHS[$i] : ''}}"
            data-pkl="{{ $data_pkl }}"
            data-skripsi="{{ $data_skripsi }}">
          @endif
            @if((!isset($arrIRS[$i]) || $arrIRS[$i]->validasi == 0) && (!isset($arrKHS[$i]) || $arrKHS[$i]->validasi == 0))
              <div class="card bg-danger d-flex align-items-center text-center py-2">
            @elseif (isset($arrIRS[$i]) && isset($arrKHS[$i]) && $arrIRS[$i]->validasi == 1 && $arrKHS[$i]->validasi == 1)
              @if(!is_null($data_skripsi) && $data_skripsi->semester == $i + 1 && $data_skripsi->validasi == 1)
                <div class="card bg-success d-flex align-items-center text-center py-2">
              @elseif (!is_null($data_pkl) && $data_pkl->semester == $i + 1 && $data_pkl->validasi == 1)
                <div class="card bg-warning d-flex align-items-center text-center py-2">
              @else
                <div class="card bg-primary d-flex align-items-center text-center py-2">
              @endif
            @else
              <div class="card bg-info d-flex align-items-center text-center py-2">
            @endif
              <h5><b>{{ $i + 1 }}</b></h5>
            </div>
          </div>
        </div>
        @endfor
      </div>

      <div class="row mt-2">
        <div class="col">
          <p class="text-secondary m-0">
            *Keterangan warna 
          </p>
        </div>
      </div>

      <div class="row mt-1">
        <div class="col-auto ">
          <div class="card-container">
            <div class="card bg-danger d-flex align-items-center text-center h-20">
            </div>
            <p class="text-secondary">
              Belum diisikan IRS dan KHS 
            </p>
          </div>
        </div>
      </div>

      
      <div class="row">
        <div class="col-auto">
          <div class="card-container">
            <div class="card bg-info d-flex align-items-center text-center h-20">
            </div>
            <p class="text-secondary">
              Sudah diisikan IRS (Belum KHS)
            </p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-auto">
          <div class="card-container">
            <div class="card bg-primary d-flex align-items-center text-center h-20">
            </div>
            <p class="text-secondary">
              Sudah diisikan IRS dan KHS
            </p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-auto">
          <div class="card-container">
            <div class="card bg-warning d-flex align-items-center text-center h-20">
            </div>
            <p class="text-secondary">
              Sudah diisikan PKL, IRS dan KHS
            </p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-auto">
          <div class="card-container">
            <div class="card bg-success text-white d-flex align-items-center text-center h-20">
            </div>
            <p class="text-secondary">
              Sudah diisikan Skripsi, PKL, IRS dan Skripsi
            </p>
          </div>
        </div>
      </div>
      
    </div>
  </div>

  <div class="col-md-3 col-sm-6">
    <a href="/irs" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Entry IRS</b></h5>
        <i class="bi bi-book-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/khs" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Entry KHS</b></h5>
        <i class="bi bi-file-earmark-text-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/pkl" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Entry PKL</b></h5>
        <i class="bi bi-person-workspace" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/skripsi" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Entry Skripsi</b></h5>
        <i class="bi bi-journal-text" style="font-size:40px;"></i>
      </div>
    </a>
  </div>

</div>



@include('mahasiswa.progress_studi.modal_main')
@include('mahasiswa.progress_studi.modal_irs')
@include('mahasiswa.progress_studi.modal_khs')
@include('mahasiswa.progress_studi.modal_pkl')
@include('mahasiswa.progress_studi.modal_skripsi')
<script src="/js/progress.js"></script>
  
@endsection

