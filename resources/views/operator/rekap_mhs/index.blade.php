@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Rekap Mahasiswa</li>
  </ol>
</nav>

<div class="row d-flex gx-4 gy-4 mb-2">
  <div class="col-md-4 col-sm-6">
    <a href="/rekapMhs/rekapPKL" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Rekap PKL Mahasiswa</b></h5>
        <i class="bi bi-person-workspace" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-4 col-sm-6">
    <a href="/rekapMhs/rekapSkripsi" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <h5><b>Rekap Skripsi Mahasiswa</b></h5>
        <i class="bi bi-journal-text" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-4 col-sm-6">
    <a href="/rekapMhs/rekapStatus" style="text-decoration: none">
      <div class="card bg-body-tertiary justify-content-center d-flex align-items-center text-center py-2 h-100">      
        <h5><b>Rekap Status Mahasiswa</b></h5>
        <i class="bi bi-person-badge" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
</div>
@endsection

