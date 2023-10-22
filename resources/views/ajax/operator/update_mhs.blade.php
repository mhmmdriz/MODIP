<table class="table table-stripped m-0">
  <tr>
    <th>No</th>
    <th>Nama Mahasiswa</th>
    <th>NIM/Username</th>
    <th>Angkatan</th>
    <th>Status</th>
    <th>Action</th>
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
      <td>{{ $mhs->user->status}}</td>
      <td>
        <a class="btn btn-warning btn-sm" href="/buku/{{ $mhs->isbn }}/edit">Reset Password</a>
        <form action="/buku/{{ $mhs->isbn }}" method="post" class="d-inline">
          @method('delete')
          @csrf
          <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
            Hapus Akun
          </button>
        </form>
      </td>
    </tr>
  @endforeach
</table>