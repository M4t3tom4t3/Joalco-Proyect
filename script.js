const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
    console.log("Botón de hamburguesa clickeado");
    const sidebar = document.querySelector("#sidebar");
    sidebar.classList.toggle("expand");
    console.log(sidebar.classList);
});
