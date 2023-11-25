<div class="modal fade" id="modalIRS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/validasiProgress/validasiIRS/{{ $angkatan }}/{{ $mahasiswa->nim }}/update" method="POST" enctype="multipart/form-data">
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

          <input type="hidden" name="scan_irs_old" id="scan_irs_old" value="{{ old('scan_irs_old') }}">

          <div class="mb-3">
            <label for="scan_irs" class="form-label">Scan IRS (PDF)</label>
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
      var scanirs = $("#scan_irs_old").val();
      console.log(scanirs);
      $('#modalIRS').modal('show');
      $('#modalLabel').text('Edit IRS Semester {{ old('smt') }}');
      if (scanirs != '') {
        $('#link-pdf').text("scan-irs-" + smt + ".pdf");
        $('#link-pdf').css("margin-bottom", "10px");
        $('#link-pdf').attr("href", "/showFile/" + (scanirs));
      }
    });
  </script>
@endif