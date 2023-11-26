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


