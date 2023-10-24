@extends('templates.main')

@section('container')

{{-- <div class="row d-flex justify-content-center"> --}}
  <div class="card p-0 mb-3">
    <div class="card-header">Edit Profile</div>
    <div class="card-body">
      <form action="/profile/edit/{{ auth()->user()->mahasiswa->nim }}" method="POST" class="needs-validation">
        @csrf
        @method('put')
        <div class="mb-3">
          <label for="no_telp" class="form-label">No Telp</label>
          <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp', auth()->user()->mahasiswa->no_telp) }}">
          @error('no_telp')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="email_sso" class="form-label">Email SSO</label>
          <input type="email" class="form-control @error('email_sso') is-invalid @enderror" id="email_sso" name="email_sso" value="{{ old('email_sso', auth()->user()->mahasiswa->email_sso) }}">
          @error('email_sso')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="email_pribadi" class="form-label">Email Pribadi</label>
          <input type="text" class="form-control @error('email_pribadi') is-invalid @enderror" id="email_pribadi" name="email_pribadi" value="{{ old('email_pribadi', auth()->user()->mahasiswa->email_pribadi) }}">
          @error('email_pribadi')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', auth()->user()->mahasiswa->alamat) }}">
          @error('alamat')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
          <input type="text" class="form-control @error('kabupaten_kota') is-invalid @enderror" id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota', auth()->user()->mahasiswa->kabupaten_kota) }}">
          @error('kabupaten_kota')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="provinsi" class="form-label">Provinsi</label>
          <input type="text" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" value="{{ old('provinsi', auth()->user()->mahasiswa->provinsi) }}">
          @error('provinsi')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary me-2">Submit</button>
        <a href="/profile" class="btn btn-danger">Cancel</a>
      </form>
    </div>
  </div>
{{-- </div> --}}

@endsection