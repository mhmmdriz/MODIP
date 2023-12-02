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
        <div class="col-md-auto m-4 d-flex align-items-center">
          @if (auth()->user()->operator->foto_profil == null)
            <img src="/showFile/private/profile_photo/default.jpg" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
          @else
            <img src="/showFile/{{ auth()->user()->operator->foto_profil }}" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
          @endif
        </div>
        <div class="col m-4">
          <div class="row">
            <div class="col">
              <h5><b>Operator Departemen Informatika</b></h5>
            </div>
          </div>
          <hr>
          <div>Nama Operator : {{ auth()->user()->operator->nama }}</div>
          <div>Fakultas Sains dan Matematika</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row d-flex gx-4 gy-4 mb-2">
  <div class="col-md-3 col-sm-6">
    <a href="/akunMHS" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Akun Mahasiswa</b></h5>
        <i class="bi bi-mortarboard-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/akunDosenWali" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Akun Dosen Wali</b></h5>
        <i class="bi bi-suitcase-lg-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/akunDepartemen" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Akun Departemen</b></h5>
        <i class="bi bi-building-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/pencarianProgressStudi" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">  
        <h5><b>Pencarian Progress Studi Mahasiswa</b></h5>
        <i class="bi bi-search" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/validasiProgress" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Validasi Progress Studi MHS</b></h5>
        <i class="bi bi-file-earmark-check-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/rekapMhs" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Rekap Mahasiswa</b></h5>
        <i class="bi bi-file-earmark-ruled" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/entryProgress" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Entry Progress Studi MHS</b></h5>
        <i class="bi bi-file-earmark-arrow-up-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  {{-- <div class="col-md-3 col-sm-6">
    <a href="" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Kunci Pengisian Data</b></h5>
        <i class="bi bi-lock-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Kirim Notifikasi</b></h5>
        <i class="bi bi-bell-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div> --}}
  
</div>
@endsection

