const headerToggle = document.querySelector(".header_toggle");
const navbar = document.querySelector(".l-navbar");

headerToggle.addEventListener("click", () => {
  navbar.classList.toggle("show");
});
