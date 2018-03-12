$(function () {
    'use strict';

    var fined = null;
    var interest = null;
    var amount = null;
    var valueDay =  null;
    var dateStart = null;

    // Retorna os descontos e aplica os valores de multa, juros e total
    var searchPortions = function (id) {
        if ($.isNumeric(id)) {
            $.ajax({
                type: 'GET',
                url: '/receipt/consulting/contract/' + id,
                dataType: 'json',
                success: function(result) {
                    if (result != null) {
                        var addGroup = null;
                        var addOption = null;
                        var valueMoney = null;
                        $.each(result[0], function (i, item) {
                            $.each(item, function (y, index) {
                                valueMoney = "R$ " + Number(index.portionsValue).toFixed(2).replace(',', '').replace('.', ',');
                                if (index.desPayment === "Y") {
                                    addOption += '<option value='+index.portionsId+' title="Pago" disabled>'+valueMoney+'</option>';
                                } else {
                                    addOption += '<option value='+index.portionsId+' title="Pendente">'+valueMoney+'</option>';
                                }
                            });
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
                        amount = parseFloat(result[3]);
                        dateStart = result[5];
                        valueDay = parseFloat(result[4]);

                        $('#desFined').val((fined > 0.00) ? "R$ " + Number(fined).toFixed(2).replace(',', '').replace('.', ',') : null);
                        $('#desInterest').val((interest > 0.00) ? "R$ " + Number(interest).toFixed(2).replace(',', '').replace('.', ',') : null);
                        $('#desValue').val("R$ " + Number(parseFloat(fined) + parseFloat(interest) + parseFloat(value)).toFixed(2).replace(',', '').replace('.', ','));

                        $('#desMonth').data('daterangepicker').setStartDate(moment(dateStart, "DD/MM/YYYY"));
                        $('#desMonth').data('daterangepicker').setEndDate(moment(dateStart, "DD/MM/YYYY").add(1, "month"));

                        if (typeof($('#optRecovered')) !== "undefined") {
                            selectPortions($('#optRecovered').val());
                        }
                    }
                },
                error: function() {
                    cleanForm();
                }
            });
        } else {
            cleanForm();
        }
    };

    // Seleciona as Parcelas
    var selectPortions = function (value) {
        if (value.indexOf(",") != -1) {
            var value = value.split(",");
            $('#desPortions').val(value).trigger("change");
        } else {
            $('#desPortions').val(value).trigger("change");
        }
    };

    // Calcula o total do Recibo
    var calcTotal = function () {
        var desFined = (cleanFormat($('#desFined').val()) !== "") ? cleanFormat($('#desFined').val()) : "0";
        var desInterest = (cleanFormat($('#desInterest').val()) !== "") ? cleanFormat($('#desInterest').val()) : "0";
        var optPortions = $('#desPortions option:selected').text().split('R$ ');
        var optValues = null;
        var desValue = null;

        $.each(optPortions, function (key, value) {
            if (value != "") {
                optValues += parseFloat(value);
            }
        });

        if (optValues != null) {
            desValue = (parseFloat(amount) + parseFloat(desFined) + parseFloat(desInterest)) - parseFloat(optValues);
            optValues = null;
        } else {
            desValue = parseFloat(amount) + parseFloat(desFined) + parseFloat(desInterest);
        }

        $('#desValue').val("R$ " + Number(desValue).toFixed(2).replace(',','').replace('.',','));
        desValue = null;

    };

    // Limpar Formulário
    var cleanForm = function () {
        $('#desPortions').attr('disabled', 'disabled').find('optgroup, option').remove();
        $('#desFined').val("");
        $('#desInterest').val("");
        $('#desValue').val("");
    };

    // Limpar Formato Monetário
    var cleanFormat = function (value) {
        return value = value.replace('R$ ','').replace(',','.');
    };

    // Atualiza valor total se alterado os descontos
    $('#idContract').change(function() {
        if ($.isNumeric($(this).val())) {
            searchPortions($(this).val());
        } else {
            cleanForm();
        }
    });

    // Verifica no carregamento se existe algum contrato selecionado
    $('#idContract').find('option:selected').each(function () {
        if ($.isNumeric($(this).val())) {
            searchPortions($(this).val());
        } else {
            cleanForm();
        }
    });

    // Atualiza o valor total se alterado a multa
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

    // Atualiza o valor total se alterado os juros
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

    // Faz o loop dos descontos selecionados
    $('#desPortions').change(function () {
        calcTotal();
    });

    // Calcular a diferença de dias selecionados
    $('#desMonth').on('apply.daterangepicker', function (ev, picker) {
        var dtInitial = moment(picker.startDate,"YYY-MM-DD");
        var dtFinal = moment(picker.endDate,"YYY-MM-DD");
        var dtDiff = dtFinal.diff(dtInitial, "days");

        // Se a variavel valueDay for maior que zero, altera a variavel value
        if (valueDay > 0) {
            value = valueDay * dtDiff;
            calcTotal();
        }
    });

    // Date Ranger Picker

    $('#desMonth').daterangepicker({
        locale: {
            direction: "ltr",
            format: "DD/MM/YYYY",
            separator: " - ",
            applyLabel: "Aplicar",
            cancelLabel: "Cancelar",
            fromLabel: "De",
            toLabel: "Até",
            customRangeLabel: "Personalizar",
            daysOfWeek: [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sab"
            ],
            monthNames: [
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
            firstDay: 1
        },
        startDate: moment(),
        endDate: moment().add(30, "days"),
        opens: "center"
    });

    // Input Mask
    $(".money").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });
});