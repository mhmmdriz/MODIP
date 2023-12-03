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
@if (session()->has('error'))
  <div class="alert alert-danger alert-dismissible fade show col-md-auto" role="alert">
    <h5>Gagal Melakukan Import Data</h5>
    <table class="w-100">
      <tr>
        <th style="width: 5%">Row</th>
        <th>Error</th>
      </tr>
      @foreach (session('error') as $error)
        <tr>
          <td>{{ $error->row() }}</td>
          <td>{{ $error->errors()[0] }}</td>
        </tr>
      @endforeach
    </table>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if (session()->has('errorDelete'))
  <div class="alert alert-danger alert-dismissible fade show col-md-auto" role="alert">
    {{ session('errorDelete') }}
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
      <div id="tabelMHS" class="table-responsive">
        {{-- load update_mhs.blade.php by updateMhsTable("") --}}
      </div>

    </div>
  </div>
</div>

@include('operator.akun_mhs.modal_generate_mhs')
@include('operator.akun_mhs.modal_import_excel')
@include('operator.akun_mhs.modal_export_excel')
@include('operator.akun_mhs.modal_edit_data')
@include('operator.akun_mhs.modal_reset_password')
@include('operator.akun_mhs.modal_delete_akun')

<script src="/js/ajax.js"></script>
<script>
  updateMhsTable("");
</script>

@endsection