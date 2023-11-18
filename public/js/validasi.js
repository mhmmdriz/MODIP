$(document).ready(function() {
  function validateData(data, progress) {
    let url = "";
    if (progress == "khs") {
      url = "/validateKHS";
    } else if (progress == "irs") {
      url = "/validateIRS";
    } else if (progress == "pkl") {
      url = "/validatePKL";
    } else if (progress == "skripsi") {
      url = "/validateSkripsi";
    }

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: url,
      data: data,
      success: function(response) {
        console.log('Validation Response:', response);

        // Disable edit buttons after successful validation
        if (response.status === 'success') {
          var smt = data.smt;
          var selector = '.modalKHSButton[data-smt="' + smt + '"]';
          var buttons = $(selector);

          if (buttons.length > 0) {
            buttons.prop('disabled', true);
            console.log('Edit buttons disabled for', selector);
          } else {
            console.warn('No buttons found for selector:', selector);
          }
        }
      },
      error: function(response) {
        console.log('Error:', response);
      }
    });
  }

  $('.validasi').click(function() {
    var nim = $(this).data('nim');
    var smt = $(this).data('smt');
    var progress = $(this).data('progress');
    var infoValidasi = document.getElementById("info_validasi" + smt);

    data = {
      nim: nim,
      smt: smt,
    };

    if (this.classList.contains('btn-success')) {
      this.classList.remove('btn-success');
      this.classList.add('btn-danger');
      this.innerHTML = "Batalkan Validasi";
      infoValidasi.classList.remove('text-danger');
      infoValidasi.classList.add('text-success');
      infoValidasi.innerHTML = "sudah";
      data['validasi'] = 1;
    } else {
      this.classList.remove('btn-danger');
      this.classList.add('btn-success');
      this.innerHTML = "Validasi";
      infoValidasi.classList.remove('text-success');
      infoValidasi.classList.add('text-danger');
      infoValidasi.innerHTML = "belum";
      data['validasi'] = 0;
    }

    validateData(data, progress);

    console.log(data);
  });
});

// $('.validasi').click(function() {
//   var nim = $(this).data('nim');
//   var smt = $(this).data('smt');
//   var progress = $(this).data('progress');
//   var infoValidasi = document.getElementById("info_validasi" + smt);

//   data = {
//       nim: nim,
//       smt: smt,
//   };

//   $.ajaxSetup({
//       headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//       }
//   });

//   $.ajax({
//       type: 'POST',
//       url: url,
//       data: data,
//       success: function(response) {
//           console.log('Validation Response:', response);

//           if (response.status === 'success') {
//               // Validation succeeded
//               if (response.message === '1') {
//                   // Button was validated
//                   $(this).removeClass('btn-success').addClass('btn-danger');
//                   $(this).html("Batalkan Validasi");
//                   infoValidasi.classList.remove('text-danger');
//                   infoValidasi.classList.add('text-success');
//                   infoValidasi.innerHTML = "sudah";
//                   data['validasi'] = 1;
//               } else {
//                   // Button validation was canceled
//                   $(this).removeClass('btn-danger').addClass('btn-success');
//                   $(this).html("Validasi");
//                   infoValidasi.classList.remove('text-success');
//                   infoValidasi.classList.add('text-danger');
//                   infoValidasi.innerHTML = "belum";
//                   data['validasi'] = 0;

//                   // Re-enable the edit button for Mahasiswa
//                   var selector = '.modalKHSButton[data-smt="' + smt + '"]';
//                   var buttons = $(selector);
//                   buttons.prop('disabled', false);
//               }
//           } else {
//               // Handle the case where validation failed
//               console.log('Validation failed.');
//           }
//       },
//       error: function(response) {
//           console.log('Error:', response);
//       }
//   });
// });
// });