document.addEventListener("DOMContentLoaded", function () {
    var menuLinks = document.querySelectorAll(".list-group-item");
    menuLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            var targetId = this.getAttribute("href");
            var targetSection = document.querySelector(targetId);
            var allSections = document.querySelectorAll(".content-section");
            var allMenuLinks = document.querySelectorAll(".list-group-item");
            allSections.forEach(function (section) {
                section.style.display = "none";
            });
            allMenuLinks.forEach(function (menuLink) {
                menuLink.classList.remove("active");
            });
            if (targetSection) {
                targetSection.style.display = "block";
                this.classList.add("active");
            }
        });
    });
});
