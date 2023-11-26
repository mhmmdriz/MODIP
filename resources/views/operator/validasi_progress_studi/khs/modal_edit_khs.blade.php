<div class="modal fade" id="modalKHS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/validasiProgress/validasiKHS/{{ $angkatan }}/{{ $mahasiswa->nim }}/update" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="modal-body">
          <input type="hidden" id="smt" name="smt" value="{{ old('smt') }}">
          <div class="mb-3">
            <label for="sks" class="form-label">SKS</label>
            <input type="number" class="form-control @error('sks') is-invalid @enderror" name="sks" value="{{ old('sks') }}" id="inputsks">
            @error('sks')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="sksk" class="form-label">SKSk</label>
            <input type="number" class="form-control @error('sksk') is-invalid @enderror" name="sksk" value="{{ old('sksk') }}" id="inputsksk">
            @error('sksk')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="ips" class="form-label">IPs</label>
            <input type="text" class="form-control @error('ips') is-invalid @enderror" name="ips" value="{{ old('ips') }}" id="inputips">
            @error('ips')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="ipk" class="form-label">IPk</label>
            <input type="text" class="form-control @error('ipk') is-invalid @enderror" name="ipk" value="{{ old('ipk') }}" id="inputipk">
            @error('ipk')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <input type="hidden" name="scan_khs_old" id="scan_khs_old" value="{{ old('scan_khs_old') }}">

          <div class="mb-3">
            <label for="scan_khs" class="form-label">Scan KHS (PDF)</label>
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
      var smt = $("#smt").val();
      var scankhs = $("#scan_khs_old").val();
      console.log(scankhs);
      $('#modalKHS').modal('show');
      $('#modalLabel').text('Edit KHS Semester {{ old('smt') }}');
      if (scankhs != '') {
        $('#link-pdf').text("scan-khs-" + smt + ".pdf");
        $('#link-pdf').css("margin-bottom", "10px");
        $('#link-pdf').attr("href", "/showFile/" + (scankhs));
      }
    });
  </script>
@endif