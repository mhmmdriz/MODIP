@extends('templates.main')

@section('container')
  <div class="row d-flex justify-content-center mt-5 mb-2">
    <div class="col-md-auto">
      <h5>Akun Dosen Wali</h5>
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
      <a href="/exportAkunDosenWali" type="button" class="btn btn-primary btn-sm">
        Export List Akun
      </a>
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalImport">Import Akun</button>
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalGenerate">Generate Akun</button>
    </div>
  </div>

  <div class="row my-4">
    <div class="col">
      <div class="card bg-body-tertiary">
        <div id="tabelDSN">
          <table class="table table-stripped m-0">
            <tr>
              <th>No</th>
              <th>Nama Dosen</th>
              <th>NIP/Username</th>
              <th>No Telepon</th>
              <th>Email SSO</th>
              <th>Action</th>
            </tr>
  
            @php
              $i = 0;
            @endphp
          
            @foreach ($data_doswal as $doswal)
              {{-- @dd($doswal->user->password) --}}
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $doswal->nama }}</td>
                <td>{{ $doswal->nip }}</td>
                <td>{{ $doswal->no_telp}}</td>
                <td>{{ $doswal->email_sso}}</td>
                <td>
                  <a class="btn btn-warning btn-sm" href="/akunDosenWali/{{ $doswal->nip }}/reset">Reset Password</a>
                  <form action="/akunDosenWali/{{ $doswal->nip }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                      Hapus Akun
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </table>
        </div>

      </div>
    </div>
  </div>

@include('operator.akun_doswal.modal_generate_doswal')
@include('operator.akun_doswal.modal_import_excel')

@endsection