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
          @if (auth()->user()->departemen->foto_profil == null)
            <img src="/showFile/private/profile_photo/default.jpg" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
          @else
            <img src="/showFile/{{ auth()->user()->departemen->foto_profil }}" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;">
          @endif
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

<div class="row d-flex justify-content-center">
  <div class="col mb-2">
    <div class="card mb-3 bg-body-tertiary">
      <div class="row my-2">
        <div class="col-12 col-md-4">
          <canvas id="rekapStatus" width="200" height="200"></canvas>
        </div>
        <div class="col-4">
          <canvas id="rekapPKL" width="200" height="200"></canvas>
        </div>
        <div class="col-4">
          <canvas id="rekapSkripsi" width="200" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row d-flex gx-4 gy-4 mb-2">
  <div class="col-md-3 col-sm-6">
    <a href="/pencarianProgressStudi" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-1 h-100">  
        <p><b>Pencarian Progress Studi Mahasiswa</b></p>
        <i class="bi bi-search" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/rekapPKL" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-1 h-100">      
        <p><b>Rekap PKL Mahasiswa</b></p>
        <i class="bi bi-person-workspace" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/rekapSkripsi" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-1 h-100">      
        <p><b>Rekap Skripsi Mahasiswa</b></p>
        <i class="bi bi-journal-text" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/rekapStatus" style="text-decoration: none">
      <div class="card bg-body-tertiary justify-content-center d-flex align-items-center text-center py-1 h-100">      
        <p><b>Rekap Status Mahasiswa</b></p>
        <i class="bi bi-person-badge" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
</div>


<script>
  // Mendapatkan elemen canvas
  var ctx = document.getElementById("rekapStatus").getContext("2d");
  var rekapStatus = {!! $rekap_status !!}
  
  var label = [];
  var data = [];
  rekapStatus.forEach(element => {
    
  });

  // Data untuk Pie Chart
  var data = {
    labels: ["Label 1", "Label 2", "Label 3", "Label 3", "Label 3", "Label 3"],
    datasets: [{
      data: [30, 50, 20],
      backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"]
    }]
  };

    // Konfigurasi untuk Pie Chart
    var options = {
      responsive: true,
      maintainAspectRatio: false
    };

    

    // Membuat instance Pie Chart
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: data,
      options: options
    });
  
</script>
@endsection

