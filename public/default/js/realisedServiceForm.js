let usedPartsContainer = $(".usedPartsContainer");
let usedPartsLineItems = getCurrentNumOfLineItemsOfUsedPartsForm();

function addUsedPartForm() {
    let usedPartPrototypeForm = $("#realised_service_usedParts").data('prototype');
    usedPartPrototypeForm = usedPartPrototypeForm.replace('__name__label__', `<i class="fa fa-2x fa-minus-square remove-num-parts-row-button text-danger"></i>`);
    usedPartPrototypeForm = usedPartPrototypeForm.replace('realised_service_usedParts___name__', `realised_service_usedParts_${getCurrentNumOfLineItemsOfUsedPartsForm() + 1}`);
    usedPartPrototypeForm = usedPartPrototypeForm.replaceAll('realised_service_usedParts___name___usedPart', `realised_service_usedParts_${getCurrentNumOfLineItemsOfUsedPartsForm() + 1}`);
    usedPartPrototypeForm = usedPartPrototypeForm.replace('realised_service[usedParts][__name__][usedPart]', `realised_service[usedParts][${getCurrentNumOfLineItemsOfUsedPartsForm() + 1}][usedPart]`);
    usedPartPrototypeForm = usedPartPrototypeForm.replace('realised_service_usedParts___name___quantity', `realised_service_usedParts_${getCurrentNumOfLineItemsOfUsedPartsForm() + 1}_quantity`);
    usedPartPrototypeForm = usedPartPrototypeForm.replace('realised_service[usedParts][__name__][quantity]', `realised_service[usedParts][${getCurrentNumOfLineItemsOfUsedPartsForm() + 1}][quantity]`);
    let formItemString = `<div class="col-md-12 form">${usedPartPrototypeForm}</div>`;
    usedPartsContainer.append(formItemString);
    let divsWithFormGroup = $(`#realised_service_usedParts_${getCurrentNumOfLineItemsOfUsedPartsForm()}`).children('div');
    console.log(divsWithFormGroup);
    divsWithFormGroup.each(function () {
        $(this).addClass('form-group');
        let childsOfRow = $(this).children('input, select, textarea');
        childsOfRow.each(function () {
            $(this).addClass('form-control');
        });
    });
    getCurrentNumOfLineItemsOfUsedPartsForm();
}

function getCurrentNumOfLineItemsOfUsedPartsForm() {
    let len = usedPartsContainer.children('div').length;
    console.log('curent num of line items ' + len);
    return len;
}

function removeUsedPartsFormItem(removeButton) {
    removeButton.parents('.col-md-12.form').remove();
}

$(document).ready(function () {

    $('#used-part-addition-button').on('click', function () {
        addUsedPartForm();
    })

    $(document).on('click', '.remove-num-parts-row-button', function () {
        removeUsedPartsFormItem($(this));
    })
});