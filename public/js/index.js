 const accountPopup = document.getElementById("accountPopup");
const pfp = document.querySelector(".pfp");

pfp.addEventListener("click", () => {
  accountPopup.style.display = accountPopup.style.display === "block" ? "none" : "block";
});


const mobileMenuBarTrigger = document.getElementById("mobileMenuBarTrigger");
const mobileMenu = document.querySelector(".mobile-menu");
mobileMenuBarTrigger.addEventListener("click", () => {
  mobileMenu.style.display = mobileMenu.style.display === "flex" ? "none" : "flex";
});