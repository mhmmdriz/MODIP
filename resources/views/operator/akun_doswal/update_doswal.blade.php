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
        <button type="button" class="modalResetPasswordButton btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalResetPassword" data-nip="{{ $doswal->nip }}" data-nama="{{ $doswal->nama }}">Reset Password</button>
        <button type="button" class="modalDeleteAkunButton btn btn-danger btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalDeleteAkun" data-nip="{{ $doswal->nip }}" data-nama="{{ $doswal->nama }}">Hapus Akun</button>
      </td>
    </tr>
  @endforeach
</table>  

<script>
  $(document).ready(function() {
    $('.modalResetPasswordButton').click(function() {
      var nip = $(this).data('nip');
      var nama = $(this).data('nama');
      document.getElementById("form-reset-password").setAttribute("action", "/akunDosenWali/"+nip +"/reset");
      document.getElementById("nama1").innerHTML = nama;
      document.getElementById("nip1").innerHTML = nip;
    });
    $('.modalDeleteAkunButton').click(function() {
      var nip = $(this).data('nip');
      var nama = $(this).data('nama');
      document.getElementById("form-hapus-akun").setAttribute("action", "/akunDosenWali/"+nip);
      document.getElementById("nama2").innerHTML = nama;
      document.getElementById("nip2").innerHTML = nip;
    });
  });
</script>