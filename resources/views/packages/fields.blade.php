<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="form-group mb-5">
            {{ Form::label('name', __('messages.package.package').(':'),['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::text('name', null, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="form-group mb-5">
            {{ Form::label('discount', __('messages.package.discount').(':'),['class' => 'form-label']) }}
            <span class="required"></span>
            (%)
            {{ Form::number('discount',  null, ['id'=>'packagesDiscountId','class' => 'form-control package-discount', 'min' => 0, 'max' => 100, 'step' => '.01', 'placeholder' => __('messages.document.in_percentage'), 'required']) }}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group mb-5">
            {{ Form::label('description', __('messages.package.description').(':'),['class' => 'form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2]) }}
        </div>
    </div>


{{-- Here --}}


    
    <div class="d-flex justify-content-between align-items-center w-100 mb-4">
        <h4>Sessions</h4>
        <button type="button" id="addSession" title="<?php echo __('messages.common.delete') ?>" class="btn btn-success btn-sm  me-2">
            <i class="fa-solid fa-plus"></i> Add Session
        </button>
    </div>

    <div class="accordion" id="accordionSession">
        @if(isset($package))
        @foreach($package->session as $k => $session)
        <div class="accordion-item session-{{$k}}">
            <h2 class="accordion-header" id="heading-{{$k}}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$k}}" aria-expanded="true" aria-controls="collapse-{{$k}}">
                    Session
                </button>
            </h2>
            <div id="collapse-{{$k}}" class="accordion-collapse collapse" aria-labelledby="heading-{{$k}}" data-bs-parent="#accordionSession">
                <div class="accordion-body">
                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" title="<?php echo __('messages.common.delete') ?>" data-id="{{$k}}" class="btn btn-danger btn-sm  me-2 remove-session">
                            <i class="fa-solid fa-trash"></i> Remove Session
                        </button>
                        <button type="button" class="btn btn-sm btn-primary session-add-package" data-id="{{$k}}">{{ __('messages.common.add') }}</button>
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr class="fw-bold fs-6 text-muted">
                                    <th class="form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.service') }}<span class="required"></span></th>
                                    <th class="form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.rate') }}<span class="required"></span></th>
                                    <th class="form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.qty') }}<span class="required"></span></th>
                                    <th class="text-right form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.amount') }}</th>
                                    <th class="table__add-btn-heading text-center form-label fw-bolder text-gray-700 mb-3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="package-service-item-container-{{$k}}">
                                @foreach($session as $v)
                                <tr>
                                    
                                    <td class="table__item-desc">
                                        <input type="hidden" name="session[{{$k}}][id][]" value="{{$v->id}}">
                                        {{ Form::select("session[$k][service_id][]", $servicesList, $v->service_id, ['class' => 'form-select serviceId','required','data-control' => 'select2', 'placeholder' => __('messages.package.select_service')]) }}

                                    </td>

                                    <td class="service-price">
                                        {{ Form::text("session[$k][rate][]", $v->rate, ['class' => 'form-control decimal-number packages-price','required']) }}
                                    </td>
                                    

                                    <td class="table__qty service-qty">
                                        {{ Form::number("session[$k][quantity][]", $v->quantity, ['class' => 'form-control packages-qty','required']) }}
                                    </td>

                                    <td class="amount text-right item-total">
                                        {{$v->amount}}
                                    </td>
                                    <td class="text-center">
                                        <a href="#" title="<?php echo __('messages.common.delete') ?>" class="delete-btn delete-service-package-item pointer btn px-2 text-danger fs-3 ps-0">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="accordion-item session-0">
            <h2 class="accordion-header" id="heading-0">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-0" aria-expanded="true" aria-controls="collapse-0">
                    Session
                </button>
            </h2>
            <div id="collapse-0" class="accordion-collapse collapse show" aria-labelledby="heading-0" data-bs-parent="#accordionSession">
                <div class="accordion-body">
                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" title="<?php echo __('messages.common.delete') ?>" data-id="0" class="btn btn-danger btn-sm  me-2 remove-session">
                            <i class="fa-solid fa-trash"></i> Remove Session
                        </button>
                        <button type="button" class="btn btn-sm btn-primary session-add-package" data-id="0">{{ __('messages.common.add') }}</button>
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table table-striped" id="packagesBillTbl">
                            <thead class="thead-dark">
                                <tr class="fw-bold fs-6 text-muted">
                                    <th class="form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.service') }}<span class="required"></span></th>
                                    <th class="form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.rate') }}<span class="required"></span></th>
                                    <th class="form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.qty') }}<span class="required"></span></th>
                                    <th class="text-right form-label fw-bolder text-gray-700 mb-3">{{ __('messages.package.amount') }}</th>
                                    <th class="table__add-btn-heading text-center form-label fw-bolder text-gray-700 mb-3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="package-service-item-container-0">
                                <tr>

                                    <td class="table__item-desc">
                                        {{ Form::select('session[0][service_id][]', $servicesList, null, ['class' => 'form-select serviceId','required','data-control' => 'select2', 'placeholder' => __('messages.package.select_service')]) }}
                                    </td>

                                    <td class="service-price">
                                        {{ Form::text('session[0][rate][]', null, ['class' => 'form-control decimal-number packages-price','required']) }}
                                    </td>

                                    <td class="table__qty service-qty">
                                        {{ Form::number('session[0][quantity][]', null, ['class' => 'form-control packages-qty','required']) }}
                                    </td>
                                
                                    <td class="amount text-right item-total">
                                    </td>
                                    <td class="text-center">
                                        <a href="#" title="<?php echo __('messages.common.delete') ?>" class="delete-btn delete-service-package-item pointer btn px-2 text-danger fs-3 ps-0">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>


<script>
$(document).ready(function() {

  $(document).on('change', '.serviceId', function(event) {
    const serviceId = $(this).val();
    const currentIndex = $(this).closest('tr').index();

    if (serviceId) {
      $.ajax({
        url: "/employee/servicesRate",
        type: "get",
        data: {
          service_id: serviceId
        },
        success: function(response) {
          const selectedRate = response.data[0]['rate'];

          $('input.packages-price').eq(currentIndex).val(selectedRate);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error("Error retrieving service rate:", textStatus, errorThrown);
          alert("An error occurred while fetching the service rate.");
        }
      });
    } else {
      console.warn("No service selected.");
    }
  });
});
</script>


    <div class="m-3 d-flex justify-content-end">
        <span class="font-weight-bold form-label">{{ __('messages.package.total_amount').(':') }}<b>{{ getCurrencySymbol() }}</b>&nbsp;<span id="packagesTotal" class="price">{{ isset($package) ? number_format($package->total_amount,2) : 0 }}</span></span>
    </div>

    <!-- Total Amount Field -->
    {{ Form::hidden('total_amount', null, ['class' => 'form-control', 'id' => 'packagesTotalAmount']) }}

    <div class="d-flex justify-content-end">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary', 'id'=>'packagesSaveBtn']) }}
        <a href="{{ route('packages.index') }}" class="btn btn-secondary ms-2">{{ __('messages.common.cancel') }}</a>
    </div>
</div>

<script>
    let session = <?= isset($package) ? count($package->session) : 1 ?>;
</script>