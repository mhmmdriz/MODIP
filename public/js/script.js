var theme = document.getElementById("theme");
const body = document.body;

let darkTheme = localStorage.getItem('dark-theme');

const enableDarkTheme = () => {
  body.setAttribute("data-bs-theme", "dark")
  theme.className = "bi bi-moon-stars-fill";
  localStorage.setItem('dark-theme', 'enabled');
}

const disableDarkTheme = () => {
  body.setAttribute("data-bs-theme", "light")
  theme.className = "bi bi-sun-fill";
  localStorage.setItem('dark-theme', 'disabled');
}

theme.addEventListener("click", () => {
  darkTheme = localStorage.getItem('dark-theme'); //setiap click, update value
  if (darkTheme === 'disabled') {
    enableDarkTheme();
  } else {
    disableDarkTheme();
  }
})

if (darkTheme === 'enabled') { //setiap reload
  enableDarkTheme();
}
else {
  disableDarkTheme();
}

// AJAX Search Akun_MHS milik Operator
function updateMhsTable(keyword){
  $.ajax({
    type: 'GET',
    url: '/ajaxAkunMHS',
    data: {'keyword':keyword},
    success: function(response) {
      $('#tabelMHS').html(response.html);
      console.log(response.message);
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

function updateTableProgressMHS(){
  let keyword = document.getElementById("keyword").value;
  let angkatan = document.getElementById("angkatan").value;
  
  // console.log(keyword);
  // console.log(angkatan);
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
  
  // console.log(keyword);
  // console.log(angkatan);
  $.ajax({
    type: 'GET',
    url: '/ajaxProgressMHSPerwalian',
    data: {'keyword':keyword, 'angkatan':angkatan},
    success: function(response) {
      $('#tabelMHS').html(response.html);
      console.log(response.message);
    },
    error: function(response) {
      console.log('Error:', response);
    }
  });
}

