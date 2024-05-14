function changeMainImage(imagePath) {
    document.getElementById("mainImage").src = imagePath;
}

$(document).ready(function () {
    $(".stock-option").click(function () {
        var subOptions = $(this).next(".sub-options");
        if (subOptions.is(":visible")) {
            subOptions.hide();
        } else {
            $(".sub-options").hide();
            subOptions.show();
        }
    });
});
