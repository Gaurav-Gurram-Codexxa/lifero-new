@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.min.css" integrity="sha512-MeagJSJBgWB9n+Sggsr/vKMRFJWs+OUphiDV7TJiYu+TNQD9RtVJaPDYP8hA/PAjwRnkdvU+NsTncYTKlltgiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>Dropzone.autoDiscover = false;</script>
@endsection

@section('title')
{{__('messages.session.edit_session')}}
@endsection
@section('page_css')
{{-- <link rel="stylesheet" href="{{ asset('assets/css/int-tel/css/intlTelInput.css') }}">--}}
@endsection
@section('header_toolbar')
<div class="container-fluid">
    <div class="d-md-flex align-items-center justify-content-between mb-7">
        <h1 class="mb-0">@yield('title')</h1>
        <a href="{{ route('case-sessions.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="alert alert-danger hide" id="editCaseSessionErrorsBox"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                {{ Form::open(['id' => 'editCaseSessionForm', 'url' => route('case-sessions.update', ['case_session' => $case_session->id]), 'files' => true]) }}
                @method('patch')
                @include('patient_case_sessions.edit_fields')

                {{ Form::close() }}
                {{ Form::hidden('utilsScript', asset('assets/js/int-tel/js/utils.min.js'), ['class' => 'utilsScript']) }}
                {{ Form::hidden('isEdit', true, ['class' => 'isEdit']) }}
                {{ Form::hidden('defaultCaseSessionEditAvatarImageURL', asset('assets/img/avatar.png'), ['id' => 'defaultCaseSessionEditAvatarImageURL']) }}
            </div>
        </div>
    </div>
    
</div>
<script>
    $('#caseDate').flatpickr({
        enableTime: true,
        dateFormat: 'Y-m-d H:i',
        minDate: new Date(),
    })
</script>
@endsection
{{--let utilsScript = "{{asset('assets/js/int-tel/js/utils.min.js')}}";--}}
{{--let isEdit = true;--}}
{{--let defaultAvatarImageUrl = "{{ asset('assets/img/avatar.png') }}";--}}
{{-- <script src="{{ mix('assets/js/sessions/create-edit.js') }}"></script>--}}
{{-- <script src="{{ mix('assets/js/custom/add-edit-profile-picture.js') }}"></script>--}}
{{-- <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>--}}