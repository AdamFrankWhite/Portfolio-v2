const burgerMenu = document.getElementById("burger-menu");
const sideMenu = document.getElementById("side-menu");

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
