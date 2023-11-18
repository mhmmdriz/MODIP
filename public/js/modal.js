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
    $('#inputsksk').removeClass("is-invalid");
    $('#scan_khs').removeClass("is-invalid");
    $('#inputips').removeClass("is-invalid");
    $('#inputipk').removeClass("is-invalid");

    // Get the data attributes from the button
    var smt = $(this).data('smt');
    var sks = $(this).data('sks');
    var sksk = $(this).data('sksk');
    var ips = $(this).data('ips');
    var ipk = $(this).data('ipk');
    var scankhs = $(this).data('scan-khs');
    var linkpdf = $('#link-pdf');

    if (typeof ips === 'undefined') {
      ips = null;
    }
    if (typeof ipk === 'undefined') {
      ipk = null;
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

    // console.log(scankhs);

    document.getElementById("smt").value = smt;
    document.getElementById("inputsks").value = sks;
    document.getElementById("inputsksk").value = sksk;
    document.getElementById("inputips").value = ips;
    document.getElementById("inputipk").value = ipk;
  });
});

$('.modalSkripsiButton').click(function() {
  // reset setelah validasi dilanggar
  $('#status').removeClass("is-invalid");
  $('#semester').removeClass("is-invalid");
  $('#scan_bass').removeClass("is-invalid");
  $('#tanggal_sidang').removeClass("is-invalid");
  $('#nilai').removeClass("is-invalid");

  // Get the data attributes from the button
  var status = $(this).data('status');
  var semester = $(this).data('semester');
  var tanggalsidang = $(this).data('tanggal-sidang');
  var nilai = $(this).data('nilai');
  var scanskripsi = $(this).data('scan-skripsi');
  var linkpdf = $('#link-pdf');

  if (typeof status === 'undefined') {
    status = null;
  }
  if (typeof tanggal === 'undefined') {
    tanggal = null;
  }
  if (typeof nilai === 'undefined') {
    nilai = null;
  }
  
  // Set the data in the modal
  $('#modalLabel').text("Edit Data Skripsi");

  if (scanskripsi === '') {
    scanskripsi = null;
    linkpdf.css("margin-bottom", "initial");
    linkpdf.text(null);
  }else{
    linkpdf.text("scan-skripsi" + ".pdf");
    linkpdf.css("margin-bottom", "10px");
  }

  linkpdf.attr("href", "/scan-skripsi/" + (scanskripsi));
  $('#status_old').val(status);
  $('#scan_bass_old').val(scanskripsi);

  // console.log(scanskripsi);

  document.getElementById("status").value = status;
  document.getElementById("semester").value = semester;
  document.getElementById("tanggal_sidang").value = tanggalsidang;
  document.getElementById("nilai").value = nilai;

  var statusSelect = document.getElementById("status");
  var semesterContainer = document.getElementById("semester-container");
  var tanggalSidangContainer = document.getElementById("tanggal-sidang-container");
  var scanContainer = document.getElementById("scan-container");
  var nilaiContainer = document.getElementById("nilai-container");

  // Atur awal visibilitas elemen tanggal lulus
  if (statusSelect.value === "") {
      semesterContainer.style.display = "none";
      nilaiContainer.style.display = "none";
      tanggalSidangContainer.style.display = "none";
      scanContainer.style.display = "none";
  } else if (statusSelect.value === "Lulus") {
      semesterContainer.style.display = "block";
      nilaiContainer.style.display = "block";
      tanggalSidangContainer.style.display = "block";
      scanContainer.style.display = "block";
  }
 
  
  statusSelect.addEventListener("change", function() {
      if (statusSelect.value === "Lulus") {
        semesterContainer.style.display = "block";
        nilaiContainer.style.display = "block";
        tanggalSidangContainer.style.display = "block";
        scanContainer.style.display = "block";
    } else {
        semesterContainer.style.display = "none";
        nilaiContainer.style.display = "none";
        tanggalSidangContainer.style.display = "none";
        scanContainer.style.display = "none";
    }

  });

});

$('.modalPKLButton').click(function() {
  // reset setelah validasi dilanggar
  $('#status').removeClass("is-invalid");
  $('#semester').removeClass("is-invalid");
  $('#tanggal_seminar').removeClass("is-invalid");
  $('#nilai').removeClass("is-invalid");
  $('#scan_basp').removeClass("is-invalid");

  // Get the data attributes from the button
  var status = $(this).data('status');
  var semester = $(this).data('semester');
  var tanggalseminar = $(this).data('tanggal-seminar');
  var nilai = $(this).data('nilai');
  var scanpkl = $(this).data('scan-pkl');
  var linkpdf = $('#link-pdf');
  
  // Set the data in the modal
  $('#modalLabel').text("Edit Data PKL");

  if (scanpkl === '') {
    scanpkl = null;
    linkpdf.css("margin-bottom", "initial");
    linkpdf.text(null);
  }else{
    linkpdf.text("scan-pkl" + ".pdf");
    linkpdf.css("margin-bottom", "10px");
  }

  linkpdf.attr("href", "/scan-pkl/" + (scanpkl));
  $('#status_old').val(status);
  $('#scan_basp_old').val(scanpkl);
  // console.log(scanpkl);

  document.getElementById("status").value = status;
  document.getElementById("semester").value = semester;
  document.getElementById("tanggal_seminar").value = tanggalseminar;
  document.getElementById("nilai").value = nilai;

  var statusSelect = document.getElementById("status");
  var semesterContainer = document.getElementById("semester-container");
  var tanggalSeminarContainer = document.getElementById("tanggal-seminar-container");
  var scanContainer = document.getElementById("scan-container");
  var nilaiContainer = document.getElementById("nilai-container");

  // Atur awal visibilitas elemen
  if (statusSelect.value === "") {
    semesterContainer.style.display = "none";
    nilaiContainer.style.display = "none";
    tanggalSeminarContainer.style.display = "none";
    scanContainer.style.display = "none";
} else if (statusSelect.value === "Lulus") {
    semesterContainer.style.display = "block";
    nilaiContainer.style.display = "block";
    tanggalSeminarContainer.style.display = "block";
    scanContainer.style.display = "block";
}


statusSelect.addEventListener("change", function() {
    if (statusSelect.value === "Lulus") {
      semesterContainer.style.display = "block";
      nilaiContainer.style.display = "block";
      tanggalSeminarContainer.style.display = "block";
      scanContainer.style.display = "block";
  } else {
      semesterContainer.style.display = "none";
      nilaiContainer.style.display = "none";
      tanggalSeminarContainer.style.display = "none";
      scanContainer.style.display = "none";
  }

  });
});