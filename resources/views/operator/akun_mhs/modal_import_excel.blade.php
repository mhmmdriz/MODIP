<!-- Modal -->
<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Import Akun Mahasiswa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/akunMHS/importExcel" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
          @csrf
          <div class="mb-3">
            <div class="position-absolute me-3" style="right: 0"><a href="/download-file/{{ "private/template_excel/template-generate-akun-mahasiswa.xlsx" }}">unduh template .xlsx</a></div>
            <label for="fileExcel" class="form-label">File .xlsx</label>
            <div class="col">
              <input class="form-control @error('fileExcel') is-invalid @enderror" type="file" id="fileExcel" name="fileExcel">
              @error('fileExcel')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

@if($errors->has('fileExcel'))
  <script>
    $(document).ready(function () {
      $('#modalImport').modal('show');
    });
  </script>
@endif
