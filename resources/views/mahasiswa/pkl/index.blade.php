@extends('templates.main')

@section('container')

<div class="row justify-content-center mb-3">
  <div class="col-auto">
    <h4>Praktik Kerja Lapangan</h4>
  </div>
</div>

<div class="card bg-body-tertiary mb-3">
  <div class="row m-2">
    <div class="col-auto ms-auto">
      <h3 class="m-0" >
        <i class="bi bi-pencil-square"></i>
      </h3>
    </div>
  </div>
  <div class="row d-flex justify-content-center my-2 mx-2">
    <div class="col-4 border-end text-center py-3">
      <div class="row">
        <div class="col">
          <h5>Dosen Pembimbing</h5>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>-</h5>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>Tahun</h5>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <h5>-</h5>
        </div>
      </div>
    </div>

    <div class="col-4 text-center py-3 ">
      <div class="row">
        <div class="col">
          <h5>Status</h5>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-auto bg-body-secondary  ">
          <h5>Belum Ambil</h5>
        </div>
      </div>
    </div>
    <div class="col-4 border-start text-center">

    </div>
  </div>
</div>
@endsection