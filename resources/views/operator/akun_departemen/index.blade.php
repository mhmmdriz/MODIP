@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Akun Departemen</li>
  </ol>

</nav>
  <div class="row d-flex justify-content-center mt-5 mb-2">
    <div class="col-md-auto">
      <h5>Akun Departemen</h5>
    </div>
  </div>

  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show col-md-auto" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="row">
    <div class="col-md-auto ms-auto">
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalGenerate">Generate Akun</button>
    </div>
  </div>

  <div class="row my-4">
    <div class="col">
      <div class="card bg-body-tertiary">
        <div id="tabelDepartemen">
          <table class="table table-stripped m-0">
            <tr>
              <th>No</th>
              <th>Departemen ID</th>
              <th>No Telepon</th>
              <th>Email SSO</th>
              <th>Action</th>
            </tr>
  
            @php
              $i = 0;
            @endphp
          
            @foreach ($data_departemen as $departemen)
              {{-- @dd($doswal->user->password) --}}
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $departemen->departemen_id }}</td>
                <td>{{ $departemen->no_telp}}</td>
                <td>{{ $departemen->email_sso}}</td>
                <td>
                  <a class="btn btn-warning btn-sm" href="/akunDepartemen/{{ $departemen->departemen_id }}/reset">Reset Password</a>
                  <form action="/akunDepartemen/{{ $departemen->departemen_id }}" method="post" class="d-inline">
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

@include('operator.akun_departemen.modal_generate_departemen')

@endsection