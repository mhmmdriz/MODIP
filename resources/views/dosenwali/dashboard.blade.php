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

<div class="row d-flex gx-5 gy-2">
  <div class="col-md-4">
    <a href="/irsPerwalian" style="text-decoration: none">
      <div class="card mb-3 bg-body-tertiary">
        <div class="row d-flex justify-content-center mt-2">
          <div class="col-md-auto">
            <h5><b>IRS Mahasiswa Perwalian</b></h5>
          </div>
        </div>
        <div class="row d-flex justify-content-center mb-2" style="margin-top:-10px">
          <div class="col-md-auto">
            <i class="bi bi-book-fill" style="font-size:70px;"></i>
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
            <h5><b>KHS Mahasiswa Perwalian</b></h5>
          </div>
        </div>
        <div class="row d-flex justify-content-center mb-2" style="margin-top:-10px">
          <div class="col-md-auto">
            <i class="bi bi-file-earmark-text-fill" style="font-size:70px;"></i>
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
            <h5><b>PKL Mahasiswa Perwalian</b></h5>
          </div>
        </div>
        <div class="row d-flex justify-content-center mb-2" style="margin-top:-10px">
          <div class="col-md-auto">
            <i class="bi bi-person-workspace" style="font-size:70px;"></i>
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
            <h5><b>Skripsi Mahasiswa Perwalian</b></h5>
          </div>
        </div>
        <div class="row d-flex justify-content-center mb-2" style="margin-top:-10px">
          <div class="col-md-auto">
            <i class="bi bi-journal-text" style="font-size:70px;"></i>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>
@endsection

