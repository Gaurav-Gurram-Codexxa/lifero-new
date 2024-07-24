<div class="row">
    <div class="form-group col-sm-6 mb-5">

        <label for="patient_name" class="form-label d-flex justify-content-between">
            <span>Patient:<span class="required"></span></span>
            <a href="{{route('patients.create', ['from' => 'b'])}}" class="btn btn-primary btn-sm">New Patient</a>
          </label>

        <select name="patient_id" class="form-select" id="casePatientId" placeholder={{__('messages.document.select_patient')}} data-control="select2" required>
            @if(isset($patient))
            <option value="{{$patient->id}}" selected>{{$patient->text}}</option>
            @endif
        </select>

    </div>

    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('doctor_name', __('messages.case.doctor').(':'),['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::select('doctor_id', $doctors, null, ['class' => 'form-select', 'required', 'id' => 'caseDoctorId', 'placeholder' =>  __('messages.web_home.select_doctor'), 'data-control' => 'select2', 'required']) }}
    </div>

    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('caseHandlerId', __('messages.case.case_handler').(':'),['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::select('case_handler_id', $handlers, null, ['class' => 'form-select', 'required', 'id' => 'caseHandlerId', 'placeholder' =>  __('messages.web_home.select_case_handler'), 'data-control' => 'select2', 'required']) }}
    </div>
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('packageId', __('messages.case.package').(':'),['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::select('package_id', $packages, null, ['class' => 'form-select', 'required', 'id' => 'packageId', 'placeholder' =>  __('messages.web_home.select_package'), 'data-control' => 'select2', 'required']) }}
    </div>

    <div class="form-group col-md-6 mb-5">
        {{ Form::label('phone', __('messages.case.phone').':', ['class' => 'form-label']) }}
        <br>
        {!! Form::tel('phone', null, ['class' => 'form-control iti phoneNumber', 'id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'tabindex' => '5']) !!}
        <br>
        {{ Form::hidden('prefix_code',null,['class'=>'prefix_code']) }}
        {{ Form::hidden('country_iso', null, ['class' => 'country_iso']) }}
        <span class="text-success valid-msg d-none fw-400 fs-small mt-2" id="valid-msg">✓ &nbsp; {{__('messages.valid')}}</span>
        <span class="text-danger error-msg d-none fw-400 fs-small mt-2" id="error-msg"></span>
    </div>

    <div class="form-group col-sm-6 mb-5">
        <input type="hidden" name="fee">
        <label for="">Discount %</label>
        <input name="discount" value="{{ isset($patientCase->discount) ?  $patientCase->discount : ''}}" class="form-control price-input price package-discount">
    </div>

    {{-- <div class="form-group col-sm-6 mb-5">
        {{ Form::label('date', __('messages.case.case_date').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('date', null, ['id'=>'caseDate','class ' => 'form-control bg-white','required', 'autocomplete' => 'off']) }}
    </div> --}}

    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('date', __('messages.case.case_date').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('date', \Carbon\Carbon::now()->format('Y-m-d H:i'), ['id' => 'caseDate', 'class' => 'form-control bg-white', 'readonly', 'autocomplete' => 'off']) }}
    </div>


    <!-- Make Changes Here -->

    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('date', __('messages.case.case_start_date').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('caseStartDate',null, ['id'=>'caseStartDate','class ' => 'form-control bg-white','required', 'autocomplete' => 'off']) }}
    </div>


    <div class="form-group col-sm-6 mb-5">
        <input type="hidden" name="fee">
        {{ Form::label('session_duration', __('messages.case.session_duration').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        <input name="sessionDuration" value="{{ isset($patientCase->sessionDuration) ?  $patientCase->sessionDuration : ''}}" class="form-control session-duration" required>
        <input name="session-length" hidden class="form-control session-length">
    </div>

        <!-- Make Changes Here -->

    <div class="form-group col-md-6 mb-5">
        {{ Form::label('status', __('messages.common.status').':', ['class' => 'form-label']) }}
        <br>
        <div class="form-check form-switch">
            <input name="status" class="form-check-input is-active" value="1" type="checkbox" {{(!isset($patientCase))? 'checked': (($patientCase->status) ? 'checked' : '')}}>
        </div>
    </div>

    <hr>

    <div class="col-md-12 session mb-4">

        {{-- <div class="d-flex justify-content-between align-items-center w-100 mb-4">
            <h4>Sessions</h4>
            <button type="button" id="addCaseSession" title="<?php echo __('messages.common.delete') ?>" class="btn btn-success btn-sm  me-2">
                <i class="fa-solid fa-plus"></i> Add Session
            </button>
        </div> --}}

        <div class="accordion" id="accordionSession">

            @if(isset($patientCaseSession))
    @foreach($patientCaseSession as $k => $session)
        <div class="accordion-item session-{{$k}}">
            <h2 class="accordion-header" id="heading-{{$k}}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$k}}" aria-expanded="true" aria-controls="collapse-{{$k}}">
                    Session {{$k + 1}}
                </button>
            </h2>
            <div id="collapse-{{$k}}" class="accordion-collapse collapse" aria-labelledby="heading-{{$k}}" data-bs-parent="#accordionSession">
                <div class="accordion-body">
                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" title="{{ __('messages.common.delete') }}" data-id="{{$k}}" class="btn btn-danger btn-sm me-2 remove-session">
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
                                    <th class="table__add-btn-heading text-center form-label fw-bolder text-gray-700 mb-3"></th>
                                </tr>
                            </thead>
                            <tbody class="package-service-item-container-{{$k}}">
                                @php
                                    $services = is_string($session->services) ? json_decode($session->services, true) : $session->services;
                                @endphp
                                @foreach($services as $v)
                                <tr>
                                    <td class="table__item-desc">
                                        {{ Form::select("session[$k][service_id][]", $servicesList, $v['service_id'], ['class' => 'form-select serviceId','required','data-control' => 'select2', 'placeholder' => __('messages.package.select_service')]) }}
                                    </td>
                                    <td class="service-price">
                                        {{ Form::text("session[$k][rate][]", $v['rate'], ['class' => 'form-control decimal-number packages-price','required']) }}
                                    </td>
                                    <td class="table__qty service-qty">
                                        {{ Form::number("session[$k][quantity][]", $v['quantity'], ['class' => 'form-control packages-qty','required']) }}
                                    </td>
                                    <td class="amount text-right item-total">
                                        {{ $v['rate'] * $v['quantity'] }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#" title="{{ __('messages.common.delete') }}" class="delete-btn delete-service-package-item pointer btn px-2 text-danger fs-3 ps-0">
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
@endif



        </div>


        <div class="m-3 d-flex justify-content-end">
            <span class="font-weight-bold form-label">{{ __('messages.package.total_amount').(':') }}<b>{{ getCurrencySymbol() }}</b>&nbsp;<span id="packagesTotal" class="price">{{ isset($package) ? number_format($package->total_amount,2) : 0 }}</span></span>
        </div>

    </div>

    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('description', __('messages.common.description').':', ['class' => 'form-label']) }}
        {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4]) }}
    </div>
</div>

<div class="d-flex justify-content-end">

    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2', 'id' => 'saveCaseBtn']) }}
    @if(auth()->user()->hasRole('Tele Caller'))
        <a href="{{ route('leads.index') }}" class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
    @else
    <a href="{{ route('patient-cases.index') }}" class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
    @endif

</div>
