<table class="table table-stripped m-0">
    <tr>
      <th>No</th>
      <th>Nama Mahasiswa</th>
      <th>NIM</th>
      <th>Angkatan</th>
      <th>Status</th>
      <th>Action (Entry)</th>
    </tr>

    @php
      $i = 0;
    @endphp
  
    @foreach ($data_mhs as $mhs)
      {{-- @dd($mhs->user->password) --}}
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $mhs->nama }}</td>
        <td>{{ $mhs->nim }}</td>
        <td>{{ $mhs->angkatan}}</td>
        <td>{{ $mhs->status}}</td>
        <td>
          <a class="btn btn-info btn-sm mb-1" href="/entryProgress/entryIRS/{{ $mhs->nim }}">IRS</a>
          <a class="btn btn-primary btn-sm mb-1" href="/entryProgress/entryKHS/{{ $mhs->nim }}">KHS</a>
          <a class="btn btn-warning btn-sm mb-1" href="/entryProgress/entryPKL/{{ $mhs->nim }}">PKL</a>
          <a class="btn btn-success btn-sm mb-1" href="/entryProgress/entrySkripsi/{{ $mhs->nim }}">Skripsi</a>
        </td>
      </tr>
    @endforeach
</table>