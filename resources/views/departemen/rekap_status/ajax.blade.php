<div class="modal-header">
  <h1 class="modal-title fs-5" id="modalListStatusLabel">
    @if ($status != null)
    <h5>List Mahasiswa Angkatan {{ $angkatan }} Status {{ $status }}</h5>
    @else
    <h5>List Mahasiswa Angkatan {{ $angkatan }}</h5>
    @endif
  </h1>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
  <div class="row my-3">
    <div class="col-md-4">
      <p>Filter Angkatan :</p>
      <select name="status" id="select_status" class="form-control">
        <option value="" {{ $status ? '' : 'selected' }}>Semua Status</option>
        <option value="Aktif" {{ $status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="Lulus" {{ $status == 'Lulus' ? 'selected' : '' }}>Lulus</option>
        <option value="Cuti" {{ $status == 'Cuti' ? 'selected' : '' }}>Cuti</option>
        <option value="Mangkir" {{ $status == 'Mangkir' ? 'selected' : '' }}>Mangkir</option>
        <option value="DO" {{ $status == 'DO' ? 'selected' : '' }}>DO</option>
        <option value="Undur Diri" {{ $status == 'Undur Diri' ? 'selected' : '' }}>Undur Diri</option>
        <option value="Meninggal Dunia" {{ $status == 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
      </select>
    </div>
  </div>

  <div class="row my-3" id="list-mhs-skripsi-print">
    <div class="col">

      <table class="table table-stripped m-0" id="tabel-rekap-skripsi">
        <tr>
          <th>No</th>
          <th>NIM</th>
          <th>Nama</th>
          <th>Angkatan</th>
          <th>Status</th>
        </tr>
      
        @php
          $i = 0;
        @endphp
      
        @foreach ($data_mhs as $mhs)
          <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $mhs->nim }}</td>
            <td>{{ $mhs->nama }}</td>
            <td>{{ $mhs->angkatan}}</td>
            <td>{{ $mhs->status}}</td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
  <form action="/printListMhsStatus" target="__blank" method="post">
    @csrf
    <input type="hidden" name="objects" value="{{ json_encode($data_mhs) }}">
    <input type="hidden" name="angkatan" value="{{ $angkatan }}">
    <input type="hidden" name="status" value="{{ $status }}">
    {{-- @dump(json_encode($data_mhs)) --}}
    <button class="btn btn-primary" type="submit">Cetak</button>
  </form>
  {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
</div>

<script>
  $("#select_status").change(function() {
    let angkatan = $(".data-angkatan").data('angkatan');
    let status = $(this).val();

    $.ajax({
      type: 'GET',
      url: '/showListStatusAjax',
      data: {'angkatan':angkatan, 'status':status},
      success: function(response) {
        $('.list-mhs-status').html(response.html);
      },
      error: function(response) {
        console.log('Error:', response);
      }
    });
  });
</script>
