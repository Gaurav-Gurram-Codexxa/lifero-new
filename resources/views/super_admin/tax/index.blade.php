@extends('layouts.app')
@section('title')
    {{__('messages.admins')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            {{ Form::hidden('taxUrl', url('super-admin/tax'), ['id' => 'taxUrl']) }}
            <livewire:tax-table />
        </div>
    </div>
@endsection

