$(function () {
   'use strict';

    // Input Mask
    $('#desCPF').inputmask("999.999.999-99");

   // Validar Formulário
    $('#frmLocator').validate({
        rules: {
           desName: "required",
           idNation: "required",
           idMaritalStatus: "required",
           desProfession: "required",
           desRG: "required",
           desCPF: "required"
        },
        messages: {
            desName: "Informe o Nome.",
            idNation: "Informe a Nacionalidade.",
            idMaritalStatus: "Informe o Estado Civil",
            desProfession: "Informe a Profissão",
            desRG: "Informe o RG",
            desCPF: "Informe o CPF"
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
            $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
            $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
        }
    });
});