function updateTableProgressMHS(){
    let keyword = document.getElementById("keyword").value;
    let angkatan = document.getElementById("angkatan").value;

    $.ajax({
        type: 'GET',
        url: '/ajaxProgressMHS',
        data: {'keyword':keyword, 'angkatan':angkatan},
        success: function(response) {
            $('#tabelMHS').html(response.html);
            // console.log(response.message);
        },
        error: function(response) {
            console.log('Error:', response);
        }
    });
}

function updateTableProgressMHSPerwalian(){
    let keyword = document.getElementById("keyword").value;
    let angkatan = document.getElementById("angkatan").value;

    $.ajax({
        type: 'GET',
        url: '/ajaxProgressMHSPerwalian',
        data: {'keyword':keyword, 'angkatan':angkatan},
        success: function(response) {
            $('#tabelMHS').html(response.html);
            // console.log(response.message);
        },
            error: function(response) {
            console.log('Error:', response);
        }
    });
}


// AJAX Search Akun_MHS milik Operator
function updateMhsTable(keyword){
    $.ajax({
        type: 'GET',
        url: '/ajaxAkunMHS',
        data: {'keyword':keyword},
        success: function(response) {
            $('#tabelMHS').html(response.html);
            // console.log(response.message);
        },
            error: function(response) {
            console.log('Error:', response);
        }
    });
}

function updateDoswalTable(keyword){
    $.ajax({
        type: 'GET',
        url: '/ajaxAkunDoswal',
        data: {'keyword':keyword},
        success: function(response) {
            $('#tabelDoswal').html(response.html);
            // console.log(response.html);
        },
        error: function(response) {
            console.log('Error:', response);
        }
    });
}