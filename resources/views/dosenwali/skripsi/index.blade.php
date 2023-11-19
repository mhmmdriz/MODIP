@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Skripsi Mahasiswa Perwalian</li>
  </ol>
</nav>

<div class="row d-flex justify-content-center my-3">
  <div class="col-auto">
    <h5>Data Skripsi Mahasiswa Perwalian</h5>
  </div>
</div>

<div class="card bg-body-tertiary mb-3">
  <div class="row my-3 mx-2">
    <div class="col-auto">
      <h5>Daftar Angkatan</h5>
    </div>
  </div>

  @foreach ($data_mhs as $angkatan => $jumlah_mhs)
  <a href="/skripsiPerwalian/{{ $angkatan }}" class="text-decoration-none" style="color:inherit;">
    <div class="row mx-3 mb-3">
      <div class="col bg-light-subtle rounded border">
        <div class="row">
          <div class="col-2 border-end py-4 text-center" >
            Angkatan {{ $angkatan }}
          </div>
          <div class="col-2 py-4 text-center ">
            Mahasiswa: {{ $jumlah_mhs }}
          </div>
          <div class="col-2 py-4 text-center ">
            @if (isset($rekap_skripsi[$angkatan]["sudah"]))
            Sudah Validasi: {{ $rekap_skripsi[$angkatan]["sudah"] }}
            @else
            Sudah Validasi: 0
            @endif
          </div>
          <div class="col-2 py-4 text-center ">
            @if (isset($rekap_skripsi[$angkatan]["belum"]))
            Belum Validasi: {{ $rekap_skripsi[$angkatan]["belum"] }}
            @else
            Belum Validasi: 0
            @endif
          </div>
          <div class="col-auto py-4 text-center ">
            @if (isset($rekap_skripsi[$angkatan]["belum_entry"]))
            Belum Entry Data: {{ $rekap_skripsi[$angkatan]["belum_entry"] }}
            @else
            Belum Entry Data: 0
            @endif
          </div>
        </div>
      </div>
    </div>
  </a>
  @endforeach

  

</div>

<script src="/js/modal.js"></script>

@endsection
