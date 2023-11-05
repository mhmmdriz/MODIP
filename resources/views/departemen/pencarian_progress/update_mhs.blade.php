<table class="table table-stripped m-0">
  <tr>
    <th>No</th>
    <th>Nama Mahasiswa</th>
    <th>NIM</th>
    <th>Angkatan</th>
    <th>Status</th>
    <th>Action</th>
  </tr>

  @php
    $i = 0;
  @endphp

  @foreach ($data_mhs as $mhs)
    <tr>
      <td>{{ ++$i }}</td>
      <td>{{ $mhs->nama }}</td>
      <td>{{ $mhs->nim }}</td>
      <td>{{ $mhs->angkatan}}</td>
      <td>{{ $mhs->status}}</td>
      <td>
        <a class="btn btn-primary btn-sm" href="/pencarianProgressStudi/{{ $mhs->nim }}">Detail Progress Studi</a>
      </td>
    </tr>
  @endforeach
</table>
