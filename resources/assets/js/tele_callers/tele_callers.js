listenClick('.tele-caller-delete-btn', function (event) {
    let teleCallerId = $(event.currentTarget).attr('data-id')
    deleteItem($('#teleCallerIndexURL').val() + '/' + teleCallerId,
        '#teleCallersTbl',
        $('#TeleCaller').val())
})

listenChange('.tele_caller-status', function (event) {
    let teleCallerId = $(event.currentTarget).attr('data-id')
    updateTeleCallerStatus(teleCallerId)
})

window.updateTeleCallerStatus = function (id) {
    $.ajax({
        url: $('#teleCallerIndexURL').val() + '/' + +id + '/active-deactive',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message)
                livewire.emit('refresh')
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message)
        },
    })
}

listen('change', '#TeleCaller_filter_status', function () {
    window.livewire.emit('changeFilter', 'statusFilter', $(this).val())
})

listenClick('#TeleCallerResetFilter', function () {
    $('#TeleCaller_filter_status').val(0).trigger('change')
    hideDropdownManually($('#TeleCallerFilterBtn'), $('.dropdown-menu'))
})

 
 
