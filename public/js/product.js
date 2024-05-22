function changeMainImage(imagePath) {
    document.getElementById("mainImage").src = imagePath;
}

$(document).ready(function () {
    $(".stock-option").click(function () {
        $(".stock-option").removeClass("selected");
        $(".sub-option").removeClass("selected-sub");

        $(this).addClass("selected");
        var subOptions = $(this).next(".sub-options");
        if (subOptions.is(":visible")) {
            subOptions.hide();
        } else {
            $(".sub-options").hide();
            subOptions.show();
        }
    });

    $(".sub-option").click(function () {
        $(".sub-option").removeClass("selected-sub");
        $(this).addClass("selected-sub");

        var stockId = $(this).data("stock-id");
        var attributeId = $(this).data("attribute-id");
        $("#selectedId").val(stockId);
        $("#selectedAttributeId").val(attributeId);
    });

    $("#addToCartForm").submit(function (event) {
        event.preventDefault();

        if (
            $("#selectedId").val() !== "" &&
            $("#selectedAttributeId").val() !== ""
        ) {
            $(this).unbind("submit").submit();
        } else {
            alert("Por favor, selecione uma opção de estoque.");
        }
    });
});
