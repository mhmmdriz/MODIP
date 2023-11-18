@extends('templates.main')

@section('container')

{{-- <div class="row d-flex justify-content-center"> --}}
  <div class="card p-0 mb-3">
    <div class="card-header">Edit Profile</div>
    <div class="card-body">
      <form action="/profile/edit" method="POST" class="needs-validation" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
          <label for="no_telp" class="form-label">Ubah Foto Profil</label>

          @if (auth()->user()->mahasiswa->foto_profil == null)
            <img src="/showFile/private/profile_photo/default.jpg" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;" class="img-preview">
          @else
            <img src="/showFile/{{ auth()->user()->mahasiswa->foto_profil }}" alt="" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover; display: block;" class="img-preview">
          @endif
          
          <input class="form-control mt-3 @error('foto_profil') is-invalid @enderror" id="foto_profil" type="file" id="foto_profil" name="foto_profil" value="{{ old('foto_profil', auth()->user()->mahasiswa->foto_profil) }}" onchange="previewImage()">
          @error('foto_profil')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
        </div>
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

        <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
        <a href="/profile" class="btn btn-danger">Batal</a>
      </form>
    </div>
  </div>
{{-- </div> --}}

<script>
  let imgPreview = document.querySelector('.img-preview');

  function previewImage(){
    // tangkap inputan imagenya yang berasal dari input dengan id="image"
    let image = document.querySelector('#foto_profil');
    // ambil tag img kosong tadi
    let imgPreview = document.querySelector('.img-preview');

    // imgPreview.style.display = 'block';
    // imgPreview.style.width = '200px';

    // ambil data gambar
    let oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function(oFREvent){
      imgPreview.src = oFREvent.target.result;
    }
  }
</script>

@endsection