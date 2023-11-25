$(document).ready(function() {
  // Attach a click event handler to the "Hapus" button for views anggota
  $('.rekap-pkl').click(function() {
    let angkatan = $(this).data('angkatan');
    let status = $(this).data('status');

    $.ajax({
      type: 'GET',
      url: '/showListMhsPKL',
      data: {'angkatan':angkatan, 'status':status},
      success: function(response) {
        $('.list-mhs-pkl').html(response.html);
        console.log(response.message);
      },
      error: function(response) {
        // console.log('Error:', response);
      }
    });
  });

  $('.rekap-skripsi').click(function() {
    let angkatan = $(this).data('angkatan');
    let status = $(this).data('status');

    $.ajax({
      type: 'GET',
      url: '/showListMhsSkripsi',
      data: {'angkatan':angkatan, 'status':status},
      success: function(response) {
        $('.list-mhs-skripsi').html(response.html);
        // console.log(response.html);
      },
      error: function(response) {
        // console.log('Error:', response);
      }
    });
  });

  $(".rekap-status").click(function() {
    let angkatan = $(this).data('angkatan');
    $(".data-angkatan").attr("data-angkatan", angkatan);

    $.ajax({
      type: 'GET',
      url: '/showListStatusAjax',
      data: {'angkatan':angkatan},
      success: function(response) {
        $('.list-mhs-status').html(response.html);
      },
      error: function(response) {
        // console.log('Error:', response);
      }
    });

  });

  // $("#select_status").change(function() {
  //   let angkatan = $(".data-angkatan").data('angkatan');
  //   let status = $(this).val();

  //   $.ajax({
  //     type: 'GET',
  //     url: '/showListStatusAjax',
  //     data: {'angkatan':angkatan, 'status':status},
  //     success: function(response) {
  //       $('.list-mhs-status').html(response.html);
  //     },
  //     error: function(response) {
  //       console.log('Error:', response);
  //     }
  //   });
  // });

  // $('#btn-print-list').click(function() {
  //   let rekap_pkl = document.getElementById('rekap-pkl-main');
  //   let list_mhs = document.getElementById('list-mhs-pkl-print');
  //   // console.log("success");
  //   rekap_pkl.classList.remove('printable');
  //   list_mhs.classList.add('printable');

  //   window.print();
  // });

  // $('#btn-print-rekap').click(function() {
  //   let rekap_pkl = document.getElementById('rekap-pkl-main');
  //   let list_mhs = document.getElementById('list-mhs-pkl-print');
  //   console.log("success");
  //   rekap_pkl.classList.add('printable');
  //   if(list_mhs != null){
  //     list_mhs.classList.remove('printable');
  //   }

  //   window.print();
  // });

});

