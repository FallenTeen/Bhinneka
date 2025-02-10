import "./bootstrap";

Livewire.on("refreshCaptcha", () => {
    fetch("/captcha/refresh")
        .then((response) => response.json())
        .then((data) => {
            document.querySelector('img[wire:model="captcha"]').src =
                data.captcha;
        });
});

//Scroll Sooth : scroll-link
document.querySelectorAll(".scroll-link").forEach((link) => {
    link.addEventListener("click", function (e) {
        e.preventDefault();

        const targetId = this.getAttribute("href").substring(1);
        const targetElement = document.getElementById(targetId);

        if (targetElement) {
            smoothScrollTo(targetElement, 1800);
        }
    });
});

function smoothScrollTo(target, duration) {
    const startPosition = window.scrollY;
    const targetPosition =
        target.getBoundingClientRect().top + window.scrollY - 12;
    const startTime = performance.now();

    function easeInOutQuad(t) {
        return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
    }

    function animation(currentTime) {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / duration, 1);
        const easedProgress = easeInOutQuad(progress);

        window.scrollTo(
            0,
            startPosition + (targetPosition - startPosition) * easedProgress
        );

        if (elapsedTime < duration) {
            requestAnimationFrame(animation);
        }
    }

    requestAnimationFrame(animation);
}

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
