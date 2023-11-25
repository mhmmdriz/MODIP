$(document).ready(function() {
  $(".btn-edit-data").click(function() {
    // reset setelah validasi dilanggar
    $('#nama_edit').removeClass("is-invalid");
    $('#angkatan_edit').removeClass("is-invalid");
    $('#status_edit').removeClass("is-invalid");
    $('#doswal').removeClass("is-invalid");

    var nama = $(this).data('nama');
    var nim = $(this).data('nim');
    var angkatan = $(this).data('angkatan');
    var status = $(this).data('status');
    var dosen_wali = $(this).data('doswal');
  
    $('#form-edit').attr('action', '/akunMHS/' + nim);

    $('#nama_edit').val(nama);
    $('#nim_edit').val(nim);
    $('#angkatan_edit').find('option').each(function() {
      if ($(this).val() == angkatan) {
        $(this).attr('selected', 'selected');
      }
    });
    
    var selectStatus = $('#status_edit');
    var selectDoswal = $('#doswal');

    for (var i = 0; i < selectStatus[0].length; i++) {
      if (selectStatus[0][i].value == status) {
        selectStatus[0][i].selected = true;
      }
    }

    for (var i = 0; i < selectDoswal[0].length; i++) {
      if (selectDoswal[0][i].value == dosen_wali) {
        selectDoswal[0][i].selected = true;
      }
    }

  });

});