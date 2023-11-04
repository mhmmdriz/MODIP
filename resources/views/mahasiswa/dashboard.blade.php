@extends('templates.main')

@section('container')
<div class="row d-flex justify-content-center">
  <div class="col my-3">
    <div class="card mb-3 bg-body-tertiary">
      <a href="/profile" style="text-decoration: none; color: inherit;" class="bi bi-pencil-square position-absolute end-0 m-2"></a>
      <div class="row">
        <div class="col-md-auto m-4">
          @if (auth()->user()->mahasiswa->foto_profil == null)
            <img src="/photo/private/profile_photo/default.jpg" alt="" style="border-radius:50%; width:120px">
          @else
            <img src="/photo/private/profile_photo/{{ auth()->user()->mahasiswa->foto_profil }}" alt="" style="border-radius:50%; width:120px">
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
          <div>IPK</div>
          <div>3.99</div>
        </div>
        <div class="d-flex col-6 flex-column justify-content-center align-items-center">
          <div>SKSK</div>
          <div>100</div>
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
  <div class="col-md-3 col-sm-6">
    <a href="/irs" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>IRS</b></h5>
        <i class="bi bi-book-fill" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/khs" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>KHS</b></h5>
        <i class="bi bi-file-earmark-text-fill" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/pkl" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>PKL</b></h5>
        <i class="bi bi-person-workspace" style="font-size:70px;"></i>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6">
    <a href="/skripsi" style="text-decoration: none">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>Skripsi</b></h5>
        <i class="bi bi-journal-text" style="font-size:70px;"></i>
      </div>
    </a>
  </div>

</div>
@endsection

