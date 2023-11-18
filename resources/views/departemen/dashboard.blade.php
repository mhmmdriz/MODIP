@extends('templates.main')

@section('container')
<div class="row d-flex justify-content-center">
  <div class="col my-3">
    <div class="card mb-3 bg-body-tertiary">
      <div class="row">
        <div class="col-md-auto m-4">
          <img src="/photo/private/profile_photo/default.jpg" alt="" style="border-radius:50%; width:120px">
        </div>
        <div class="col m-4">
          <div class="row">
            <div class="col">
              <h5><b>Departemen Informatika</b></h5>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col">
              Fakultas Sains dan Matematika
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row d-flex gx-4 gy-4 mb-2">
  <div class="col-md-4 col-sm-6">
    <a href="/pencarianProgressStudi" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">  
        <h5><b>Pencarian Progress Studi Mahasiswa</b></h5>
        <i class="bi bi-search" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-4 col-sm-6">
    <a href="/rekapPKL" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>Rekap PKL Mahasiswa</b></h5>
        <i class="bi bi-person-workspace" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-4 col-sm-6">
    <a href="/rekapSkripsi" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>Rekap Skripsi Mahasiswa</b></h5>
        <i class="bi bi-journal-text" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-4 col-sm-6">
    <a href="/rekapStatus" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>Rekap Status Mahasiswa</b></h5>
        <i class="bi bi-person-badge" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
</div>
@endsection

