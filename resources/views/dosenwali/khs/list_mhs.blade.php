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
    <div id="tabelMHS" class="card table-responsive px-1">
      <table class="table m-0">
        <tr>
          <th>No</th>
          <th>Nama Mahasiswa</th>
          <th>NIM/Username</th>
          <th>Status</th>
          <th>SKSk</th>
          <th>IPk</th>
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
            @if (isset($data_khs[$mhs->nim]))
              <td>{{ $data_khs[$mhs->nim]['sksk'] }}</td>
              <td>{{ $data_khs[$mhs->nim]['ipk'] }}</td>
            @else
              <td>~</td>
              <td>~</td>
            @endif
            <td>
              <a class="btn btn-primary btn-sm" href="/khs/Perwalian/{{ $mhs->nim }}">Detail KHS</a>
            </td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>

@endsection