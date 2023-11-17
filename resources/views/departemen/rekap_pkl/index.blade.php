@extends('templates.main')

@section('container')
<div class="row text-center mb-3">
  <h4>Rekap Progress PKL Mahasiswa Informatika</h4>
</div>

<div class="card bg-body-tertiary table-responsive" id="rekap-pkl-main">
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
      @if (isset($rekap_pkl[$i]))
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Sudah">Sudah</td>
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Belum">Belum</td>
      @else
      <td>Sudah</td>
      <td>Belum</td>
      @endif
    @endfor
    </tr>
    
    <tr>
    @for ($i = $current_year - 6; $i <= $current_year; $i++)
      @if (isset($rekap_pkl[$i]))
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Sudah">{{ $rekap_pkl[$i]["sudah_pkl"] }}</td>
      <td class="point rekap-pkl" data-angkatan="{{ $i }}" data-status="Belum">{{ $rekap_pkl[$i]["belum_pkl"] }}</td>
      @else
      <td>~</td>
      <td>~</td>  
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
    <form action="/printRekapPKL" target="blank" method="post">
      @csrf
      <input type="hidden" name="rekap_pkl" value="{{ json_encode($rekap_pkl) }}">
      <input type="hidden" name="current_year" value="{{ $current_year }}">
      <button class="btn btn-primary btn-sm mt-2" type="submit">Cetak</button>
    </form>
  </div>
</div>

<div class="row mt-4 mb-3">
  <div class="col list-mhs-pkl">
  </div>
</div>

<script src="/js/rekap.js"></script>
@endsection
