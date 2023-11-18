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
      if(irs.validasi == 1){
        $(".validasi-irs").addClass("text-success");
        $(".validasi-irs").html("Sudah divalidasi");
      }else{
        $(".validasi-irs").addClass("text-danger");
        $(".validasi-irs").html("Belum divalidasi");
      }
    }
    
    if(khs == ""){
      $(".btn-khs").addClass("disabled");
    }else{
      $(".btn-khs").removeClass("disabled");
      $(".sks-khs").html(khs.sks);
      $(".sksk-khs").html(khs.sksk);
      $(".ips-khs").html(khs.ips);
      $(".ipk-khs").html(khs.ipk);
      $(".link-scan-khs").html("scanKHS" + smt + ".pdf");
      $(".link-scan-khs").attr("href", "/scan-khs/"+ khs.scan_khs);
      if(khs.validasi == 1){
        $(".validasi-khs").addClass("text-success");
        $(".validasi-khs").html("Sudah divalidasi");
      }else{
        $(".validasi-khs").addClass("text-danger");
        $(".validasi-khs").html("Belum divalidasi");
      }
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
      $(".link-scan-pkl").attr("href", "/scan-pkl/"+ pkl.scan_basp);
      if(pkl.validasi == 1){
        $(".validasi-pkl").addClass("text-success");
        $(".validasi-pkl").html("Sudah divalidasi");
      }else{
        $(".validasi-pkl").addClass("text-danger");
        $(".validasi-pkl").html("Belum divalidasi");
      }
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
      if(skripsi.validasi == 1){
        $(".validasi-skripsi").addClass("text-success");
        $(".validasi-skripsi").html("Sudah divalidasi");
      }else{
        $(".validasi-skripsi").addClass("text-danger");
        $(".validasi-skripsi").html("Belum divalidasi");
      }
    }
    
    console.log(pkl);
  });

});