$(function () {
    'use strict';

    var fined = null;
    var interest = null;
    var value = null;

    $('#idContract').change(function() {
        $.ajax({
            type: 'GET',
            url: '/receipt/consulting/contract/' + $(this).val(),
            dataType: 'json',
            success: function(result) {
                if (result != null) {
                    var addGroup = null;
                    var addOption = null;
                    var valueMoney = null;
                    $.each(result[0], function (i, item) {
                        $.each(item, function (y, index) {
                            valueMoney = "R$ " + Number(index.portionsValue).toFixed(2).replace(',', '').replace('.', ',');
                            addOption += '<option value='+index.portionsId+'>'+valueMoney+'</option>';
                        })
                        addGroup += '<optgroup label="'+ item[i].discountDescription +'">'+addOption+'</optgroup>';
                        addOption = null;
                    });
                    if (addGroup != null) {
                        $('#desPortions').removeAttr('disabled').html(addGroup).show();
                    } else {
                        $('#desPortions').attr('disabled', 'disabled').find('optgroup, option').remove();
                    }

                    fined = (result[1] != null) ? parseFloat(result[1]) : Number("0").toFixed(2);
                    interest = (result[2] != null) ? parseFloat(result[2]) : Number("0").toFixed(2);
                    value = parseFloat(result[3]);

                    $('#desFined').val((fined > 0.00) ? "R$ " + Number(fined).toFixed(2).replace(',', '').replace('.', ',') : null);
                    $('#desInterest').val((interest > 0.00) ? "R$ " + Number(interest).toFixed(2).replace(',', '').replace('.', ',') : null);
                    $('#desValue').val("R$ " + Number(parseFloat(fined) + parseFloat(interest) + parseFloat(value)).toFixed(2).replace(',', '').replace('.', ','));
                }
            },
            error: function() {
                cleanForm();
            }
        });
    });

    $('#desFined').on('blur', function() {
        var desFined = parseFloat(cleanFormat($(this).val()));

        if (desFined > fined) {
            alert("O valor da Multa não pode ser superior ao aplicado.");

            if (fined > 0) {
                $(this).val("R$ " + Number(parseFloat(fined)).toFixed(2).replace(',', '').replace('.', ','));
            } else {
                $(this).val(null);
            }
        } else {
            calcTotal();
        }
    });

    $('#desInterest').on('blur', function() {
        var desInterest = parseFloat(cleanFormat($(this).val()));

        if (desInterest > interest) {
            alert("O valor dos Juros não pode ser superior ao aplicado.");

            if (interest > 0) {
                $(this).val("R$ " + Number(parseFloat(interest)).toFixed(2).replace(',', '').replace('.', ','));
            } else {
                $(this).val(null);
            }
        } else {
            calcTotal();
        }
    });

    $('#desPortions').change(function () {
        calcTotal();
    });

    var calcTotal = function () {
        var desFined = (cleanFormat($('#desFined').val()) !== "") ? cleanFormat($('#desFined').val()) : "0";
        var desInterest = (cleanFormat($('#desInterest').val()) !== "") ? cleanFormat($('#desInterest').val()) : "0";
        var optPortions = $('#desPortions option:selected').text().split('R$ ');
        var optValues = null;
        var desValue = null;
        
        $.each(optPortions, function (i, item) {
            if (item != "") {
                optValues += parseFloat(item);
            }
        });

        if (optValues != null) {
            desValue = parseFloat(value) + parseFloat(desFined) + parseFloat(desInterest) + parseFloat(optValues);
            optValues = null;
        } else {
            desValue = parseFloat(value) + parseFloat(desFined) + parseFloat(desInterest);
        }

        $('#desValue').val("R$ " + Number(desValue).toFixed(2).replace(',','').replace('.',','));
        desValue = null;
        
    };

    var cleanForm = function () {
        $('#desPortions').attr('disabled', 'disabled').find('optgroup, option').remove();
        $('#desFined').val("");
        $('#desInterest').val("");
        $('#desValue').val("");
    };

    var cleanFormat = function (value) {
        return value = value.replace('R$ ','').replace(',','.');
    };

    // Date Ranger Picker
   $('#desMonth').daterangepicker({
       "locale": {
           "direction": "ltr",
           "format": "DD/MM/YYYY",
           "separator": " - ",
           "applyLabel": "Aplicar",
           "cancelLabel": "Cancelar",
           "fromLabel": "De",
           "toLabel": "Até",
           "customRangeLabel": "Personalizar",
           "daysOfWeek": [
               "Dom",
               "Seg",
               "Ter",
               "Qua",
               "Qui",
               "Sex",
               "Sab"
           ],
           "monthNames": [
               "Janeiro",
               "Fevereiro",
               "Março",
               "Abril",
               "Maio",
               "Junho",
               "Julho",
               "Agosto",
               "Setembro",
               "Outubro",
               "Novembro",
               "Dezembro"
           ],
           "firstDay": 1
       },
       "startDate": moment(),
       "endDate": moment().add(30, 'days'),
       "opens": "center"
   });

    // Input Mask
    $(".money").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });

   // Validar Formulário
    $('#frmRenter').validate({
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