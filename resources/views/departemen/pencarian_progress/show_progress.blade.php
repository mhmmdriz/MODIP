@extends('templates.main')

@section('container')
<div class="row d-flex justify-content-center mt-3 mb-2">
  <div class="col-md-auto">
    <h3>Progress Perkembangan Studi Mahasiswa</h3>
    <hr>
  </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col my-3">
    <div class="card mb-3 bg-body-tertiary">
      <div class="row">
        <div class="col-md-auto m-4">
          <img src="/photo/private/profile_photo/default.jpg" alt="" style="border-radius:50%; width:120px">
        </div>
        <div class="col m-4">
          <div class="row">
            <div class="col profil-mhs">
              <p><span>Nama</span> : {{ $mahasiswa->nama }}</p>
              <p><span>NIM</span> : {{ $mahasiswa->nim }}</p>
              <p><span>Angkatan</span> : {{ $mahasiswa->angkatan }}</p>
              <p><span>Wali</span> : {{ $mahasiswa->dosenwali->nama }}</p>
            </div>            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row d-flex justify-content-center mb-2">
  <div class="col-md-auto">
    <h5>Semester</h5>
  </div>
</div>


<div class="row d-flex gx-4 gy-4 mb-5">
  @for ($i = 0; $i <= 13; $i++)
  <div class="col-md-2 col-sm-6">
    <div class="modalButton" type="button" data-bs-toggle="modal" data-bs-target="#modalMain">
      <div class="card bg-body-tertiary d-flex align-items-center text-center py-2">      
        <h5><b>{{ $i + 1 }}</b></h5>
      </div>
    </div>
  </div>
  @endfor
</div>


@include('departemen.pencarian_progress.modal_main')
@include('departemen.pencarian_progress.modal_irs')
@include('departemen.pencarian_progress.modal_khs')
@include('departemen.pencarian_progress.modal_pkl')
@include('departemen.pencarian_progress.modal_skripsi')
@endsection