@extends('layouts.app')
@section('title')
{{__('messages.lead.leads')}}
@endsection
@section('css')
{{-- <link rel="stylesheet" href="{{ asset('assets/css/sub-header.css') }}">--}}
@endsection
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column">
        @include('flash::message')
        {{ Form::hidden('leadUrl', url('leads'), ['id' => 'leadURL']) }}
        {{ Form::hidden('lead', __('messages.delete.lead'), ['id' => 'Lead']) }}
        <livewire:lead-table />
        @include('leads.templates.templates')
        @include('partials.page.templates.templates')
        {{ Form::hidden('leadIndexURL', url('leads'), ['id' => 'leadIndexURL']) }}
    </div>
</div>

<script>
    listenClick('.lead-delete-btn', function(event) {
        let leadId = $(event.currentTarget).attr('data-id');
        deleteItem($('#leadURL').val() + '/' + leadId,
            '#leadsTbl',
            'Lead')
    })
</script>
@endsection
{{-- let leadUrl = "{{url('leads')}}";--}}
{{-- <script src="{{ mix('assets/js/custom/delete.js') }}"></script>--}}
{{-- <script src="{{ mix('assets/js/leads/leads.js') }}"></script>--}}