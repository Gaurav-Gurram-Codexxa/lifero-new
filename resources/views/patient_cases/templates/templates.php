<script id="caseActionTemplate" type="text/x-jsrender">
   <a title="<?php echo __('messages.common.edit'); ?>" class="btn action-btn btn-success btn-sm" href="{{:url}}">
            <i class="fa fa-edit action-icon"></i>
   </a>
   <a title="<?php echo __('messages.common.delete'); ?>" class="btn action-btn btn-danger btn-sm delete-btn" data-id="{{:~session}}">
            <i class="fa fa-trash action-icon"></i>
   </a>
</script>

<script id="packageServiceTemplate" type="text/x-jsrender">
    <tr>

        <td class="table__item-desc">
            <select class="form-select serviceId form-select-solid" name="session[{{:~session}}][service_id][]" placeholder="<?php echo __('messages.package.select_service'); ?>" id="enquiry-medicine-id_{{:uniqueId}}" data-id="{{:uniqueId}}" required>
                <option selected="selected" value="0">Select Service</option>
                {{for services}}
                    <option value="{{:key}}" >{{:value}}</option>
                {{/for}}
            </select>
        </td>
        
        <td>
            <input class="form-control price-input packages-price" required="" value="{{!-- :sessions[~session][~i].rate --}}" name="session[{{:~session}}][rate][]" type="text">
        </td>

        <td class="table__qty">
            <input class="form-control packages-qty" required="" value="{{!-- :sessions[~session][~i].quantity --}}" name="session[{{:~session}}][quantity][]" type="number">
        </td>


        <td class="amount text-right item-total">
            {{!-- :sessions[~session][~i].amount --}}
        </td>

        <td class="text-center">
            <a href="#" title="<?php echo __('messages.common.delete') ?>" class="delete-btn delete-service-package-item pointer btn px-2 text-danger fs-3 ps-0">
                <i class="fa-solid fa-trash"></i>
            </a>
        </td>

    </tr>
</script>

<script id="packageSessionTemplate" type="text/x-jsrender">
    {{for sessions}}
    <div class="accordion-item session-{{:#getIndex()}}">
        
        <h2 class="accordion-header" id="heading-{{:#getIndex()}}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{:#getIndex()}}" aria-expanded="true" aria-controls="collapse-{{:#getIndex()}}">
                Session
            </button>
        </h2>

        <div id="collapse-{{:#getIndex()}}" class="accordion-collapse collapse show" aria-labelledby="heading-{{:#getIndex()}}" data-bs-parent="#accordionSession">
            <div class="accordion-body">
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" title="<?php echo __('messages.common.delete') ?>" data-id="{{:#getIndex()}}" class="btn btn-danger btn-sm  me-2 remove-session">
                        <i class="fa-solid fa-trash"></i> Remove Session
                    </button>
                    <button type="button" class="btn btn-sm btn-primary session-add-package" data-id="{{:#getIndex()}}"><?= __('messages.common.add') ?></button>
                </div>
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr class="fw-bold fs-6 text-muted">
                                <th class="form-label fw-bolder text-gray-700 mb-3"><?= __('messages.package.service') ?><span class="required"></span></th>
                                <th class="form-label fw-bolder text-gray-700 mb-3"><?= __('messages.package.rate') ?><span class="required"></span></th>
                                <th class="form-label fw-bolder text-gray-700 mb-3"><?= __('messages.package.qty') ?><span class="required"></span></th>
                                <th class="text-right form-label fw-bolder text-gray-700 mb-3"><?= __('messages.package.amount') ?></th>
                                <th class="table__add-btn-heading text-center form-label fw-bolder text-gray-700 mb-3"></th>
                            </tr>
                        </thead>
                        <tbody class="package-service-item-container-{{:#getIndex()}}">
                            {{for -sessions tmpl="#packageServiceTemplate" /}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{else}}
    ds
    {{/for}}
</script>
