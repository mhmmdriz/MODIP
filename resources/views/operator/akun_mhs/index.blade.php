@extends('templates.main')

@section('container')
  <div class="row d-flex justify-content-center my-5">
    <div class="col-md-auto">
      <h5>Akun Mahasiswa</h5>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <input type="text" class="form-control" id="search-akun-mhs" onkeyup="updateMhsTable(this.value)" placeholder="Cari Akun">
    </div>
    <div class="col-md-auto ms-auto">
      <button type="button" class="btn btn-primary btn-sm">Export List Akun</button>
      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalGenerate">Generate Akun</button>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col">
      <div class="card bg-body-tertiary">
        <div id="tabelMHS">
          <table class="table table-stripped m-0">
            <tr>
              <th>No</th>
              <th>Nama Mahasiswa</th>
              <th>NIM/Username</th>
              <th>Angkatan</th>
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
                <td>{{ $mhs->status}}</td>
                <td>
                  <a class="btn btn-warning btn-sm" href="/buku/{{ $mhs->isbn }}/edit">Reset Password</a>
                  <form action="/buku/{{ $mhs->isbn }}" method="post" class="d-inline">
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

@include('operator.akun_mhs.modal_generate_mhs')

@endsection