var theme = document.getElementById("theme");
const body = document.querySelector("body");

theme.addEventListener("click", () =>{
  body.classList.toggle("dark");
  
  if(body.classList.contains("dark")){
    body.setAttribute("data-bs-theme", "dark")
    theme.className = "bi bi-moon-stars-fill";
  }else{
    body.setAttribute("data-bs-theme", "light")
    theme.className = "bi bi-sun-fill";
  }
})