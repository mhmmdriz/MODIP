<table class="table table-stripped m-0" id="tabel-akun-mhs">
  <tr>
    <th>No</th>
    <th>Nama Mahasiswa</th>
    <th>NIM/Username</th>
    <th>Angkatan</th>
    <th>Dosen Wali</th>
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
      <td>{{ $mhs->dosenwali->nama}}</td>
      <td>{{ $mhs->status}}</td>
      <td>
        <a class="btn btn-warning btn-sm mb-1" href="/akunMHS/{{ $mhs->nim }}/reset">Reset Password</a>
        <form action="/akunMHS/{{ $mhs->nim }}" method="post" class="d-inline">
          @method('delete')
          @csrf
          <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('Are you sure?')">
            Hapus Akun
          </button>
        </form>
        <div class="btn btn-secondary btn-sm mb-1 btn-edit-data" data-bs-toggle="modal" data-bs-target="#modalEdit"
        data-nama="{{ $mhs->nama }}" data-nim="{{ $mhs->nim }}" data-angkatan="{{ $mhs->angkatan }}" data-status="{{ $mhs->status }}" data-doswal="{{ $mhs->dosen_wali }}" data-smt-akhir="{{ $mhs->semester_akhir }}">
          Edit Data
        </div>
        <a class="btn btn-secondary btn-sm mb-1" href="/akunMHS/{{ $mhs->nim }}/editProfil">Edit Profil</a>
      </td>
    </tr>
  @endforeach
</table>

<script src="/js/akun.js"></script>