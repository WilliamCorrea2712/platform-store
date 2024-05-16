$(document).ready(function () {
    $(".container").on("click", ".submit-form", function () {
        var formId = $(this).data("form-id");
        document.getElementById(formId).submit();
    });
});

$(".container").on("click", ".btn-edit-customer", function () {
    var id = $(this).data("customer-id");
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    var name = $("#name").val();
    var email = $("#email").val();
    var phoneNumber = $("#phone_number").val();
    var birthDate = $("#birth_date").val();
    var cnpjCpf = $("#cnpj_cpf").val();
    var rgIe = $("#rg_ie").val();
    var typePerson = $("#type_person").val();
    var sex = $("#sex").val();

    if (id) {
        $.ajax({
            url: "/editCustomer/" + id,
            type: "POST",
            data: {
                _token: csrfToken,
                name: name,
                email: email,
                phone_number: phoneNumber,
                cnpj_cpf: cnpjCpf,
                birth_date: birthDate,
                rg_ie: rgIe,
                type_person: typePerson,
                sex: sex,
            },
            success: function (response) {
                $("#message-info").text("Dados alterados com sucesso!").show();

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

$(".container").on("click", ".btn-edit-password", function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    var password = $("#password").val();
    var confirmPassword = $("#confirmPassword").val();

    $.ajax({
        url: "/editPassword",
        type: "POST",
        data: {
            _token: csrfToken,
            password: password,
            confirmPassword: confirmPassword,
        },
        success: function (response) {
            $("#message-info").text("Senha alterada com sucesso!").show();

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
});
