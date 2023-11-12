<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  padding: 10px;
}

</style>

@if ($status != null)
<h2>Daftar Mahasiswa Informatika Angkatan {{ $angkatan }} Status {{ $status }}</h2>
@else
<h2>Daftar Mahasiswa Informatika Angkatan {{ $angkatan }} Semua Status</h2>
@endif

<div class="col">
  <table class="table" id="tabel-rekap-skripsi" style="border: 1px solid black" border-1>
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
        <td>{{ $mhs["nim"]}}</td>
        <td>{{ $mhs["nama"]}}</td>
        <td>{{ $mhs["angkatan"]}}</td>
        @if(isset($mhs["status"]))
          <td>{{ $mhs["status"]}}</td>
        @else
          <td>~</td>
        @endif
      </tr>
    @endforeach
  </table>
</div>

<script>
  window.print();
</script>