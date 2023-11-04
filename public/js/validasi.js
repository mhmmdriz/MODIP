$(document).ready(function() {
  $('.modalIRSButton').click(function() {
    // reset setelah validasi dilanggar
    $('#inputsks').removeClass("is-invalid");
    $('#scan_irs').removeClass("is-invalid");

    // Get the data attributes from the button
    var smt = $(this).data('smt');
    var sks = $(this).data('sks');
    var scanirs = $(this).data('scan-irs');
    var linkpdf = $('#link-pdf');

    if (typeof sks === 'undefined') {
      sks = null;
    }
    
    // Set the data in the modal
    $('#modalLabel').text("Edit IRS Semester " + smt);

    if (typeof scanirs === 'undefined') {
      scanirs = null;
      linkpdf.css("margin-bottom", "initial");
      linkpdf.text(null);
    }else{
      linkpdf.text("scan-irs-" + smt + ".pdf");
      linkpdf.css("margin-bottom", "10px");
    }

    linkpdf.attr("href", "/scan-irs/" + (scanirs));
    $('#scan_irs_old').val(scanirs);

    console.log(scanirs);

    document.getElementById("smt").value = smt;
    document.getElementById("inputsks").value = sks;
  });


  function validateIRS(data){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: 'POST',
      url: '/validateIRS',
      data: data,
      success: function(response) {
        console.log(response.message);
      },
      error: function(response) {
        console.log('Error:', response);
      }
    });
  }

  $('#validasi').click(function() {
    var nim = $(this).data('nim');
    var smt = $(this).data('smt');
    var infoValidasi = document.getElementById("info_validasi");

    data = {
      nim: nim,
      smt: smt
    };
    
    if(this.classList.contains('btn-success')){
      this.classList.remove('btn-success');
      this.classList.add('btn-danger');
      this.innerHTML = "Batalkan Validasi";
      infoValidasi.classList.remove('text-danger');
      infoValidasi.classList.add('text-success');
      infoValidasi.innerHTML = "sudah";
      data['validasi'] = 1;
    }else{
      this.classList.remove('btn-danger');
      this.classList.add('btn-success');
      this.innerHTML = "Validasi";
      infoValidasi.classList.remove('text-success');
      infoValidasi.classList.add('text-danger');
      infoValidasi.innerHTML = "belum";
      data['validasi'] = 0;
    }
    
    validateIRS(data);

    console.log(data);
  });
});