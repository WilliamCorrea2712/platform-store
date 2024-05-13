$(document).ready(function () {
    $(".category-link").mouseenter(function () {
        var categoryId = $(this).data("category-id");
        loadSubcategories(categoryId);
    });

    $(".category-link").mouseleave(function () {
        $("#subcategories-dropdown").hide();
    });

    function loadSubcategories(categoryId) {
        $.ajax({
            url: "/getSubcategories/" + categoryId,
            type: "GET",
            data: { categoryId: categoryId },
            success: function (response) {
                var subcategories = response.subcategories;
                if (subcategories && subcategories.length > 0) {
                    var subcategoriesHtml =
                        '<div class="dropdown-subcategories">';
                    subcategories.forEach(function (subcategory) {
                        subcategoriesHtml +=
                            '<a class="dropdown-item" href="' +
                            subcategory.url +
                            '">' +
                            subcategory.name +
                            "</a>";
                    });
                    subcategoriesHtml += "</div>";
                    $("#subcategories-dropdown").html(subcategoriesHtml).show();
                } else {
                    $("#subcategories-dropdown").hide();
                }
            },
            error: function (xhr, status, error) {
                var errorMessage =
                    xhr.responseJSON && xhr.responseJSON.error
                        ? xhr.responseJSON.error
                        : error;
                console.log(errorMessage);
            },
        });
    }
});
