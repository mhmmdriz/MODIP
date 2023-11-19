@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
  </ol>
</nav>

<div class="row d-flex justify-content-center">
  <div class="col my-3">
    <div class="card mb-3 bg-body-tertiary">
      <a href="/profile" style="text-decoration: none; color: inherit;" class="bi bi-pencil-square position-absolute end-0 m-2"></a>
      <div class="row">
        <div class="col-md-auto m-4">
          @if (auth()->user()->dosen_wali->foto_profil == null)
            <img src="/showFile/private/profile_photo/default.jpg" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
          @else
            <img src="/showFile/{{ auth()->user()->dosen_wali->foto_profil }}" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
          @endif
        </div>
        <div class="col m-4">
          <div class="row">
            <div class="col">
              <h5><b>{{ auth()->user()->dosen_wali->nama }}</b></h5>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              NIP : {{ auth()->user()->dosen_wali->nip }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row d-flex gx-4 gy-4 mb-2">
  <div class="col-md-4 col-sm-6">
    <a href="/pencarianProgressStudiPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">  
        <h5><b>Pencarian Progress Studi Mahasiswa Perwalian</b></h5>
        <i class="bi bi-search" style="font-size:70px;"></i>
      </div>
    </a>
  </div>

  <div class="col-md-4 col-sm-6">
    <a href="/irsPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">  
        <h5><b>IRS Mahasiswa Perwalian</b></h5>
        <i class="bi bi-book-fill" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-4 col-sm-6">
    <a href="/khsPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>KHS Mahasiswa Perwalian</b></h5>
        <i class="bi bi-file-earmark-text-fill" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-4 col-sm-6">
    <a href="/pklPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>PKL Mahasiswa Perwalian</b></h5>
        <i class="bi bi-person-workspace" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-4 col-sm-6">
    <a href="/skripsiPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>Skripsi Mahasiswa Perwalian</b></h5>
        <i class="bi bi-journal-text" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
</div>
@endsection

