@extends('layouts.app')
@section('title')
{{__('messages.lead.leads')}}
@endsection
@section('css')
@endsection
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column">
        @include('flash::message')
        <livewire:converted-leads-table/>
    </div>
</div>
@endsection
