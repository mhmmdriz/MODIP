@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/validasiProgress">Validasi Progress Studi</a></li>
    <li class="breadcrumb-item active" aria-current="page">Validasi IRS</li>
  </ol>
</nav>

<div class="row d-flex justify-content-center my-3">
  <div class="col-auto">
    <h5>Data IRS Mahasiswa</h5>
  </div>
</div>

<div class="card bg-body-tertiary mb-3">
  <div class="row my-3 mx-2">
    <div class="col-auto">
      <h5>Daftar Angkatan</h5>
    </div>
  </div>

  @foreach ($data_mhs as $angkatan => $jumlah_mhs)
  <a href="/validasiProgress/validasiIRS/{{ $angkatan }}" class="text-decoration-none" style="color:inherit;">
    <div class="row mx-3 mb-3">
      <div class="col bg-light-subtle rounded border">
        <div class="row">
          <div class="col-2 border-end py-4 text-center">
            <h6 class="m-0 p-0">
              <b>Angkatan {{ $angkatan }}</b>
            </h6>
          </div>
          <div class="col-10 text-center py-4 d-flex gap-2 flex-wrap">
            <div>
              <h5 class="m-0 p-0">
                <span class="badge text-bg-secondary">
                  Mahasiswa: {{ $jumlah_mhs }}
                </span>
              </h5>
            </div>
            <div>
              @if (isset($rekap_irs[$angkatan]["sudah"]))
              <h5 class="m-0 p-0">
                <span class="badge text-bg-success">
                  Sudah Validasi: {{ $rekap_irs[$angkatan]["sudah"] }}
                </span>
              </h5>
              @else
              <h5 class="m-0 p-0">
                <span class="badge text-bg-success">
                  Sudah Validasi: 0
                </span>
              </h5>
              @endif
            </div>
            <div>
              @if (isset($rekap_irs[$angkatan]["belum"]))
              <h5 class="m-0 p-0">
                <span class="badge text-bg-warning">
                  Belum Validasi: {{ $rekap_irs[$angkatan]["belum"] }}
                </span>
              </h5>
              @else
              <h5 class="m-0 p-0">
                <span class="badge text-bg-warning">
                  Belum Validasi: 0
                </span>
              </h5>
              @endif
            </div>
            <div>
              @if (isset($rekap_irs[$angkatan]["belum_entry"]))
              <h5 class="m-0 p-0">
                <span class="badge text-bg-danger">
                  Belum Entry Data: {{ $rekap_irs[$angkatan]["belum_entry"] }}
                </span>
              </h5>
              @else
              <h5 class="m-0 p-0">
                <span class="badge text-bg-danger">
                  Belum Entry Data: 0
                </span>
              </h5>
              @endif
            </div>

          </div>
        </div>
      </div>
    </div>
  </a>
  @endforeach
  

</div>

<script src="js/modal.js"></script>

@endsection
