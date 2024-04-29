document.addEventListener("DOMContentLoaded", function () {
    const usersToggle = document.querySelector(".users-toggle");
    const productsToggle = document.querySelector(".products-toggle");
    const customersToggle = document.querySelector(".customers-toggle");
    const configToggle = document.querySelector(".config-toggle");

    const usersSubmenu = usersToggle.nextElementSibling;
    const productsSubmenu = productsToggle.nextElementSibling;
    const customersSubmenu = customersToggle.nextElementSibling;
    const configSubmenu = configToggle.nextElementSibling;

    usersSubmenu.style.display = "none";
    productsSubmenu.style.display = "none";
    customersSubmenu.style.display = "none";
    configSubmenu.style.display = "none";

    usersToggle.addEventListener("click", function (event) {
        event.preventDefault();
        toggleSubmenu(usersSubmenu);
        resetSelected();
        usersToggle.classList.add("selected");
    });

    productsToggle.addEventListener("click", function (event) {
        event.preventDefault();
        toggleSubmenu(productsSubmenu);
        resetSelected();
        productsToggle.classList.add("selected");
    });

    customersToggle.addEventListener("click", function (event) {
        event.preventDefault();
        toggleSubmenu(customersSubmenu);
        resetSelected();
        customersToggle.classList.add("selected");
    });

    configToggle.addEventListener("click", function (event) {
        event.preventDefault();
        toggleSubmenu(configSubmenu);
        resetSelected();
        configToggle.classList.add("selected");
    });

    function toggleSubmenu(submenu) {
        if (submenu.style.display === "none") {
            submenu.style.display = "block";
        } else {
            submenu.style.display = "none";
        }
    }

    function resetSelected() {
        const selectedLinks = document.querySelectorAll(".nav-link.selected");
        selectedLinks.forEach((link) => {
            link.classList.remove("selected");
        });
    }
});
