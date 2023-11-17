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
      $(".btn-irs").removeAttr("disabled");
    }else{
      $(".btn-irs").removeClass("disabled");
      if (irs.validasi == 0) {
        $(".btn-irs").attr("disabled", true);
      } else {
        $(".btn-irs").removeAttr("disabled");
      }
      $(".sks-irs").html(irs.sks);
      $(".link-scan-irs").html("scanIRS" + smt + ".pdf");
      $(".link-scan-irs").attr("href", "/scan-irs/"+ irs.scan_irs);
    }
    
    if(khs == ""){
      $(".btn-khs").addClass("disabled");
      $(".btn-khs").removeAttr("disabled");
    }else{
      $(".btn-khs").removeClass("disabled");
      if (khs.validasi == 0) {
        $(".btn-khs").attr("disabled", true);
      } else {
        $(".btn-khs").removeAttr("disabled");
      }
      $(".sks-khs").html(khs.sks);
      $(".ips-khs").html(khs.ips);
      $(".link-scan-khs").html("scanKHS" + smt + ".pdf");
      $(".link-scan-khs").attr("href", "/scan-khs/"+ khs.scan_khs);
    }
    
    if(pkl == "" || pkl.semester != smt){
      $(".btn-pkl").attr("hidden", "");
    }else{
      $(".btn-pkl").removeAttr("hidden");
      $(".btn-pkl").removeClass("disabled");
      $(".semester-pkl").html(pkl.semester);
      $(".status-pkl").html(pkl.status);
      $(".tanggal-seminar-pkl").html(pkl.tanggal_lulus);
      $(".nilai-pkl").html(pkl.nilai);
      $(".link-scan-pkl").html("scanPKL.pdf");
      $(".link-scan-pkl").attr("href", "/scan-pkl/"+ pkl.scan_basp)
    }
    
    if(skripsi == "" || skripsi.semester != smt){
      $(".btn-skripsi").attr("hidden", "");
    }else{
      $(".btn-skripsi").removeAttr("hidden");
      $(".btn-skripsi").removeClass("disabled");
      $(".semester-skripsi").html(skripsi.semester);
      $(".status-skripsi").html(skripsi.status);
      $(".tanggal-sidang-skripsi").html(skripsi.tanggal_sidang);
      $(".tanggal-lulus-skripsi").html(skripsi.tanggal_lulus);
      $(".nilai-skripsi").html(skripsi.nilai);
      $(".link-scan-skripsi").html("scanSkripsi.pdf");
      $(".link-scan-skripsi").attr("href", "/scan-skripsi/"+ skripsi.scan_bass);
    }

  });

});