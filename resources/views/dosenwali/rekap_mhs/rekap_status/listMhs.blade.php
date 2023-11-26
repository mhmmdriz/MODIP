@extends('templates.main')

@section('container')

<div class="row d-flex justify-content-center my-2">
  <div class="col-md-auto">
    @if ($status != null)
    <h5>List Mahasiswa Perwalian Angkatan {{ $angkatan }} Status {{ $status }}</h5>
    @else
    <h5>List Mahasiswa Perwalian Angkatan {{ $angkatan }}</h5>
    @endif
  </div>
</div>

<div class="row my-3">
  <div class="col-md-4">
    <p>Filter Angkatan :</p>
    <select name="status" id="select_status" class="form-control" onchange="redirectToStatus(this.value)">
      <option value="" {{ $status ? '' : 'selected' }}>Semua Status</option>
      <option value="Aktif" {{ $status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
      <option value="Lulus" {{ $status == 'Lulus' ? 'selected' : '' }}>Lulus</option>
      <option value="Cuti" {{ $status == 'Cuti' ? 'selected' : '' }}>Cuti</option>
      <option value="Mangkir" {{ $status == 'Mangkir' ? 'selected' : '' }}>Mangkir</option>
      <option value="DO" {{ $status == 'DO' ? 'selected' : '' }}>DO</option>
      <option value="Undur Diri" {{ $status == 'Undur Diri' ? 'selected' : '' }}>Undur Diri</option>
      <option value="Meninggal Dunia" {{ $status == 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
    </select>
  </div>
</div>

<div class="card table-responsive px-1 printable" id="list-mhs-skripsi-print">
  <table class="table table-stripped m-0" id="tabel-rekap-skripsi">
    <tr>
      <th>No</th>
      <th>NIM</th>
      <th>Nama</th>
      <th>Angkatan</th>
      <th>Status</th>
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
        <td>{{ $mhs->status}}</td>
      </tr>
    @endforeach
  </table>
</div>
<div class="row">
  <div class="col-auto ms-auto">
    {{-- <button class="btn btn-primary btn-sm" id="btn-print-list">Cetak</button> --}}

    <form action="/printListMhsStatus" target="__blank" method="post">
      @csrf
      <input type="hidden" name="objects" value="{{ json_encode($data_mhs) }}">
      <input type="hidden" name="angkatan" value="{{ $angkatan }}">
      <input type="hidden" name="status" value="{{ $status }}">
      {{-- @dump(json_encode($data_mhs)) --}}
      <button class="btn btn-primary btn-sm mt-2" type="submit">Cetak</button>
    </form>
  

  </div>
</div>

<script>
  function redirectToStatus(status) {
    if (status) {
      window.location.href = "/showListMhsStatus/2019/" + status;
    } else {
      window.location.href = "/showListMhsStatus/2019";
    }
  }
</script>
@endsection
