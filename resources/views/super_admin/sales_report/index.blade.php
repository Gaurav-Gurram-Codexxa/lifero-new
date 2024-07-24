@extends('layouts.app')

@section('title')
    {{ __('messages.dashboard.dashboard') }}
@endsection

@section('page_css')
    {{-- <link href="{{ mix('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css"/> --}}
@endsection

@section('content')
    <style>
        #four_block .shadow-md {
            height: 100%;
        }
    </style>

    <div class="container-fluid">
        <div class="d-flex flex-column" id="four_block">
            <div class="row mt-4">
                <div class="col-lg-12 col-xl-3 col-md-12 col-sm-12">
                    <div class="form-group mb-3 d-flex">
                        <a href="javascript:void(0)" class="btn btn-icon btn-primary me-5 ps-3 pe-2" title="Switch Chart">
                            <span class="m-0 text-center" id="changeChart">
                                <i class="fas fa-chart-bar fs-1 chart"></i>
                            </span>
                        </a>
                        <input class="form-control" autocomplete="off" placeholder="{{ __('messages.dashboard.please_select_rang_picker') }}" id="chartFilter"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-4">
                    <div class="row">

                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                            <a href="{{ route('super.admin.hospitals.index') }}" class="text-decoration-none super-admin-revenue-report">
                                <div class="shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2" style="background-color: #701470;">
                                    <div style="background-color: #320a36!important;" class="widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-hospital fs-1-xl text-white"></i>
                                    </div>
                                    <div class="text-end text-white">
                                        <h2 class="fs-1-xxl fw-bolder text-white" id="sale-appointments"></h2>
                                        <h3 class="mb-0 fs-5 fw-light text-white">{{ __('messages.patient.total_appointments') }}</h3>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                            <div class="shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2" style="background-color: #701470;">
                                <div style="background-color: #320a36!important;" class="widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-hospital fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white" id="sale-patients"></h2>
                                    <h3 class="mb-0 fs-5 fw-light text-white">{{ __('messages.patient.total_patients') }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                            <div class="shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2" style="background-color: #701470;">
                                <div style="background-color: #320a36!important;" class="widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-hospital fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white" id="sale-cases"></h2>
                                    <h3 class="mb-0 fs-5 fw-light text-white">{{ __('messages.patient.total_cases') }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                            <div class="shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2" style="background-color: #701470;">
                                <div style="background-color: #320a36!important;" class="widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-hospital fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white" id="sale-case-sessions"></h2>
                                    <h3 class="mb-0 fs-5 fw-light text-white">{{ __('messages.patient.total_case_sessions') }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget mt-6">
                            <div class="shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2" style="background-color: #701470;">
                                <div style="background-color: #320a36!important;" class="widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-duotone fa-solid fa-indian-rupee-sign fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white" id="sale-total-revenue"></h2>
                                    <h3 class="mb-0 fs-5 fw-light text-white">{{ __('messages.total_revenue') }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget mt-6">
                            <div class="shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2" style="background-color: #701470;">
                                <div style="background-color: #320a36!important;" class="widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-duotone fa-solid fa-indian-rupee-sign fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white" id="sale-due-amount"></h2>
                                    <h3 class="mb-0 fs-5 fw-light text-white">{{ __('messages.total_due_amount') }}</h3>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12 col-xl-3 col-md-12 col-sm-12">
                    <h1>{{ __('messages.dashboard.income_report') }}</h1>
                </div>
            </div>
            <div class="row mt-5">
                <div id="hospitalIncomeChart"></div>
            </div>
        </div>
    </div>
@endsection
