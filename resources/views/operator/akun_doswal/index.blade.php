@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Akun Dosen Wali</li>
  </ol>

</nav>
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
      <input type="text" class="form-control" id="search-akun-mhs" onkeyup="updateDoswalTable(this.value)" placeholder="Cari Akun">
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
        <div id="tabelDoswal" class="table-responsive">
          {{-- load update_doswal.blade.php by updateDoswalTable("") --}}
        </div>

      </div>
    </div>
  </div>

@include('operator.akun_doswal.modal_generate_doswal')
@include('operator.akun_doswal.modal_import_excel')
@include('operator.akun_doswal.modal_reset_password')
@include('operator.akun_doswal.modal_delete_akun')

<script src="/js/ajax.js"></script>
<script>
  updateDoswalTable("")
</script>

@endsection