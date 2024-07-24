@extends('layouts.app')
@section('title')
    {{__('messages.common.new')}} {{ __('messages.taxes') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <a href="{{ route('super.admin.tax.index') }}"
               class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('layouts.errors')
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => 'super.admin.tax.store']) !!}
                    @include('super_admin.tax.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
