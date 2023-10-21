@extends('templates.main')

@section('container')
<div class="row d-flex justify-content-center">
  <div class="col my-3">
    <div class="card mb-3 bg-body-tertiary">
      <div class="row">
        <div class="col-md-auto m-4">
          <img src="{{ asset("storage/profile_photo/default.jpg") }}" alt="" style="border-radius:50%; width:120px">
        </div>
        <div class="col m-4">
          <div class="row">
            <div class="col">
              <h5><b>Operator Departemen Informatika</b></h5>
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

<div class="row d-flex gx-5 gy-2">
  <div class="col-md-4">
    <a href="/akunMHS" style="text-decoration: none">
      <div class="card mb-3 bg-body-tertiary">
        <div class="row d-flex justify-content-center mt-2">
          <div class="col-md-auto">
            <h5><b>Akun Mahasiswa</b></h5>
          </div>
        </div>
        <div class="row d-flex justify-content-center mb-2" style="margin-top:-10px">
          <div class="col-md-auto">
            <i class="bi bi-mortarboard-fill" style="font-size:70px;"></i>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-4">
    <a href="" style="text-decoration: none">
      <div class="card mb-3 bg-body-tertiary">
        <div class="row d-flex justify-content-center mt-2">
          <div class="col-md-auto">
            <h5><b>Akun Dosen Wali</b></h5>
          </div>
        </div>
        <div class="row d-flex justify-content-center mb-2" style="margin-top:-10px">
          <div class="col-md-auto">
            <i class="bi bi-suitcase-lg-fill" style="font-size:70px;"></i>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-4">
    <a href="" style="text-decoration: none">
      <div class="card mb-3 bg-body-tertiary">
        <div class="row d-flex justify-content-center mt-2">
          <div class="col-md-auto">
            <h5><b>Akun Departemen</b></h5>
          </div>
        </div>
        <div class="row d-flex justify-content-center mb-2" style="margin-top:-10px">
          <div class="col-md-auto">
            <i class="bi bi-building-fill" style="font-size:70px;"></i>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-4">
    <a href="" style="text-decoration: none">
      <div class="card mb-3 bg-body-tertiary">
        <div class="row d-flex justify-content-center mt-2">
          <div class="col-md-auto">
            <h5><b>Kunci Pengisian Data</b></h5>
          </div>
        </div>
        <div class="row d-flex justify-content-center mb-2" style="margin-top:-10px">
          <div class="col-md-auto">
            <i class="bi bi-lock-fill" style="font-size:70px;"></i>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-4">
    <a href="" style="text-decoration: none">
      <div class="card mb-3 bg-body-tertiary">
        <div class="row d-flex justify-content-center mt-2">
          <div class="col-md-auto">
            <h5><b>Kirim Notifikasi</b></h5>
          </div>
        </div>
        <div class="row d-flex justify-content-center mb-2" style="margin-top:-10px">
          <div class="col-md-auto">
            <i class="bi bi-bell-fill" style="font-size:70px;"></i>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>
@endsection

