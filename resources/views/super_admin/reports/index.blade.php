@extends('layouts.app')
@section('title')
    {{ __('messages.dashboard.dashboard') }}
@endsection
@section('page_css')
{{--    <link href="{{ mix('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css"/>--}}
@endsection
@section('content')
    {{--    {{Form::hidden('super_admin_dashboard',true,['class'=>'super-admin-dashboard'])}}--}}
    <style>
        #four_block .shadow-md{
            height:100%;
        }
    </style>

    <div class="container-fluid">
        <div class="d-flex flex-column" id="four_block">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="row">
                        <a href="javascript:void(0)" class="btn btn-icon btn-primary me-5 ps-3 pe-2"
                        title="Switch Chart">
                            <span class="m-0 text-center" id="changeChart">
                                <i class="fas fa-chart-bar fs-1 chart"></i>
                            </span>
                        </a>
                        <div class="col-sm-3 mb-3">
                            <div class="input-group">
                                <label for="selectDate" class="form-label">{{ __('messages.dashboard.select_date') }}:</label>

                                <input type="text" class="form-control custom-width px-3" placeholder="Select date range" id="chartFilter">
                            </div>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label for="tele_id" class="form-label">{{ __('messages.select_telecaller') }}:</label>
                                <select name="tele_id" id="tele_id" class="form-select" data-control="select2">
                                    <option value="">{{ __('messages.select_telecaller') }}</option>
                                    @foreach($telecallers as $telecaller)
                                        <option value="{{ $telecaller->user_id }}">{{ $telecaller->fname }} {{ $telecaller->lname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <script>
                        $(document).ready(function() {

                                $('#tele_id').on('change', function() {

                                    var tele_id = $(this).val()

                                    $.ajax({
                                        url: "/super-admin/telecallerRecord",
                                        type: "GET",
                                        data: {
                                            startDate : $('#chartFilter').data('daterangepicker').startDate.format('YYYY-MM-DD'),
                                            endDate : $('#chartFilter').data('daterangepicker').endDate.format('YYYY-MM-DD'),
                                            tele_id : tele_id,
                                        },
                                        success: function(response) {
                                            $('#convertedLeadsCount').html(response.telecount);
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.error('Error fetching data:', textStatus, errorThrown);
                                        }
                                    });
                                });

                                });

                        </script>

                </div>
                    <div class="row">
                        <div class="col-xxl-6 col-xl-4 col-sm-6 widget">
                            <a href="{{route('super.admin.hospitals.index') }}"
                                class="text-decoration-none super-admin-lead-report">
                                <div class="  shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2" style="background-color: #701470;">
                                    <div style="background-color: #320a36!important;" class=" widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-hospital fs-1-xl text-white"></i>
                                    </div>
                                    <div class="text-end text-white">
                                        <h2 class="fs-1-xxl fw-bolder text-white" id="uploadedLeadsCount">{{formatCurrency($data['total_uploaded_leads'])}}</h2>
                                        <h3 class="mb-0 fs-5 fw-light text-white">{{ __('messages.uploaded_leads') }}</h3>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-xxl-6 col-xl-4 col-sm-6 widget">
                                <div style="background-color: #701470;" class="  shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                    <div style="background-color: #320a36!important;" class=" widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-hospital fs-1-xl text-white"></i>
                                    </div>

                                    <div class="text-end text-white">
                                        <h2 class="fs-1-xxl fw-bolder text-white" id="convertedLeadsCount">{{formatCurrency($data['total_converted_leads'], 2)}}</h2>
                                        <h3 class="mb-0 fs-5 fw-light text-white">{{ __('messages.converted_leads') }}</h3>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-lg-12 col-xl-3 col-md-12 col-sm-12">
                    <h1>{{ __('messages.dashboard.lead_report') }}</h1>
                </div>
            </div>

            <div class="row">
                <div id="hospitalLeadChart"></div>
            </div>

        </div>
    </div>

@endsection
