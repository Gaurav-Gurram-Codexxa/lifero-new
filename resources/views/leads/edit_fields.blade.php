@php
$readonly = auth()->user()->hasRole('Tele Caller') ? 'readonly' : '';
@endphp

<div class="alert alert-danger d-none hide" id="customValidationErrorsBox"></div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('name',__('messages.user.name').(':'), isset($lead->name) ? $lead->name : null , ['class' =>
            'form-label ']) }}
            <span class="required"></span>
            {{ Form::text('name', null, ['class' => 'form-control','required', $readonly]) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('email',__('messages.user.email').(':'), isset($lead->email) ? $lead->email : null , ['class'
            => 'form-label ']) }}
            <span class="required"></span>
            {{ Form::email('email', null, ['class' => 'form-control','required', $readonly]) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('phone',__('messages.user.phone').(':'), ['class' => 'form-label ']) }}
            <br>
            {{ Form::tel('contact', isset($lead->contact) ? $lead->contact : null , ['class' => 'form-control iti
            phoneNumber','id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value =
            this.value.replace(/\D/g,"")', $readonly]) }}
            {{ Form::hidden('prefix_code',null,['class' => 'prefix_code']) }}
            {!! Form::hidden('country_iso', null, ['class' => 'country_iso']) !!}
            <span class="text-success d-none fw-400 fs-small mt-2 valid-msg" id="valid-msg">✓ &nbsp;
                {{__('messages.valid')}}</span>
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
            {{ Form::label('address',__('messages.user.address1').(':'), ['class' => 'form-label ']) }}
            {{ Form::text('address', isset($lead->address) ? $lead->address : null, ['class' => 'form-control ',
            $readonly]) }}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group mb-5">
            {{ Form::label('city',__('messages.user.city').(':'), ['class' => 'form-label ']) }}
            {{ Form::text('city', isset($lead->city) ? $lead->city : null, ['class' => 'form-control ', $readonly]) }}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group mb-5">
            {{ Form::label('state',__('messages.user.state').(':'), ['class' => 'form-label ']) }}
            {{ Form::text('state', isset($lead->state) ? $lead->state : null, ['class' => 'form-control ', $readonly])
            }}
        </div>
    </div>
</div>
<div class="row mt-3">

    <div class="col-md-6">
        <div class="form-group mb-5">
            <label for="disposition">Disposition</label>
            <select name="disposition" class="form-control" id="disposition">
                <option value="">Select Disposition</option>
                @foreach(\App\Models\Lead::DISPOSITION as $d)
                <option value="{{$d}}" {{$d==$lead->disposition ? 'selected' : ''}}>{{$d}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-5">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">Select Status</option>
                @foreach(\App\Models\Lead::STATUS as $d)
                <option value="{{$d}}" {{$d==$lead->status ? 'selected' : ''}}>{{$d}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group mb-5">
            <label for="remark">Remark</label>
            <textarea name="remark" class="form-control" id="remark"></textarea>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        @role('Tele Caller')
        <input type="submit" value="By Mistake" name="by_mistake" class="btn btn-danger me-2">
        <a href="{{route('book-appointment', ['lead' => $lead->id])}}" class="btn btn-success me-2">Book Appointment</a>
        @endrole
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2']) }}
        <a href="{{ route('tele-callers.index') }}" class="btn btn-secondary">{{__('messages.common.cancel')}}</a>
    </div>
</div>