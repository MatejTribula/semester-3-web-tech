// Account popup toggle
const accountPopup = document.getElementById("accountPopup");
const pfp = document.querySelector(".pfp");

pfp?.addEventListener("click", () => {
  accountPopup.style.display =
    accountPopup.style.display === "flex" ? "none" : "flex";
});


// Mobile menu toggle
const mobileMenuBarTrigger = document.getElementById("mobileMenuBarTrigger");
const mobileMenu = document.querySelector(".mobile-menu");

mobileMenuBarTrigger?.addEventListener("click", () => {
  mobileMenu.style.display =
    mobileMenu.style.display === "flex" ? "none" : "flex";
});
