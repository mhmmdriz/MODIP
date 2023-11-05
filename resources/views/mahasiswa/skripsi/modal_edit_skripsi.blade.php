<div class="modal fade" id="modalSkripsi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalLabel"></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/skripsi/" method="POST" enctype="multipart/form-data">
          @csrf
          @method('put')
          <div class="modal-body">
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" aria-label="Default select example">
                  <option value="" selected>Pilih status</option>
                  <option value="Belum Ambil" {{ (old('status') == "Belum Ambil")?"selected":"" }}>Belum Ambil</option>
                  <option value="Sedang Ambil" {{ (old('status') == "Sedang Ambil")?"selected":"" }}>Sedang Ambil</option>
                  <option value="Lulus" {{ (old('status') == "Lulus")?"selected":"" }}>Lulus</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3" id="tanggal-lulus-container">
                <label for="tanggal" class="form-label">Tanggal Lulus</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}" id="tanggal_lulus">
                @error('tanggal_lulus')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3" id="tanggal-sidang-container">
                <label for="tanggal" class="form-label">Tanggal Sidang</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}" id="tanggal_sidang">
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
                  <option value="A" {{ (old('status') == "A")?"selected":"" }}>A</option>
                  <option value="B" {{ (old('status') == "B")?"selected":"" }}>B</option>
                  <option value="C" {{ (old('status') == "C")?"selected":"" }}>C</option>
                  <option value="D" {{ (old('status') == "D")?"selected":"" }}>D</option>
                  <option value="E" {{ (old('status') == "E")?"selected":"" }}>E</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>
  
            <input type="hidden" name="scan_bass_old" id="scan_bass_old" value="{{ old('scan_bass_old') }}">
  
            <div class="mb-3">
              <label for="scan_bass" class="form-label">Scan Berita Acara Skripsi (PDF)</label>
              <a href="" style="display: block;" id="link-pdf" target="_blank"></a>
              <input class="form-control @error('scan_bass') is-invalid @enderror" type="file" id="scan_bass" name="scan_bass">
              @error('scan_bass')
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


<script>
  // Dapatkan elemen select status
    var statusSelect = document.getElementById("status");

    // Dapatkan elemen tanggal lulus dan kontainer tanggal lulus
    var tanggalLulus = document.getElementById("tanggal_lulus");
    var tanggalLulusContainer = document.getElementById("tanggal-lulus-container");
    var tanggalSidang = document.getElementById("tanggal_sidang");
    var tanggalSidangContainer = document.getElementById("tanggal-sidang-container");

    // Dapatkan elemen nilai dan kontainer nilai
    var nilai = document.getElementById("nilai");
    var nilaiContainer = document.getElementById("nilai-container");

    // Atur awal visibilitas elemen tanggal lulus
    if (statusSelect.value !== "Lulus") {
        nilaiContainer.style.display = "none";
        tanggalLulusContainer.style.display = "none";
    }

    if (statusSelect.value !== "Sedang Ambil") {
        tanggalSidangContainer.style.display = "none";
    }

    // Tambahkan event listener untuk mengubah visibilitas elemen tanggal lulus berdasarkan pilihan status
    statusSelect.addEventListener("change", function() {
    if (statusSelect.value === "Belum Ambil") {
        tanggalLulusContainer.style.display = "none";
        nilaiContainer.style.display = "none";
        tanggalSidangContainer.style.display = "none";
    } else if (statusSelect.value === "Lulus") {
        tanggalLulusContainer.style.display = "block";
        nilaiContainer.style.display = "block";
        tanggalSidangContainer.style.display = "none";
    } else {
        tanggalLulusContainer.style.display = "none";
        nilaiContainer.style.display = "none";
        tanggalSidangContainer.style.display = "block";
    }
  });

</script>
  @if($errors->any())
  <script>
    $(document).ready(function () {
      var scanskripsi = $("#scan_bass_old").val();
      console.log(scanskripsi);
      $('#modalSkripsi').modal('show');
      $('#modalLabel').text('Edit Skripsi');
      if (scanskripsi != '') {
        $('#link-pdf').text("scan-skripsi-" + smt + ".pdf");
        $('#link-pdf').css("margin-bottom", "10px");
        $('#link-pdf').attr("href", "/scan-skripsi/" + (scanskripsi));
      }
    });
  </script>
@endif
  
    

