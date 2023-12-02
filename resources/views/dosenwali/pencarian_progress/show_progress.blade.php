@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/pencarianProgressStudiPerwalian">Pencarian Progress Studi Mahasiswa Perwalian</a></li>
    <li class="breadcrumb-item active" aria-current="page">Progress Studi Mahasiswa Perwalian</li>
  </ol>
</nav>

<div class="row d-flex justify-content-center mt-3 mb-2">
  <div class="col-md-auto">
    <h3>Progress Perkembangan Studi Mahasiswa</h3>
    <hr>
  </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col my-3">
    <div class="card mb-3 bg-body-tertiary">
      <div class="row">
        <div class="col-md-auto m-4">
          @if ($mahasiswa->foto_profil == null)
            <img src="/showFile/private/profile_photo/default.jpg" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
          @else
            <img src="/showFile/{{ $mahasiswa->foto_profil }}" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
          @endif
        </div>
        <div class="col m-4">
          <div class="row">
            <div class="col profil-mhs">
              <p><span>Nama</span> : {{ $mahasiswa->nama }}</p>
              <p><span>NIM</span> : {{ $mahasiswa->nim }}</p>
              <p><span>Angkatan</span> : {{ $mahasiswa->angkatan }}</p>
              <p><span>Wali</span> : {{ $mahasiswa->dosenwali->nama }}</p>
            </div>            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-md-auto">
    <h5>Semester</h5>
  </div>
</div>

<div class="d-flex flex-row">
  <div class="mb-1 me-auto">
    <p class="text-secondary">
      *Semua data yang tampil disini sudah divalidasi
    </p>
  </div>
  <div class="mb-1">
    SKSk: {{ $SKSk }} | IPk: {{ number_format($IPk, 2) }}
  </div>
</div>


<div class="row d-flex gx-4 gy-4 mb-5">
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


@include('dosenwali.pencarian_progress.modal_main')
@include('dosenwali.pencarian_progress.modal_irs')
@include('dosenwali.pencarian_progress.modal_khs')
@include('dosenwali.pencarian_progress.modal_pkl')
@include('dosenwali.pencarian_progress.modal_skripsi')
<script src="/js/progress.js"></script>
@endsection