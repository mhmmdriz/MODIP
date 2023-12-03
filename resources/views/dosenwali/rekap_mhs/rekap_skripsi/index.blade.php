@extends('templates.main')

@section('container')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="/rekapMhsPerwalian">Rekap Mahasiswa Perwalian</a></li>
    <li class="breadcrumb-item active" aria-current="page">Rekap Skripsi Mahasiswa</li>
  </ol>
</nav>

<div class="row text-center mb-3">
  <h4>Rekap Progress Skripsi Mahasiswa Perwalian Informatika</h4>
</div>

<div class="card bg-body-tertiary table-responsive" id="rekap-skripsi-main">
  <div class="row d-flex justify-content-center m-0">
    <div class="col-auto">
      <h5>Angkatan</h5>
    </div>
  </div>
  
  <table class="table-bordered text-center rounded">
    <tr>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      <td colspan="2">{{ $i }}</td>
    @endfor
    </tr>

    <tr>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_skripsi[$i]))
      <td class="point rekap-skripsi" data-angkatan="{{ $i }}" data-status="Sudah">Sudah</td>
      <td class="point rekap-skripsi" data-angkatan="{{ $i }}" data-status="Belum">Belum</td>
      @else
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Sudah">Sudah</td>
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Belum">Belum</td>
      @endif
    @endfor
    </tr>
    
    <tr>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_skripsi[$i]))
      <td class="point rekap-skripsi" data-angkatan="{{ $i }}" data-status="Sudah">{{ $rekap_skripsi[$i]["sudah_skripsi"] }}</td>
      <td class="point rekap-skripsi" data-angkatan="{{ $i }}" data-status="Belum">{{ $rekap_skripsi[$i]["belum_skripsi"] }}</td>
      @else
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Sudah">0</td>
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Belum">0</td>  
      @endif
    @endfor
    </tr>
  </table>
</div>

<div class="row justify-content-between">
  <div class="col-auto">
    <p class="text-secondary">*Tekan kolom tabel untuk menampilkan daftar list mahasiswa</p>
  </div>
  <div class="col-auto">
    {{-- <button class="btn btn-primary btn-sm" id="btn-print-rekap">Cetak</button> --}}
    <form id="printForm" action="/printRekapSkripsi" target="__blank" method="post">
      @csrf
      <input type="hidden" name="rekap_skripsi" value="{{ json_encode($rekap_skripsi) }}">
      <input type="hidden" name="current_year" value="{{ $current_year }}">
      <button class="btn btn-primary btn-sm mt-2" type="submit" onclick="printRekap()">Cetak</button>
    </form>
  </div>
</div>

<div class="row mt-4 mb-3">
  <div class="col list-mhs-skripsi">
  </div>
</div>

<script src="/js/rekap.js"></script>
@endsection
