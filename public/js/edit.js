$(document).ready(function () {
    $(".container").on("click", ".submit-form", function () {
        var formId = $(this).data("form-id");
        document.getElementById(formId).submit();
    });
});
