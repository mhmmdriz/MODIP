@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Validasi Progress Studi</li>
  </ol>
</nav>

<div class="row d-flex justify-content-center my-3">
  <div class="col-md-auto">
    <h5>Pilih Jenis Progress Studi</h5>
  </div>
</div>

<div class="row d-flex gx-4 gy-4 mb-2">
  <div class="col-md-3 col-sm-6">
    <a href="/validasiProgress/validasiIRS" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">  
        <h5><b>IRS Mahasiswa</b></h5>
        <i class="bi bi-book-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/validasiProgress/validasiKHS" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>KHS Mahasiswa</b></h5>
        <i class="bi bi-file-earmark-text-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/validasiProgress/validasiPKL" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>PKL Mahasiswa</b></h5>
        <i class="bi bi-person-workspace" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/validasiProgress/validasiSkripsi" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Skripsi Mahasiswa</b></h5>
        <i class="bi bi-journal-text" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
</div>
@endsection

