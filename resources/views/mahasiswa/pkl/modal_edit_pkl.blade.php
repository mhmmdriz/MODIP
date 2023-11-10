<div class="modal fade" id="modalPKL" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalLabel">Pengisian Data Praktik Kerja Lapangan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/pkl/" method="POST" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class="modal-body">
            <input type="hidden" id="smt" name="smt" value="{{ old('smt') }}">
            <div class="mb-3">
                <label for="dosen_pembimbing" class="form-label">Dosen Pembimbing</label>
                <select class="form-select" name="dosen_pembimbing" required>
                    <option value="aaa">aaa</option>
                    <option value="tes">tes</option>
                </select>
            </div>              
            <div class="mb-3">
                <label for="status_pkl" class="form-label">Status PKL</label>
                <select class="form-select" name="status_pkl" id="status_pkl" onchange="checkStatus(this)">
                  <option value="Sudah Ambil" {{ old('status_pkl') === 'Sudah Ambil' ? 'selected' : '' }}>Sudah Ambil</option>
                  <option value="Sudah Ambil" {{ old('status_pkl') === 'Sudah Ambil' ? 'selected' : '' }}>Sedang Mengambil</option>
                  <option value="Belum Ambil" {{ old('status_pkl') === 'Belum Ambil' ? 'selected' : '' }}>Belum Ambil</option>
                </select>
            </div>
            <script>
              function checkStatus(select) {
                const submitButton = document.querySelector('button[type="submit"]');
                if (select.value === 'Belum Ambil') {
                  submitButton.setAttribute('disabled', true);
                } else {
                  submitButton.removeAttribute('disabled');
                }
              }
            </script>                          
            <div class="mb-3">
                <label for="nilai_pkl" class="form-label">Nilai PKL</label>
                <select class="form-select" name="nilai_pkl" required>
                  <option value="A" {{ old('nilai_pkl') === 'A' ? 'selected' : '' }}>A</option>
                  <option value="B" {{ old('nilai_pkl') === 'B' ? 'selected' : '' }}>B</option>
                  <option value="C" {{ old('nilai_pkl') === 'C' ? 'selected' : '' }}>C</option>
                  <option value="D" {{ old('nilai_pkl') === 'D' ? 'selected' : '' }}>D</option>
                  <option value="E" {{ old('nilai_pkl') === 'E' ? 'selected' : '' }}>E</option>
                </select>
            </div>              
            <div class="mb-3">
              <label for="tahun" class="form-label">Tahun</label>
              <input type="text" class="form-control" name="tahun" value="{{ old('tahun') }}" pattern="\d{4}" title="Tidak boleh selain tahun (Maks 4 digit)" required>
            </div>
            <div class="mb-3">
              <label for="scan_berita_acara" class="form-label">Scan Berita Acara Seminar PKL (PDF)</label>
              <a href="" style="display: block;" id="link-pdf" target="_blank"></a>
              <input class="form-control @error('scan_berita_acara') is-invalid @enderror" type="file" id="scan_berita_acara" name="scan_berita_acara" required>
              @error('scan_berita_acara')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
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
        var smt = $("#smt").val();
        var scanBeritaAcara = $("#scan_berita_acara").val();
        $('#modalPKL').modal('show');
        $('#modalLabel').text('Edit Data PKL');
        if (scanBeritaAcara != '') {
          $('#link-pdf').text("scan-berita-acara-" + smt + ".pdf");
          $('#link-pdf').css("margin-bottom", "10px");
          $('#link-pdf').attr("href", "/scan-berita-acara/" + (scanBeritaAcara));
        }
      });
    </script>
    @else
    <script>
        if ($('#modalPKL').hasClass('show')) {
            $('#modalPKL').modal('hide');
        }
    </script>
@endif

  