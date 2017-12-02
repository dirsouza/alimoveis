$(function () {
    'use strict';

    // DataTables
    $(dtables).DataTable({
        responsive: true,
        language: {
            url: '../../lib/plugins/datatables/language/pt-BR.json'
        }
    });

    // Select2
    $.fn.select2.defaults.set('amdLanguageBase', 'select2/i18n/');
    $('.select').select2({
        language: "pt-BR"
    });

    // Input Mask
    $('#desCPF').inputmask("999.999.999-99");

    // Close Alerts
    $('.close').on('click', function() {
        $('section#error-alert').remove();
    });

    // Message
    if ($('#msg').hasClass('message')) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        if ($('#msg').hasClass('insert-success')) {
            toastr.success("Registro inserido com sucesso!!!");
        } else if ($('#msg').hasClass('insert-error')) {
            toastr.error("Não foi possível inserir o registro.");
        } else if ($('#msg').hasClass('update-success')) {
            toastr.success("Registro atualizado com sucesso!!!");
        } else if ($('#msg').hasClass('update-info')) {
            toastr.warning("Não houveram atualizações no registro.");
        } else if ($('#msg').hasClass('delete-success')) {
            toastr.success("Registro deletado com sucesso!!!");
        } else if ($('#msg').hasClass('delete-error')) {
            toastr.error("Não foi possível excluir o registro.");
        }
    }
});