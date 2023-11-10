$(document).ready(function() {
  // Attach a click event handler to the "Hapus" button for views anggota
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

  $('.modalKHSButton').click(function() {
    // reset setelah validasi dilanggar
    $('#inputsks').removeClass("is-invalid");
    $('#scan_khs').removeClass("is-invalid");

    // Get the data attributes from the button
    var smt = $(this).data('smt');
    var sks = $(this).data('sks');
    var ips = $(this).data('ips');
    var scankhs = $(this).data('scan-khs');
    var linkpdf = $('#link-pdf');

    if (typeof sks === 'undefined') {
      sks = null;
    }
    if (typeof ips === 'undefined') {
      ips = null;
    }
    
    // Set the data in the modal
    $('#modalLabel').text("Edit KHS Semester " + smt);

    if (typeof scankhs === 'undefined') {
      scankhs = null;
      linkpdf.css("margin-bottom", "initial");
      linkpdf.text(null);
    }else{
      linkpdf.text("scan-khs-" + smt + ".pdf");
      linkpdf.css("margin-bottom", "10px");
    }

    linkpdf.attr("href", "/scan-khs/" + (scankhs));
    $('#scan_khs_old').val(scankhs);

    console.log(scankhs);

    document.getElementById("smt").value = smt;
    document.getElementById("inputsks").value = sks;
    document.getElementById("inputips").value = ips;
  });

  $('.modalPKLButton').click(function () {
    $('#modalPKLForm').on('submit', function (event) { event.preventDefault();
    $('#modalPKLForm')[0].reset();
    $('#modalPKLForm .form-control').removeClass('is-invalid');
    $('#modalPKLForm .invalid-feedback').remove();

    $('#modalLabel').text('Edit PKL Information');

    var smt = $(this).data('smt');
    var dospem = $(this).data('dospem');
    var status = $(this).data('status');
    var nilai = $(this).data('nilai');
    var formData = new FormData(this);

    $('#smt').val(smt);
    $('#dosen_pembimbing').val(dospem);
    $('#status_pkl').val(status);
    $('#nilai_pkl').val(nilai);
  });
  });
});
