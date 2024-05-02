function toggleTheme() {
    var body = document.body;
    var themeToggle = document.getElementById("theme-toggle");
    var currentTheme = body.classList.contains("dark-theme") ? "dark" : "light";

    if (currentTheme === "dark") {
        body.classList.remove("dark-theme");
        themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        localStorage.setItem("themePreference", "light");
    } else {
        body.classList.add("dark-theme");
        themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        localStorage.setItem("themePreference", "dark");
    }
}

document.getElementById("theme-toggle").addEventListener("click", function () {
    toggleTheme();
});

document.addEventListener("DOMContentLoaded", function () {
    var currentTheme = localStorage.getItem("themePreference");

    if (currentTheme === "dark") {
        document.body.classList.add("dark-theme");
        document.getElementById("theme-toggle").innerHTML =
            '<i class="fas fa-sun"></i>';
    }
});

function goBack() {
    window.history.back();
}

document.addEventListener("DOMContentLoaded", function () {
    const addSettingButton = document.querySelector("#addSettingButton");
    const addSettingDiv = document.querySelector("#addSettingDiv");

    addSettingButton.addEventListener("click", function () {
        if (addSettingDiv.style.display === "none") {
            addSettingDiv.style.display = "block";
        } else {
            addSettingDiv.style.display = "none";
        }
    });
});

$(document).ready(function () {
    $(".setting-value").on("input", function () {
        var settingId = $(this)
            .closest("tr")
            .find(".btn-edit")
            .data("setting-id");
        $(this).closest("tr").find(".btn-edit").addClass("d-none");
        $(this).closest("tr").find(".btn-save-config").removeClass("d-none");
    });
});
