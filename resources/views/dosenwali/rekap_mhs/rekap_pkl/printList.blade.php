<style>
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 10px;
  }
</style>

<div class="col">
  <h2>Daftar {{ $status }} Lulus PKL Mahasiswa Perwalian Informatika Angkatan {{ $angkatan }}</h2>
</div>

<div class="col">
  <table class="table" id="tabel-rekap-pkl" style="border: 1px solid black" border-1>
    <tr>
      <th>No</th>
      <th>NIM</th>
      <th>Nama</th>
      <th>Angkatan</th>
      <th>Nilai</th>
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
        @if(isset($mhs["nilai"]))
          <td>{{ $mhs["nilai"]}}</td>
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