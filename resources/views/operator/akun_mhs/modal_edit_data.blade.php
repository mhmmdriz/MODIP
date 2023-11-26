<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Akun Mahasiswa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="form-edit">
      <div class="modal-body">
          @csrf
          @method('put')
          <div class="mb-3">
            <label for="nama_edit" class="form-label">Nama</label>
            <input type="text" class="form-control @error('nama_edit') is-invalid @enderror" name="nama_edit" value="{{ old('nama_edit') }}" id="nama_edit">
            @error('nama_edit')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <input type="hidden" class="form-control" name="nim_edit" value="{{ old('nim_edit') }}" id="nim_edit">
          <div class="mb-3">
            
            <label for="angkatan_edit" class="form-label">Angkatan</label>
            <select class="form-control @error('angkatan_edit') is-invalid @enderror" id="angkatan_edit" name="angkatan_edit" aria-label="Default select example">
              <option value="" selected>Pilih Angkatan</option>
              @foreach ($semua_angkatan as $angkatan)
                <option value="{{ $angkatan }}" {{ (old('angkatan_edit') == $angkatan)?"selected":"" }}>{{ $angkatan }}</option>
              @endforeach
            </select>
            @error('angkatan_edit')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="status_edit" class="form-label">Status</label>
            <select class="form-control @error('status_edit') is-invalid @enderror" name="status_edit" aria-label="Default select example" id="status_edit">
              <option value="" selected>Pilih status_edit</option>
              <option value="Aktif" {{ (old('status_edit') == "Aktif")?"selected":"" }}>Aktif</option>
              <option value="Cuti" {{ (old('status_edit') == "Cuti")?"selected":"" }}>Cuti</option>
              <option value="Mangkir" {{ (old('status_edit') == "Mangkir")?"selected":"" }}>Mangkir</option>
              <option value="DO" {{ (old('status_edit') == "DO")?"selected":"" }}>DO</option>
              <option value="Undur Diri" {{ (old('status_edit') == "Undur Diri")?"selected":"" }}>Undur Diri</option>
              <option value="Lulus" {{ (old('status_edit') == "Lulus")?"selected":"" }}>Lulus</option>
              <option value="Meninggal Dunia" {{ (old('status_edit') == "Meninggal Dunia")?"selected":"" }}>Meninggal Dunia</option>
            </select>
            @error('status_edit')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3 d-none">
            <label for="semester_akhir" class="form-label">Semester Akhir</label>
            <select class="form-control @error('semester_akhir') is-invalid @enderror" name="semester_akhir" aria-label="Default select example" id="semester_akhir">
              <option selected></option>
              @for($i = 1; $i <= 14; $i++)
                <option value="{{ $i }}" {{ (old('semester_akhir') == $i)?"selected":"" }}>{{ $i }}</option>
              @endfor
            </select>
            @error('semester_akhir')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="dosen_wali_edit" class="form-label">Dosen Wali</label>

            <select class="form-control @error('dosen_wali_edit') is-invalid @enderror" name="dosen_wali_edit" aria-label="Default select example" id="doswal">
              <option value="0" selected>Pilih Dosen Wali</option>
              @foreach ($data_doswal as $doswal)
                <option value="{{ $doswal->nip }}" {{ (old('dosen_wali_edit') == $doswal->nip)?"selected":"" }}>{{ $doswal->nama }}</option>
              @endforeach
            </select>
            @error('dosen_wali_edit')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Data</button>
      </div>
      </form>
    </div>
  </div>
</div>

@if($errors->has('nama_edit') OR $errors->has('angkatan_edit') OR $errors->has('status_edit') OR $errors->has('dosen_wali_edit') OR $errors->has('semester_akhir'))
  <script>
    $(document).ready(function () {
      // $("#nim-edit").val("{{ old('nim_edit') }}");
      $('#modalEdit').modal('show');
      $('#form-edit').attr('action', '/akunMHS/' + "{{ old('nim_edit') }}");
      
      let status = "{{ old('status_edit') }}";
      
      if(status == "Lulus" || status == "DO" || status == "Undur Diri" || status == "Meninggal Dunia"){
        $('#semester_akhir').parent().removeClass('d-none');
      }
    });
  </script>
@endif