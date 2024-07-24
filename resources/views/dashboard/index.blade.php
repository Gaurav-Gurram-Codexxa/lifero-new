@extends('layouts.app')
@section('title')
{{ __('messages.dashboard.dashboard') }}
@endsection
@section('page_css')
{{-- <link href="{{ mix('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css"/> --}}
{{-- <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}"> --}}
@endsection
@section('content')
<?php
$currencySymbol = getCurrencySymbol();
?>
<div class="container-fluid">
    <div class="d-flex flex-column">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="row">

                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a class="text-decoration-none" href="{{ route('appointments.index') }}">
                            <div class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                <div class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-file-invoice fs-1 text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="fs-1-xxl fw-bolder text-primary">{{$data['appointments']}}</h2>
                                    <h3 class="mb-0 fs-5 fw-bold text-dark">No. of Appointment
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('appointments.index') }}" class="text-decoration-none">
                            <div class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                <div class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-money-bill fs-1 text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="fs-1-xxl fw-bolder text-primary"> {{formatCurrency($data['todays_appointment'], 2)}} </h2>
                                    <h3 class="mb-0 fs-5 fw-bold text-dark">Today's Appointments</h3>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('appointments.index') }}" class="text-decoration-none">
                            <div class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                <div class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-money-bill fs-1 text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="fs-1-xxl fw-bolder text-primary"> {{formatCurrency($data['upcoming_appointment'], 2)}} </h2>
                                    <h3 class="mb-0 fs-5 fw-bold text-dark">Upcoming Appointments</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('case-sessions.index') }}" class="text-decoration-none">
                            <div class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                <div class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-money-bill fs-1 text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="fs-1-xxl fw-bolder text-primary"> {{$data['session_appointment']}} </h2>
                                    <h3 class="mb-0 fs-5 fw-bold text-dark">Today's Session Appointments</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('doctors.index') }}" class="text-decoration-none">
                            <div class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                <div class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-user-doctor fs-1 text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="fs-1-xxl fw-bolder text-primary">{{ $data['doctors'] }}</h2>
                                    <h3 class="mb-0 fs-5 fw-bold text-dark">{{ __('messages.dashboard.doctors') }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('patients.index') }}" class="text-decoration-none">
                            <div class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                <div class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-user-injured fs-1 text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="fs-1-xxl fw-bolder text-primary">{{ $data['patients'] }}</h2>
                                    <h3 class="mb-0 fs-5 fw-bold text-dark">{{ __('messages.dashboard.patients') }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('leads.index') }}" class="text-decoration-none">
                            <div class="bg-white shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                <div class="bg-primary widget-icon rounded-10 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-money-check fs-1 text-white"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="fs-1-xxl fw-bolder text-primary">{{$data['leads']}}
                                    </h2>
                                    <h3 class="mb-0 fs-5 fw-bold text-dark">
                                        No. of Leads
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-xxl-7 col-12 mb-7 mb-xxl-0">
                <div class="card mb-7">
                    <div class="card-header pb-0 px-10">
                        <h3 class="mb-0">
                            {{ __('messages.enquiries') }}
                        </h3>
                    </div>
                    <div class="card-body pt-7">
                        @if (count($data['enquiries']) > 0)
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('messages.enquiry.name') }}</th>
                                    <th scope="col">{{ __('messages.enquiry.email') }}</th>
                                    <th scope="col">{{ __('messages.common.created_on') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($data['enquiries'] as $enquiry)
                                <tr>
                                    <td>
                                        <a href="{{ route('enquiry.show', $enquiry->id) }}" class="text-primary-800 text-decoration-none mb-1 fs-6">{{ $enquiry->full_name }}</a>
                                    </td>
                                    <td class="text-start">
                                        <span class="text-muted fw-bold d-block">{{ $enquiry->email }}</span>
                                    </td>
                                    <td class="text-center text-muted fw-bold d-flex">
                                        <span class="badge bg-light-info">
                                            {{ \Carbon\Carbon::parse($enquiry->created_at)->translatedFormat('jS M, Y') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h4 class="mb-0 text-center fs-2">{{ __('messages.dashboard.no_enquiries_yet') }}</h4>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header pb-0 px-10">
                        <h3 class="mb-0">
                            {{ __('messages.new_change.upcoming_appointments') }}
                        </h3>
                    </div>
                    <div class="card-body pt-7">
                        <livewire:upcoming-appointment-table />
                    </div>
                </div>
            </div>



            <div class="col-xxl-5 col-12 mb-7 mb-xxl-0">
                <div class="card">
                    <div class="card-header pb-0 px-10">
                        <h3 class="mb-0">
                            {{ __('messages.dashboard.notice_boards') }}
                        </h3>
                    </div>
                    <div class="card-body pt-7">
                        @if (count($data['noticeBoards']) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('messages.dashboard.title') }}</th>
                                    <th scope="col">{{ __('messages.common.created_on') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($data['noticeBoards'] as $noticeBoard)
                                <tr>
                                    <td>
                                        <a href="{{ route('notice-boards.show', $noticeBoard->id) }}" class="text-decoration-none notice-board-view-btn">
                                            {{ Str::limit($noticeBoard->title, 32, '...') }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-light-info">
                                            {{ \Carbon\Carbon::parse($noticeBoard->created_at)->translatedFormat('jS M, Y') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h4 class="mb-0 text-center fs-2">{{ __('messages.dashboard.no_notice_yet') }}</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{ Form::hidden('incomeExpenseReportUrl', route('income-expense-report'), ['id' => 'dashboardIncomeExpenseReportUrl', 'class' => 'incomeExpenseReportUrl']) }}
    {{ Form::hidden('currentCurrencyName', $currencySymbol, ['id' => 'dashboardCurrentCurrencyName', 'class' => 'currentCurrencyName']) }}
    {{ Form::hidden('income_and_expense_reports', __('messages.dashboard.income_and_expense_reports'), ['id' => 'dashboardIncome_and_expense_reports', 'class' => 'income_and_expense_reports']) }}
    {{ Form::hidden('defaultAvatarImageUrl', asset('assets/img/avatar.png'), ['id' => 'dashboardDefaultAvatarImageUrl', 'class' => 'defaultAvatarImageUrl']) }}
    {{ Form::hidden('noticeBoardUrl', url('notice-boards'), ['id' => 'dashboardNoticeBoardUrl', 'class' => 'noticeBoardUrl']) }}
</div>
@endsection
{{-- <script src="{{ asset('assets/js/chart.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/daterangepicker.js') }}"></script> --}}
{{-- let incomeExpenseReportUrl = "{{route('income-expense-report')}}"; --}}
{{-- let currentCurrencyName = "{{ getCurrencySymbol()}}"; --}}
{{-- let curencies = JSON.parse('@json($data['currency'])'); --}}
{{-- let income_and_expense_reports = "{{ __('messages.dashboard.income_and_expense_reports') }}"; --}}
{{-- let defaultAvatarImageUrl = "{{ asset('assets/img/avatar.png') }}"; --}}
{{-- <script src="{{mix('assets/js/dashboard/dashboard.js')}}"></script> --}}
{{-- <script src="{{mix('assets/js/custom/input_price_format.js')}}"></script> --}}
