<table class="table table-stripped m-0">
  <tr>
    <th>No</th>
    <th>Nama Dosen</th>
    <th>NIP/Username</th>
    <th>No Telepon</th>
    <th>Email SSO</th>
    <th>Action</th>
  </tr>

  @php
    $i = 0;
  @endphp

  @foreach ($data_doswal as $doswal)
    {{-- @dd($doswal->user->password) --}}
    <tr>
      <td>{{ ++$i }}</td>
      <td>{{ $doswal->nama }}</td>
      <td>{{ $doswal->nip }}</td>
      <td>{{ $doswal->no_telp}}</td>
      <td>{{ $doswal->email_sso}}</td>
      <td>
        <a class="btn btn-warning btn-sm" href="/akunDosenWali/{{ $doswal->nip }}/reset">Reset Password</a>
        <form action="/akunDosenWali/{{ $doswal->nip }}" method="post" class="d-inline">
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