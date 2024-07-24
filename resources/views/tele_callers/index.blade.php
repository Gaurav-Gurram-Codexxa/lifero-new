@extends('layouts.app')
@section('title')
    {{__('messages.tele_caller.tele_callers')}}
@endsection
@section('css')
{{--    <link rel="stylesheet" href="{{ asset('assets/css/sub-header.css') }}">--}}
@endsection
@section('content')
    <div class="container-fluid">
    <div class="d-flex flex-column">
            @include('flash::message')
            {{ Form::hidden('teleCallerUrl', url('tele-callers'), ['id' => 'teleCallerURL']) }}
            {{ Form::hidden('teleCaller', __('messages.delete.tele_caller'), ['id' => 'TeleCaller']) }}
            <livewire:tele-caller-table/>
            @include('tele_callers.templates.templates')
            @include('partials.page.templates.templates')
            {{ Form::hidden('teleCallerIndexURL', url('tele-callers'), ['id' => 'teleCallerIndexURL']) }}
        </div>
    </div>
@endsection
{{--        let tele_callerUrl = "{{url('tele_callers')}}";--}}
{{--    <script src="{{ mix('assets/js/custom/delete.js') }}"></script>--}}
{{--    <script src="{{ mix('assets/js/tele_callers/tele_callers.js') }}"></script>--}}
