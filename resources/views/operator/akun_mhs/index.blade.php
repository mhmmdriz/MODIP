@extends('templates.main')

@section('container')
  <div class="row d-flex justify-content-center my-5">
    <div class="col-md-auto">
      <h5>Akun Mahasiswa</h5>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <input type="text" class="form-control" id="search-akun-mhs" placeholder="Cari Akun">
    </div>
    <div class="col-md-auto ms-auto">
      <button type="button" class="btn btn-primary btn-sm">Export List Akun</button>
      <button type="button" class="btn btn-primary btn-sm">Generate Akun</button>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col">
      <div class="card bg-body-tertiary">
        <table class="table table-stripped m-0">
          <tr>
            <th>No</th>
            <th>Nama Mahasiswa</th>
            <th>NIM/Username</th>
            <th>Password</th>
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
              {{-- <td></td> --}}
              <td>{{ $mhs->user->password }}</td>
              <td>
                <a class="btn btn-primary btn-sm" href="/buku/{{ $mhs->isbn }}">Detail</a>
                <a class="btn btn-warning btn-sm" href="/buku/{{ $mhs->isbn }}/edit">Edit</a>
                <form action="/buku/{{ $mhs->isbn }}" method="post" class="d-inline">
                  @method('delete')
                  @csrf
                  <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </table>

      </div>
    </div>
  </div>


@endsection