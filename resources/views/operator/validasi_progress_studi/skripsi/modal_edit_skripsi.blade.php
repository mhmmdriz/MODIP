<div class="modal fade" id="modalSkripsi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/validasiProgress/validasiSkripsi/{{ $angkatan }}/{{ $nim }}/update" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="modal-body">
          <div class="mb-3" id="semester-container">
            <label for="semester" class="form-label">Semester</label>
            <input type="number" class="form-control @error('semester') is-invalid @enderror" name="semester" value="{{ old('semester') }}" id="semester">
            @error('semester')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="mb-3" id="tanggal-sidang-container">
            <label for="tanggal_sidang" class="form-label">Tanggal Sidang</label>
            <input type="date" class="form-control @error('tanggal_sidang') is-invalid @enderror" name="tanggal_sidang" value="{{ old('tanggal_sidang') }}" id="tanggal_sidang">
            @error('tanggal_sidang')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="mb-3" id="nilai-container">
              <label for="nilai" class="form-label">Nilai</label>
              <select class="form-control @error('nilai') is-invalid @enderror" name="nilai" aria-label="Default select example" id="nilai">
                <option value="" selected>Pilih Nilai</option>
                <option value="A" {{ (old('nilai') == "A")?"selected":"" }}>A</option>
                <option value="B" {{ (old('nilai') == "B")?"selected":"" }}>B</option>
                <option value="C" {{ (old('nilai') == "C")?"selected":"" }}>C</option>
                <option value="D" {{ (old('nilai') == "D")?"selected":"" }}>D</option>
                <option value="E" {{ (old('nilai') == "E")?"selected":"" }}>E</option>
              </select>
              @error('nilai')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
          </div>

          <input type="hidden" name="scan_bass_old" id="scan_bass_old" value="{{ old('scan_bass_old') }}">

          <div class="mb-3" id="scan-container">
            <label for="scan_bass" class="form-label">Scan Berita Acara Skripsi (PDF)</label>
            <a href="" style="display: block;" id="link-pdf" target="_blank"></a>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if($errors->any())
<script>
  $(document).ready(function () {
    var status = $("#status_old").val();
    var scanskripsi = $("#scan_bass_old").val();
    // console.log(scanskripsi);
    $('#modalSkripsi').modal('show');
    $('#modalLabel').text('Edit Skripsi');
    if (scanskripsi != '') {
      $('#link-pdf').text("scan-skripsi" + ".pdf");
      $('#link-pdf').css("margin-bottom", "10px");
      $('#link-pdf').attr("href", "/showFile/" + (scanskripsi));
    }
  });
</script>
@endif
