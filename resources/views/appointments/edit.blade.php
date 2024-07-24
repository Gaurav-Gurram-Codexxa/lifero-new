@extends('layouts.app')
@section('title')
{{__('messages.appointment.edit_appointment')}}
@endsection
@section('page_css')
{{-- <link rel="stylesheet" href="{{ asset('assets/css/int-tel/css/intlTelInput.css') }}">--}}
@endsection
@section('header_toolbar')
<div class="container-fluid">
    <div class="d-md-flex align-items-center justify-content-between mb-7">
        <h1 class="mb-0">@yield('title')</h1>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="alert alert-danger hide" id="editAppointmentErrorsBox"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                {{ Form::open(['id' => 'editAppointmentForm']) }}
                    @method('patch')
                    @include('appointments.edit_fields')
                {{ Form::close() }}
                {{ Form::hidden('utilsScript', asset('assets/js/int-tel/js/utils.min.js'), ['class' => 'utilsScript']) }}
                {{ Form::hidden('isEdit', true, ['class' => 'isEdit']) }}
                {{ Form::hidden('defaultAppointmentEditAvatarImageURL', asset('assets/img/avatar.png'), ['id' => 'defaultAppointmentEditAvatarImageURL']) }}
            </div>
        </div>
    </div>
    @include('appointments.templates.appointment_slot')

    {{ Form::hidden('hospitalUrl', url('hospitals-list'), ['class' => 'hospitalUrl']) }}


    {{ Form::hidden('doctorDepartmentUrl', url('doctors-list'), ['class' => 'doctorDepartmentUrl']) }}
    {{ Form::hidden('doctorScheduleList', url('doctor-schedule-list'), ['class' => 'doctorScheduleList']) }}
    {{ Form::hidden('appointmentUpdateUrl', route('appointments.update', ['appointment' => $appointment->id]), ['id' => 'appointmentUpdateUrl']) }}
    {{ Form::hidden('appointmentFeeUrl', route('appointments.fee', ['edit' => '1']), ['id' => 'appointmentFeeUrl']) }}
    {{ Form::hidden('appointmentIndexPage',  auth()->user()->hasRole('Tele Caller') ? route('leads.index') : route('appointments.index'), ['class' => 'appointmentIndexPage']) }}
    {{ Form::hidden('isEdit', true, ['class' => 'isEdit']) }}
    {{ Form::hidden('isCreate', false, ['class' => 'isCreate']) }}
    {{ Form::hidden('getBookingSlot', route('get.booking.slot'), ['class' => 'getBookingSlot']) }}
    {{ Form::hidden('search', route('patients.search'), ['class' => 'searchPatient']) }}
    {{ Form::hidden('selectedTime', $appointment->opd_date->format("H:i")) }}
</div>
<script>
    $(document).ready(function() {
        document.querySelector('.opdDate')._flatpickr
            .setDate('{{$appointment->opd_date->format("Y-m-d")}}', true)



    })
</script>
@endsection
{{--let utilsScript = "{{asset('assets/js/int-tel/js/utils.min.js')}}";--}}
{{--let isEdit = true;--}}
{{--let defaultAvatarImageUrl = "{{ asset('assets/img/avatar.png') }}";--}}
{{-- <script src="{{ mix('assets/js/appointments/create-edit.js') }}"></script>--}}
{{-- <script src="{{ mix('assets/js/custom/add-edit-profile-picture.js') }}"></script>--}}
{{-- <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>--}}
