$(document).ready(function () {
    $(".subcategories").hide();
    $(".category-container").mouseenter(function () {
        var subcategories = $(this).find(".subcategories");
        $(".subcategories").not(subcategories).slideUp();
        subcategories.slideDown();
    });
});
