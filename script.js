const burgerMenu = document.getElementById("burger-menu");
const sideMenu = document.getElementById("side-menu");

burgerMenu.addEventListener("click", () => {
    burgerMenu.classList.toggle("is-active");
    sideMenu.style.width == "100%"
        ? (sideMenu.style.width = 0)
        : (sideMenu.style.width = "100%");
});
