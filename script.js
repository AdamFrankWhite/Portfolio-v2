const burgerMenu = document.getElementById("burger-menu");
const sideMenu = document.getElementById("side-menu");
const header = document.getElementsByTagName("header")[0];
const heroContainer = document.getElementsByClassName("hero-cont")[0];
burgerMenu.addEventListener("click", () => {
    burgerMenu.classList.toggle("is-active");
    if (sideMenu.style.width == "100%") {
        sideMenu.style.width = 0;
        document.body.style.overflow = "auto";
    } else {
        sideMenu.style.width = "100%";
        document.body.style.overflow = "hidden";
    }
});

// Sticky header
const sentinelEl = document.getElementById("sentinel");
const stuckClass = "fixed";

const handler = (entries) => {
    if (header) {
        if (!entries[0].isIntersecting) {
            header.classList.add(stuckClass, "slide-down");
            heroContainer.classList.add("pt"); // padding to avoid body jumping up
        }
    }
};
let options = {
    rootMargin: "100px",
};
const observer = new window.IntersectionObserver(handler, options);
observer.observe(sentinelEl);
