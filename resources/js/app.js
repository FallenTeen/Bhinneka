import './bootstrap';



//FUNGSI TOGGLE MENU LANDING-PAGE-NAVBAR MOBILE
document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const menu = document.getElementById("mobile-menu-2");
    const menuIcon = document.getElementById("menu-icon");
    const closeIcon = document.getElementById("close-icon");

    menuToggle.addEventListener("click", function () {
        menu.classList.toggle("hidden");
        menuIcon.classList.toggle("hidden");
        closeIcon.classList.toggle("hidden");
    });
});