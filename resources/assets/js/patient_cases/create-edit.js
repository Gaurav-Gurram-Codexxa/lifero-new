document.addEventListener('turbo:load', loadPatientCaseData)

function loadPatientCaseData() {
    if (!$('#createPatientCaseForm').length &&
        !$('#editPatientCaseForm').length) {
        return
    }

    var query = {};
    var sessionId = -1;
    function markMatch(text, term) {

        var match = text.toUpperCase().indexOf(term.toUpperCase());

        var $result = $('<span></span>');
        if (match < 0) {
            return $result.text(text);
        }
        $result.text(text.substring(0, match));
        var $match = $('<span style="text-decoration: underline;"></span>');
        $match.text(text.substring(match, match + term.length));
        $result.append($match);
        $result.append(text.substring(match + term.length));

        return $result;
    }

    $('#casePatientId').select2({
        width: '100%',
        templateResult: function (item) {
            if (item.loading) {
                return item.text;
            }

            var term = query.term || '';
            var $result = markMatch(item.text, term);

            return $result;
        },
        language: {
            searching: function (params) {
                query = params;
                return 'Searching…';
            }
        },
        ajax: {
            delay: 250,
            url: $('.searchPatient').val(),
            dataType: 'json',
            minimumInputLength: 3
        }
    });

    $('#caseDoctorId').select2({
        width: '100%',
    })
    $('#caseDate').flatpickr({
        enableTime: true,
        // defaultDate: new Date(),
        dateFormat: 'Y-m-d H:i',
        minDate: new Date(),
        locale: $('.userCurrentLanguage').val(),
    })
    $('#casePatientId').focus()

    $('.price-input').trigger('input')

    listenChange('#packageId', function () {
        let selectedPackage = $(this).val();
        if (!selectedPackage) {
            $(`#accordionSession`).html('')
            return
        }
        $.get(`${$('.packageSession').val()}/${selectedPackage}/session`, (data) => {
            $('.session').show()
            let details = data.data;
            sessionId = details.session.length;
            let session = details.session.reduce((a, c, i) => a += drawSessions(i, c), '');

            $(`#accordionSession`).html(session)
            $('.session-time').flatpickr({
                enableTime: true,
                dateFormat: 'Y-m-d H:i',
                minDate: new Date(),
                locale: $('.userCurrentLanguage').val(),
            })

            calculateAndSetTotalAmount()
        })
    })

    listenChange('.package-discount', function () {
        calculateAndSetTotalAmount()
    })

    function calculateAndSetTotalAmount() {
        let totalAmount = 0;
        let discount = parseFloat(
            $('.package-discount').val() !== '' ? $('.package-discount').val() : 0);

        $('.item-total').each((i, e) => {
            let itemTotal = $(e).text()
            itemTotal = removeCommas(itemTotal);
            itemTotal = isEmpty(itemTotal.trim()) ? 0 : parseInt(itemTotal)
            totalAmount += itemTotal
        });

        totalAmount = parseFloat(totalAmount)
        totalAmount -= (totalAmount * discount / 100)
        $('#packagesTotal').text(addCommas(totalAmount.toFixed(2)))
        $('[name=fee]').val(totalAmount)
    };

    listenClick('#addCaseSession', function () {
        let session = drawSessions(sessionId, [{ amount: 0, quantity: 0, rate: 0, service_id: 0 }]);
        sessionId++
        $(`#accordionSession`).append(session)
        $('.session-time').flatpickr({
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            locale: $('.userCurrentLanguage').val(),
        })

    })

}

function drawSessions(id, services) {
    let $services = services.reduce((a, c) => a += drawServices(id, c), '');
    return `<div class="accordion-item session-${id}">
    <h2 class="accordion-header" id="heading-${id}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${id}" aria-expanded="true" aria-controls="collapse-${id}">
            Session
        </button>
    </h2>
    <div id="collapse-${id}" class="accordion-collapse collapse" aria-labelledby="heading-${id}" data-bs-parent="#accordionSession">
        <div class="accordion-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group col-6">
                        <label>
                            Session Date
                        </label>
                        <input class="form-control session-time" name="session[${id}][session_date]">
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <button type="button" data-id="${id}" class="btn btn-danger btn-sm  me-2 remove-session">
                        <i class="fa-solid fa-trash"></i> Remove Session
                    </button>
                    <button type="button" class="btn btn-sm btn-primary session-add-package" data-id="${id}">Add</button>
                </div>

            </div>
            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr class="fw-bold fs-6 text-muted">
                            <th class="form-label fw-bolder text-gray-700 mb-3"><?= __('messages.package.service') ?><span class="required"></span></th>
                            <th class="form-label fw-bolder text-gray-700 mb-3"><?= __('messages.package.qty') ?><span class="required"></span></th>
                            <th class="form-label fw-bolder text-gray-700 mb-3"><?= __('messages.package.rate') ?><span class="required"></span></th>
                            <th class="text-right form-label fw-bolder text-gray-700 mb-3"><?= __('messages.package.amount') ?></th>
                            <th class="table__add-btn-heading text-center form-label fw-bolder text-gray-700 mb-3"></th>
                        </tr>
                    </thead>
                    <tbody class="package-service-item-container-${id}">
                        ${$services}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>`
}

function drawServices(session, data) {
    let availableServices = JSON.parse($('.associateServices').val())
    let options = availableServices.reduce((a, c) => {
        selected = c.key == data.service_id ? 'selected' : ''
        return a += `<option value="${c.key}" ${selected}>${c.value}</option>`
    }, '')
    return `
    <tr>
        <td class="table__item-desc">
            <select class="form-select serviceId form-select-solid" name="session[${session}][service_id][]" placeholder="<?php echo __('messages.package.select_service'); ?>" id="enquiry-medicine-id_{{:uniqueId}}" data-id="{{:uniqueId}}" required>
                <option value="0">Select Service</option>
                 ${options}
            </select>
        </td>
        <td class="table__qty">
            <input class="form-control packages-qty" required="" value="${data.quantity}" name="session[${session}][quantity][]" type="number">
        </td>
        <td>
            <input class="form-control price-input packages-price" required="" value="${data.rate}" name="session[${session}][rate][]" type="text">
        </td>
        <td class="amount text-right item-total">
        ${data.amount}
        </td>
        <td class="text-center">
            <a href="#" title="Delete" class="delete-btn delete-service-package-item pointer btn px-2 text-danger fs-3 ps-0">
                <i class="fa-solid fa-trash"></i>
            </a>
        </td>
    </tr>`;
}

listenSubmit('#createPatientCaseForm, #editPatientCaseForm', function () {
    $('#saveCaseBtn').attr('disabled', true)

    if ($('.error-msg').text() !== '') {
        $('.phoneNumber').focus()
        $('#saveCaseBtn').attr('disabled', false)
        return false
    }
})

