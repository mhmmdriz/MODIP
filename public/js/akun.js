$(document).ready(function() {
  $(".btn-edit-data").click(function() {
    // reset setelah validasi dilanggar
    $('#nama_edit').removeClass("is-invalid");
    $('#angkatan_edit').removeClass("is-invalid");
    $('#status_edit').removeClass("is-invalid");
    $('#doswal').removeClass("is-invalid");
    $('#semester_akhir').removeClass("is-invalid");

    var nama = $(this).data('nama');
    var nim = $(this).data('nim');
    var angkatan = $(this).data('angkatan');
    var status = $(this).data('status');
    var dosen_wali = $(this).data('doswal');
    var semester_akhir = $(this).data('smt-akhir');

    if(status == "Lulus" || status == "DO" || status == "Undur Diri" || status == "Meninggal Dunia"){
      $('#semester_akhir').parent().removeClass('d-none');
    }else{
      $('#semester_akhir').parent().addClass('d-none');
    }
  
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
    var selectSemesterAkhir = $('#semester_akhir');

    for (var i = 0; i < selectStatus[0].length; i++) {
      if (selectStatus[0][i].value == status) {
        selectStatus[0][i].selected = true;
      }
    }

    selectSemesterAkhir.prop('selectedIndex', semester_akhir)

    for (var i = 0; i < selectDoswal[0].length; i++) {
      if (selectDoswal[0][i].value == dosen_wali) {
        selectDoswal[0][i].selected = true;
      }
    }

    $('#status_edit').change(function () {
      let status = $(this).val();
      
      if(status == "Lulus" || status == "DO" || status == "Undur Diri" || status == "Meninggal Dunia"){
        $('#semester_akhir').parent().removeClass('d-none');
        $('#semester_akhir').prop('selectedIndex', semester_akhir)
      }else{
        $('#semester_akhir').parent().addClass('d-none');
        $('#semester_akhir').prop('selectedIndex', 0)
      }
    });

  });

});