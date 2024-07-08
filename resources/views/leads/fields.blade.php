<div class="alert alert-danger d-none hide" id="customValidationErrorsBox"></div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('name',__('messages.lead.name').(':'), ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::text('name', null, ['class' => 'form-control','required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('email',__('messages.user.email').(':'), ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::email('email', null, ['class' => 'form-control','required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('contact',__('messages.user.phone').(':'), ['class' => 'form-label']) }}
            <br>
            {{ Form::tel('contact', null, ['class' => 'form-control w-100 iti phoneNumber','id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
            {{ Form::hidden('prefix_code',null,['class' => 'prefix_code']) }}
            {{ Form::hidden('country_iso', null, ['class' => 'country_iso']) }}
            <span class="text-success d-none fw-400 fs-small mt-2 valid-msg" id="valid-msg">✓ &nbsp; {{__('messages.valid')}}</span>
            <span class="text-danger d-none fw-400 fs-small mt-2 error-msg" id="error-msg"></span>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12 mb-3">
        <h5>{{__('messages.user.address_details')}}</h5>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('address',__('messages.user.address1').(':'), ['class' => 'form-label']) }}
            {{ Form::text('address', null, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group mb-5">
            {{ Form::label('city',__('messages.user.city').(':'), ['class' => 'form-label']) }}
            {{ Form::text('city', null, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group mb-5">
            {{ Form::label('state',__('messages.user.state').(':'), ['class' => 'form-label']) }}
            {{ Form::text('state', null, ['class' => 'form-control', ]) }}
        </div>
    </div>
    <div class="d-flex justify-content-end">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2']) }}
        <a href="{{ route('leads.index') }}"
           class="btn btn-secondary">{{__('messages.common.cancel')}}</a>
    </div>
</div>
