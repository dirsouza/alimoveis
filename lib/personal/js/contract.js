$(function () {
   'use strict';

    // Select 2
    $('.select').select();

    // Imputar data final
    $('#dtInitial').on('blur', function() {
        var date = moment($(this).val()).format('YYYY-MM-DD');
        date = moment(date).add($('#desDeadline').val(), 'month').format('L');
        $('#dtFinal').val(moment(date).format('YYYY-MM-DD'));
    });

    // Input Mask
    $("#desValue").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });

   // Validar Formulário
    $('#frmContract').validate({
        rules: {
            idLocator: "required",
            idRenter: "required",
            idImmobile: "required",
            desDeadline: "required",
            dtInitial: "required",
            dtFinal: "required",
            desValue: "required"
        },
        messages: {
            idLocator: "Informe o Locador.",
            idRenter: "Informe o Locatário.",
            idImmobile: "Informe o Imóvel.",
            desDeadline: "Info. Prazo.",
            dtInitial: "Informe a data Inicial.",
            dtFinal: "Informe a data Final.",
            desValue: "Informe o Valor."
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
            $(element).parents(".col-md-5").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-md-1").addClass("has-success").removeClass("has-error");
            $(element).parents(".col-md-2").addClass("has-success").removeClass("has-error");
            $(element).parents(".col-md-5").addClass("has-success").removeClass("has-error");
        }
    });
});