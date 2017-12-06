$(function () {
   'use strict';

    // Input Mask
    $('#desZipCode').inputmask("99999-999");

    // Buscar Endereço pelo CEP
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#desAddress").val("");
        $("#desDistrict").val("");
        $("#desCity").val("");
        $("#desState").val("");
    }

    //Quando o campo cep perde o foco.
    $("#desZipCode").blur(function() {
        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');
        //Verifica se campo cep possui valor informado.
        if (cep != "") {
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                //Preenche os campos com "..." enquanto consulta webservice.
                $("#desAddress").val("...");
                $("#desDistrict").val("...");
                $("#desCity").val("...");
                $("#desState").val("...");
                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#desAddress").val(dados.logradouro);
                        $("#desDistrict").val(dados.bairro);
                        $("#desCity").val(dados.localidade);
                        $("#desState").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });

    // Validar Formulário
    $('#frmImmobile').validate({
        rules: {
            desDescription: "required",
            desZipCode: "required",
            desAddress: "required",
            desDistrict: "required",
            desCity: "required",
            desState: "required"
        },
        messages: {
            desDescription: "Informe a descrição do imóvel.",
            desZipCode: "Informe o CEP.",
            desAddress: "Informe o endereço.",
            desDistrict: "Informe o bairro.",
            desCity: "Informe a Cidade.",
            desState: "Info. a UF."
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