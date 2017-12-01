$(function() {
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
        language: "pt-BR",
        placeholder: "Selecione"
    });

    // Input Mask
    $('#desCPF').inputmask("999.999.999-99");
});