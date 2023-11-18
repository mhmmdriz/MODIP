@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Akun Mahasiswa</li>
  </ol>
</nav>

  <div class="row d-flex justify-content-center mt-5 mb-2">
    <div class="col-md-auto">
      <h5>Akun Mahasiswa</h5>
    </div>
  </div>

  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show col-md-auto" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="row">
    <div class="col-md-4">
      <input type="text" class="form-control" id="search-akun-mhs" onkeyup="updateMhsTable(this.value)" placeholder="Cari Akun">
    </div>
    <div class="col-md-auto ms-auto">
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalExport">Export List Akun</button>
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalImport">Import Akun</button>
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalGenerate">Generate Akun</button>
    </div>
  </div>

  <div class="row my-4">
    <div class="col">
      <div class="card bg-body-tertiary">
        <div id="tabelMHS">
          <table class="table table-stripped m-0" id="tabel-akun-mhs">
            <tr>
              <th>No</th>
              <th>Nama Mahasiswa</th>
              <th>NIM/Username</th>
              <th>Angkatan</th>
              <th>Dosen Wali</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
  
            @php
              $i = 0;
            @endphp
          
            @foreach ($data_mhs as $mhs)
              {{-- @dd($mhs->user->password) --}}
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $mhs->nama }}</td>
                <td>{{ $mhs->nim }}</td>
                <td>{{ $mhs->angkatan}}</td>
                <td>{{ $mhs->dosenwali->nama}}</td>
                <td>{{ $mhs->status}}</td>
                <td>
                  <a class="btn btn-warning btn-sm" href="/akunMHS/{{ $mhs->nim }}/reset">Reset Password</a>
                  <form action="/akunMHS/{{ $mhs->nim }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                      Hapus Akun
                    </button>
                  </form>
                  <div class="btn btn-sm btn-secondary btn-edit-data" data-bs-toggle="modal" data-bs-target="#modalEdit"
                  data-nama="{{ $mhs->nama }}" data-nim="{{ $mhs->nim }}" data-angkatan="{{ $mhs->angkatan }}" data-status="{{ $mhs->status }}" data-doswal="{{ $mhs->dosen_wali }}">
                    Edit Data
                  </div>
                </td>
              </tr>
            @endforeach
          </table>
        </div>

      </div>
    </div>
  </div>

  @include('operator.akun_mhs.modal_generate_mhs')
  @include('operator.akun_mhs.modal_import_excel')
  @include('operator.akun_mhs.modal_export_excel')
  @include('operator.akun_mhs.modal_edit_data')

  <script src="/js/akun.js"></script>

@endsection