@extends('templates.main')

@section('container')

<div class="card p-0 mb-3">
  <div class="card-header">Pengisian Data Pribadi</div>
  <div class="card-body">
    <form id="form" action="/firstLogin" method="POST" class="needs-validation">
      @csrf
      @method('put')
      <div class="mb-3">
        <label for="jalur_masuk" class="form-label">Jalur Masuk</label>
        <select class="form-control @error('jalur_masuk') is-invalid @enderror" id="jalur_masuk" name="jalur_masuk" aria-label="Default select example">
          <option value="" selected>Pilih Jalur Masuk</option>
          <option value="SNMPTN" {{ (old('jalur_masuk') == "SNMPTN")?"selected":"" }}>SNMPTN</option>
          <option value="SBMPTN" {{ (old('jalur_masuk') == "SBMPTN")?"selected":"" }}>SBMPTN</option>
          <option value="Mandiri" {{ (old('jalur_masuk') == "Mandiri")?"selected":"" }}>Mandiri</option>
          <option value="Lainnya" {{ (old('jalur_masuk') == "Lainnya")?"selected":"" }}>Lainnya</option>
        </select>
        @error('jalur_masuk')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="no_telp" class="form-label">No Telp</label>
        <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp') }}">
        @error('no_telp')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="email_sso" class="form-label">Email SSO</label>
        <input type="text" class="form-control @error('email_sso') is-invalid @enderror" id="email_sso" name="email_sso" value="{{ old('email_sso') }}">
        @error('email_sso')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>

      <div class="mb-3">
        <input type="hidden" name="provinsi_hidden" id="provinsi_hidden" value="{{ old('provinsi', auth()->user()->mahasiswa->provinsi) }}">

        <label for="provinsi" class="form-label">Provinsi</label>
        <select class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" aria-label="Default select example">
          <option value="" selected>Pilih Provinsi</option>
        </select>
        @error('provinsi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>
      <div class="mb-3">
        <input type="hidden" name="kabupaten_kota_hidden" id="kabupaten_kota_hidden" value="{{ old('kabupaten_kota', auth()->user()->mahasiswa->kabupaten_kota) }}">

        <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
        <select class="form-control @error('kabupaten_kota') is-invalid @enderror" id="kabupaten_kota" name="kabupaten_kota" aria-label="Default select example">
          <option value="" selected>Pilih Kabupaten/Kota</option>
        </select>
        @error('kabupaten_kota')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}">
        @error('alamat')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror" id="konfirmasi_password" name="konfirmasi_password">
        @error('konfirmasi_password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary me-2">Submit</button>
    </form>
  </div>
</div>

<script src="/js/api_wilayah.js"></script>

@endsection