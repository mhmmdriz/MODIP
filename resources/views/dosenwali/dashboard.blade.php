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
          <div>NIP : {{ auth()->user()->dosen_wali->nip }}</div>
          <div>Fakultas Sains dan Matematika</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col mb-2">
    <div class="card mb-3 bg-body-tertiary">
      <div class="row my-2 mx-2">
        <div class="col-12 col-md-4">
          <canvas id="rekapStatus" class="chartJS" width="300" height="300"></canvas>
        </div>
        <div class="col-4">
          <canvas id="rekapPKL" class="chartJS" width="300" height="300"></canvas>
        </div>
        <div class="col-4">
          <canvas id="rekapSkripsi" class="chartJS" width="300" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row d-flex gx-4 gy-4 mb-2">
  <div class="col-md-3 col-sm-6">
    <a href="/pencarianProgressStudiPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">  
        <p><b>Pencarian Progress Studi Mahasiswa Perwalian</b></p>
        <i class="bi bi-search" style="font-size:40px;"></i>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-sm-6">
    <a href="/irsPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">  
        <p><b>IRS Mahasiswa Perwalian</b></p>
        <i class="bi bi-book-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/khsPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <p><b>KHS Mahasiswa Perwalian</b></p>
        <i class="bi bi-file-earmark-text-fill" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/pklPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <p><b>PKL Mahasiswa Perwalian</b></p>
        <i class="bi bi-person-workspace" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/skripsiPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <p><b>Skripsi Mahasiswa Perwalian</b></p>
        <i class="bi bi-journal-text" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/rekapMhsPerwalian" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex justify-content-center align-items-center text-center py-2 h-100">      
        <p><b>Rekap Mahasiswa Perwalian</b></p>
        <i class="bi bi-file-earmark-ruled" style="font-size:40px;"></i>
      </div>
    </a>
  </div>
</div>

<script>
  Chart.defaults.color = '#808080';
  Chart.defaults.font.size = 14;
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

