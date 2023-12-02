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
          <div>Departemen ID : {{ auth()->user()->username }}</div>
          <div>Fakultas Sains dan Matematika</div>
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
          <canvas id="rekapStatus" width="300" height="300"></canvas>
        </div>
        <div class="col-4">
          <canvas id="rekapPKL" width="300" height="300"></canvas>
        </div>
        <div class="col-4">
          <canvas id="rekapSkripsi" width="300" height="300"></canvas>
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
    label.push(element.status);
    data.push(element.jumlah);
  });

  var data = {
    labels: label,
    datasets: [{
      data: data,
      backgroundColor: ["#4CAF50", "#2196F3", "#F44336", "#9C27B0", "#FF5722", "#607D8B", "#795548"]
    }]
  };

  var options = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display:false,
        position: 'bottom',
      },
      title: {
        display: true,
        text: 'Rekap Status Mahasiswa'
      }
    }
  };

  // Membuat instance Pie Chart
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
  });

  var ctx = document.getElementById("rekapPKL").getContext("2d");
  var rekapPKL = {!! json_encode($rekap_pkl) !!}
  console.log(rekapPKL);
  var label = ['Sudah PKL', 'Belum PKL'];
  var data = [rekapPKL.sudah, rekapPKL.belum];

  var data = {
    labels: label,
    datasets: [{
      data: data,
      backgroundColor: ["#4CAF50", "#2196F3"]
    }]
  };

  var options = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom',
      },
      title: {
        display: true,
        text: 'Rekap Status Mahasiswa'
      }
    }
  };

  // Membuat instance Pie Chart
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: options
  });
  
  var ctx = document.getElementById("rekapSkripsi").getContext("2d");
  var rekapSkripsi = {!! json_encode($rekap_skripsi) !!}
  console.log(rekapSkripsi);
  var label = ['Sudah Skripsi', 'Belum Skripsi'];
  var data = [rekapSkripsi.sudah, rekapSkripsi.belum];

  var data = {
    labels: label,
    datasets: [{
      data: data,
      backgroundColor: ["#4CAF50", "#2196F3"]
    }]
  };
  
  var options = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom',
      },
      title: {
        display: true,
        text: 'Rekap Status Mahasiswa'
      }
    }
  };

  // Membuat instance Pie Chart
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: options
  });
</script>
@endsection

