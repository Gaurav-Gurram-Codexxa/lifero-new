document.addEventListener('turbo:load', loadTeleCallerCreateData)

function loadTeleCallerCreateData() {
    $('#accountantBloodGroup, #editTeleCallerBloodGroup').select2({
        width: '100%',
    });

    $('#accountantBirthDate, #editTeleCallerBirthDate').flatpickr({
        format: 'YYYY-MM-DD',
        useCurrent: true,
        sideBySide: true,
        maxDate: new Date(),
        locale: $('.userCurrentLanguage').val(),
    });
    
    listenSubmit('#createTeleCallerForm, #editTeleCallerForm', function () {
        if ($('.error-msg').text() !== '') {
            $('.phoneNumber').focus();
            return false;
        }
    })

    $('#createTeleCallerForm, #editTeleCallerForm').find('input:text:visible:first').focus();
    
    listenClick('.remove-image', function () {
        defaultImagePreview('#previewImage', 1);
    })
    
}
