$(document).ready(function () {
    $(".container").on("click", ".submit-form", function () {
        var formId = $(this).data("form-id");
        document.getElementById(formId).submit();
    });
});

$(".container").on("click", ".btn-save-config", function () {
    var Id = $(this).data("setting-id");
    var value = $(this).closest("tr").find(".setting-value").val();
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    if (Id) {
        $.ajax({
            url: "/config/editSetting",
            type: "POST",
            data: {
                _token: csrfToken,
                _method: "PATCH",
                setting_id: Id,
                value: value,
            },
            success: function (response) {
                $("#message-info")
                    .text("Configuração alterada com sucesso")
                    .show();

                setTimeout(function () {
                    $("#message-info").fadeOut();
                }, 2000);
            },
            error: function (xhr, status, error) {
                var errorMessage =
                    xhr.responseJSON && xhr.responseJSON.error
                        ? xhr.responseJSON.error
                        : error;
                $("#message-info").text(errorMessage).show();
            },
        });
    }
});
