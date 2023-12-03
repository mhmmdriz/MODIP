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

$("body").on("submit", "form", function() {
  $(this).submit(function() {
      return false;
  });
  return true;
});

function printRekap() {
    // Dapatkan formulir dan data formulir
    var form = document.getElementById('printForm');
    var formData = new FormData(form);

    // Buat objek XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Konfigurasikan permintaan AJAX
    xhr.open('POST', form.action, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', formData.get('_token'));

    // Atur penanganan kejadian ketika permintaan selesai
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Jika permintaan berhasil, buka jendela baru untuk mencetak
            var newWindow = window.open('', '_blank');
            newWindow.document.write(xhr.responseText);
            // newWindow.print();
            newWindow.onafterprint = function () {
                newWindow.close();
            };
        }
    };

    // Kirim permintaan AJAX
    xhr.send(formData);
}

function printList() {
  // Dapatkan formulir dan data formulir
  var form = document.getElementById('printList');
  var formData = new FormData(form);

  // Buat objek XMLHttpRequest
  var xhr = new XMLHttpRequest();

  // Konfigurasikan permintaan AJAX
  xhr.open('POST', form.action, true);
  xhr.setRequestHeader('X-CSRF-TOKEN', formData.get('_token'));

  // Atur penanganan kejadian ketika permintaan selesai
  xhr.onload = function () {
      if (xhr.status === 200) {
          // Jika permintaan berhasil, buka jendela baru untuk mencetak
          var newWindow = window.open('', '_blank');
          newWindow.document.write(xhr.responseText);
          // newWindow.print();
          newWindow.onafterprint = function () {
              newWindow.close();
          };
      }
  };

  // Kirim permintaan AJAX
  xhr.send(formData);
}
