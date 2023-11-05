@extends('templates.main')

@section('container')
<div class="row d-flex justify-content-center my-3">
  <div class="col-auto">
    <h5>Data IRS Mahasiswa Perwalian</h5>
  </div>
</div>

<div class="card bg-body-tertiary mb-3">
  <div class="row my-3 mx-2">
    <div class="col-auto">
      <h5>Daftar Angkatan</h5>
    </div>
  </div>

  @foreach ($data_mhs as $angkatan => $jumlah_mhs)
  <a href="/irsPerwalian/{{ $angkatan }}" class="text-decoration-none" style="color:inherit;">
    <div class="row mx-3 mb-3">
      <div class="col bg-light-subtle rounded border">
        <div class="row">
          <div class="col-auto border-end py-4 text-center" >
            Angkatan {{ $angkatan }}
          </div>
          <div class="col-auto py-4 text-center ">
            Jumlah Mahasiswa: {{ $jumlah_mhs }}
          </div>
        </div>
      </div>
    </div>
  </a>
  @endforeach
  

</div>

@include('mahasiswa.irs.modal_edit_irs')
@include('mahasiswa.irs.modal_alert')
<script src="js/modal.js"></script>

@endsection
