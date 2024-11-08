function initializeSelect2(selector) {
    $(selector).select2({
        width: '100%',
    });
}

$(document).ready(function () {
    $('.select2').select2({
        width: '100%',
        language: 'pl'
    });
});