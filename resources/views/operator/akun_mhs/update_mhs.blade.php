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
        <button type="button" class="modalResetPasswordButton btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalResetPassword" data-nim="{{ $mhs->nim }}" data-nama="{{ $mhs->nama }}">Reset Password</button>
        <button type="button" class="modalDeleteAkunButton btn btn-danger btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalDeleteAkun" data-nim="{{ $mhs->nim }}" data-nama="{{ $mhs->nama }}">Hapus Akun</button>
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

<script>
  $(document).ready(function() {
    $('.modalResetPasswordButton').click(function() {
      var nim = $(this).data('nim');
      var nama = $(this).data('nama');
      document.getElementById("form-reset-password").setAttribute("action", "/akunMHS/"+nim +"/reset");
      document.getElementById("nama1").innerHTML = nama;
      document.getElementById("nim1").innerHTML = nim;
    });
    $('.modalDeleteAkunButton').click(function() {
      var nim = $(this).data('nim');
      var nama = $(this).data('nama');
      document.getElementById("form-hapus-akun").setAttribute("action", "/akunMHS/"+nim );
      document.getElementById("nama2").innerHTML = nama;
      document.getElementById("nim2").innerHTML = nim;
    });
  });
</script>