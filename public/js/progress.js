$(document).ready(function() {
  // Attach a click event handler to the "Hapus" button for views anggota
  $('.modalButton').click(function() {
    // Get the data attributes from the button
    var smt = $(this).data('smt');
    var irs = $(this).data('irs');
    var khs = $(this).data('khs');
    var pkl = $(this).data('pkl');
    var skripsi = $(this).data('skripsi');

    $(".title-main").html("Progress Studi Semester " + smt);

    if(irs == ""){
      $(".btn-irs").addClass("disabled");
    }else{
      $(".btn-irs").removeClass("disabled");
      $(".sks-irs").html(irs.sks);
      $(".link-scan-irs").html("scanIRS" + smt + ".pdf");
      $(".link-scan-irs").attr("href", "/scan-irs/"+ irs.scan_irs);
    }
    
    if(khs == ""){
      $(".btn-khs").addClass("disabled");
    }else{
      $(".btn-khs").removeClass("disabled");
      $(".sks-khs").html(khs.sks);
      $(".ips-khs").html(khs.ips);
      $(".link-scan-khs").html("scanKHS" + smt + ".pdf");
      $(".link-scan-khs").attr("href", "/scan-khs/"+ khs.scan_khs);
    }
    
    if(pkl == ""){
      $(".btn-pkl").addClass("disabled");
    }else{
      $(".btn-pkl").removeClass("disabled");
    }
    
    if(skripsi == ""){
      $(".btn-skripsi").addClass("disabled");
    }else{
      $(".btn-skripsi").removeClass("disabled");
    }
    
    // console.log(skripsi);
    console.log(pkl);

    // console.log($(".data-smt").data('smt'))

    // Set the data in the modal
    // $('#modalLabel').text("Edit IRS Semester " + smt);

    // if (typeof scanirs === 'undefined') {
    //   scanirs = null;
    //   linkpdf.css("margin-bottom", "initial");
    //   linkpdf.text(null);
    // }else{
    //   linkpdf.text("scan-irs-" + smt + ".pdf");
    //   linkpdf.css("margin-bottom", "10px");
    // }

    // linkpdf.attr("href", "/scan-irs/" + (scanirs));
    // $('#scan_irs_old').val(scanirs);

    // console.log(scanirs);

    // document.getElementById("smt").value = smt;
    // document.getElementById("inputsks").value = sks;
  });

});