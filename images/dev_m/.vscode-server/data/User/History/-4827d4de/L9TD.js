function openWhatsApp() {
    var name = $("#name-whats").val();
    var email = $("#email-whats").val();
    var msg = "Olá!";
    if (name != "") {
        msg += " Meu nome é " + name;
        if (email != "") {
            msg += " e meu e-mail é " + email;
        }
    } else if (email != "") {
        msg += "Meu e-mail é " + email;
    }
    msg += ". Vi o seu site e gostaria de mais informações!";
    phone = "55" + $("#user_whatsapp").val();
    console.log(msg);
    window.open(
        `https://api.whatsapp.com/send?phone=${phone}&text=${msg}`,
        "_blank"
    );
    $("#modal").modal("hide");
}

function submitWhatsAppForm() {
    openWhatsApp();

    var data = {};
    var msg = "";
    data.name = $("#name-whats").val();
    data.email = $("#email-whats").val();
    data.mobile = $("#mobile-whats").val();
    data.notes = "";
    data.user_id = $("#user_id").val();

    $("#name-contact").val(data.name);
    $("#email-contact").val(data.email);
    $("#mobile-contact").val(data.mobile);

    data.successMessage = "";

    saveLead(data, msg);
}

function submitModalForm() {
    var data = {};
    var msg = "";
    data.name = $("#name-modal").val();
    data.email = $("#email-modal").val();
    data.mobile = $("#mobile-modal").val();
    data.notes = "";
    data.user_id = $("#user_id").val();

    $("#name-contact").val(data.name);
    $("#email-contact").val(data.email);
    $("#mobile-contact").val(data.mobile);

    $("#name-whats").val(data.name);
    $("#email-whats").val(data.email);
    $("#mobile-whats").val(data.mobile);

    $("#modal-submit").html(
        '<i class="fa-solid fa-spinner fa-spin"></i> Enviando'
    );

    data.successMessage = "Inscrição Realizada com Sucesso!";

    saveLead(data, msg);
}

function submitContactForm() {
    var data = {};
    var msg = "";
    data.name = $("#name-contact").val();
    data.email = $("#email-contact").val();
    data.mobile = $("#mobile-contact").val();
    data.notes = $("#notes-contact").val();
    // data.user_id = $("#user_id").val();
    data.studio_id = $("#studio_id").val();

    $("#name-whats").val(data.name);
    $("#email-whats").val(data.email);
    $("#mobile-whats").val(data.mobile);

    $("#form-submit").html(
        '<i class="fa-solid fa-spinner fa-spin"></i> Enviando'
    );

    data.successMessage = "Mensagem Enviada com Sucesso!";

    saveLead(data, msg);
}

function saveLead(data, msg) {
    if ($("#campaign_id").val() != 0) {
        data.campaign_id = $("#campaign_id").val();
    }
    data.origin = $("#origin").val();

    //console.log(data);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "post",
        url: "/studios/leads/save",

        data: data,
        success: function (res) {
            if (res.message) {
                $.notify(
                    {
                        message: res.message,
                    },
                    {
                        type: res.alert_type,
                        delay: 2000,
                    }
                );
            }

            $("#form-submit").html(
                '<i class="fa fa-paper-plane"></i> Enviar Mensagem'
            );
            $("#modal-submit").html(
                '<i class="fa fa-paper-plane"></i> Enviar Mensagem'
            );
            $("#modalLogin").modal().hide();
            $(".modal-backdrop").hide();

            $("#contact-form").slideUp(500, function () {
                $("#contact-form").parent().html("<h4>Mensagem enviada</h4>");
            });
        },
        error: function (data) {
            $("#form-submit").html(
                '<i class="fa fa-paper-plane"></i> Enviar Mensagem'
            );
            $("#modal-submit").html(
                '<i class="fa fa-paper-plane"></i> Enviar Mensagem'
            );
            $("#modalLogin").modal().hide();
            $(".modal-backdrop").hide();

            $.notify(
                {
                    message: "Falha ao Enviar",
                },
                {
                    type: "danger",
                    delay: 2000,
                }
            );
        },
    });
}

// $.notify({
//     message: "Fallha ao Enviar",
// }, {
//     type: "danger",
//     delay: 20000,
// });
