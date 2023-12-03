<link rel="stylesheet" href="/css/style.css">

<div class="row text-center">
  <h4>Daftar {{ $status }} Lulus PKL Mahasiswa Informatika Angkatan {{ $angkatan }}</h4>
</div>

<div class="card table-responsive px-1 printable" id="list-mhs-pkl-print"> 
<table class="table table-stripped m-0" id="tabel-rekap-pkl">
  <tr>
    <th>No</th>
    <th>NIM</th>
    <th>Nama</th>
    <th>Angkatan</th>
    <th>Nilai</th>
  </tr>

  @php
    $i = 0;
  @endphp

  @foreach ($data_mhs as $mhs)
    <tr>
      <td>{{ ++$i }}</td>
      <td>{{ $mhs->nim }}</td>
      <td>{{ $mhs->nama }}</td>
      <td>{{ $mhs->angkatan}}</td>
      <td>{{ $mhs->nilai}}</td>
    </tr>
  @endforeach
</table>
</div>
<div class="row">
  <div class="col-auto ms-auto">
    {{-- <button class="btn btn-primary btn-sm" id="btn-print-list">Cetak</button> --}}

    <form id="printForm" action="/printListMhsPKL" target="__blank" method="post">
      @csrf
      <input type="hidden" name="objects" value="{{ json_encode($data_mhs) }}">
      <input type="hidden" name="angkatan" value="{{ $angkatan }}">
      <input type="hidden" name="status" value="{{ $status }}">
      {{-- @dump(json_encode($data_mhs)) --}}
      <button class="btn btn-primary btn-sm mt-2" type="submit" onclick="printRekap()">Cetak</button>
    </form>
  

  </div>
</div>



