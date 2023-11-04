@extends('templates.main')

@section('container')
  <div class="row d-flex justify-content-center mt-5 mb-2">
    <div class="col-md-auto">
      <h5>Akun Mahasiswa</h5>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <input type="text" class="form-control" id="search-akun-mhs" onkeyup="updateMhsTable(this.value)" placeholder="Cari Akun">
    </div>
  </div>

  <div class="row my-4">
    <div class="col">
      <div class="card bg-body-tertiary">
        <div id="tabelMHS">
          <table class="table table-stripped m-0">
            <tr>
              <th>No</th>
              <th>Nama Mahasiswa</th>
              <th>NIM/Username</th>
              <th>Status</th>
              <th>SKSk</th>
              <th>Action</th>
            </tr>
  
            @php
              $i = 0;
            @endphp
          
            @foreach ($data_mhs as $mhs)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $mhs->nama }}</td>
                <td>{{ $mhs->nim }}</td>
                <td>{{ $mhs->status}}</td>
                <td>{{ $mhs->sksk}}</td>
                <td>
                  <a class="btn btn-primary btn-sm" href="/akunMHS/{{ $mhs->nim }}/reset">Detail IRS</a>
                </td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection