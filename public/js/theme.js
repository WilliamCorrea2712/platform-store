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

document.addEventListener("DOMContentLoaded", function () {
    function showSection(sectionId) {
        document
            .querySelectorAll(".content-section")
            .forEach(function (section) {
                section.style.display = "none";
            });
        document.querySelector(sectionId).style.display = "block";

        document.querySelectorAll(".list-group-item").forEach(function (link) {
            link.classList.remove("active");
        });
        document
            .querySelector('a[href="' + sectionId + '"]')
            .classList.add("active");
    }

    function handleHashChange() {
        const hash = window.location.hash || "#my-account";
        showSection(hash);
    }

    function handleTabParam() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get("tab");
        if (tab) {
            showSection(`#${tab}`);
            history.replaceState(null, null, `#${tab}`);
        } else {
            handleHashChange();
        }
    }

    document.querySelectorAll(".list-group-item").forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const target = this.getAttribute("href");
            history.pushState(null, null, target);
            showSection(target);
        });
    });

    window.addEventListener("hashchange", handleHashChange);
    handleTabParam();
});
