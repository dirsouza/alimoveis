$(function () {
   'use strict';

    // Select 2
    $('.select').select();

    // Input Mask
    $("#desValue").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });

   // Validar Formulário
    $('#frmDiscount').validate({
        rules: {
            desDescription: "required",
            idContract: "required",
            desValue: "required",
            desPortion: "required"
        },
        messages: {
            desDescription: "Informe a Descrição.",
            idContract: "Informe o Contrato.",
            desValue: "Informe o Valor.",
            desPortion: "Info. Parc."
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
            $(element).parents(".col-md-1").addClass("has-error").removeClass("has-success");
            $(element).parents(".col-md-2").addClass("has-error").removeClass("has-success");
            $(element).parents(".col-md-3").addClass("has-error").removeClass("has-success");
            $(element).parents(".col-md-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-md-1").addClass("has-success").removeClass("has-error");
            $(element).parents(".col-md-2").addClass("has-success").removeClass("has-error");
            $(element).parents(".col-md-3").addClass("has-success").removeClass("has-error");
            $(element).parents(".col-md-6").addClass("has-success").removeClass("has-error");
        }
    });
});