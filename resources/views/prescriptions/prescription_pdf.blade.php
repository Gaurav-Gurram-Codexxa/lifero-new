<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="icon" href="{{ asset('web/img/hms-saas-favicon.ico') }}" type="image/png">
    <title>{{ __('messages.new_change.prescription_report') }}</title>
    <link href="{{ asset('assets/css/prescription-pdf.css') }}" rel="stylesheet" type="text/css" />
    <style>
        * {
            font-family: DejaVu Sans, Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
        }

        @page {
            margin: 20px 0 !important;
        }

        .w-100 {
            width: 100%;
        }

        .w-50 {
            width: 50% !important;
        }

        .text-end {
            text-align: right !important;

        }

        .text-center {
            text-align: center !important;

        }

        .ms-auto {
            margin-left: auto !important;
        }

        .px-30 {
            padding-left: 30px;
            padding-right: 30px;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .lh-1 {
            line-height: 1 !important;
        }

        .company-logo {
            margin: 0 auto;
        }

        .company-logo img {
            width: auto;
            height: 80px;
        }

        .vertical-align-top {
            vertical-align: top !important;
        }

        .desc {
            padding: 10px;
            border-radius: 10px;
            width: 48%;
        }

        .physical-desc {
            border-radius: 10px;
            width: 8%;
        }

        .bg-light {
            background-color: #f8f9fa;
        }

        hr {
            margin: 15px 20px;
            color: #f8f9fa;
            background-color: #f8f9fa;
            border-color: #f8f9fa;

        }

        .fw-6 {
            font-weight: bold;
        }

        .fw-l {
            font-weight: light;
        }

        .mb-20 {
            margin-bottom: 15px;
        }

        .heading {
            padding: 10px;
            background-color: #f8f9fa;
            width: 250px;
        }

        .physical-data {
            padding: 10px;
            background-color: #f8f9fa;
            width: 328px;
        }
        .pe-0{
            padding-right: 0;
            padding-left: 30px;
        }
    </style>
</head>

<body>
    <div class="px-30">
        <table>
            <tbody>
                <tr>
                    <td class="company-logo">
                        <img src="{{ $data['app_logo'] }}" alt="user">
                    </td>
                    
                    <td class="px-30" >
                        <h3 class="mb-0 lh-1" style="margin-left:230px">
                            {{ !empty($prescription['prescription']->doctor->doctorUser->full_name) ? $prescription['prescription']->doctor->doctorUser->full_name : '' }}
                        </h3>
                        <div class="fs-5 text-gray-600 fw-light mb-0 lh-1" style="margin-left:230px">
                            {{ !empty($prescription['prescription']->doctor->specialist) ? $prescription['prescription']->doctor->specialist : '' }}
                            
                            <br>
                            
                           Reg.No : {{ !empty($prescription['prescription']->doctor->registration_no) ? $prescription['prescription']->doctor->registration_no : '' }}

                            
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
              {{ !empty(\Carbon\Carbon::parse($prescription['prescription']->created_at)->isoFormat('DD/MM/Y')) ? \Carbon\Carbon::parse($prescription['prescription']->created_at)->isoFormat('DD/MM/Y') : '' }}
    </div>
    <hr>

    
    <div class="px-30">
        <table class="table w-100 mb-20">
            <tbody>
                <tr>
                    <td class="desc vertical-align-top bg-light">
                        <label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.bill.patient_name') }}:</label>
                                        
                         {{ !empty($prescription['prescription']->patient->patientUser->full_name) ? $prescription['prescription']->patient->patientUser->full_name : '' }}
                    
                    <br>
                            @if ($prescription['prescription']->patient->user->dob)
                    
                                        <label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.blood_donor.age') }}:</label>
                                        {{ \Carbon\Carbon::parse($prescription['prescription']->patient->user->dob)->diff(\Carbon\Carbon::now())->y }}
                                        {{ __('messages.new_change.years') }}
                    
                            @endif
                    <br>

                            <label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.user.gender') }}:</label>
                                        
                            {{ $prescription['prescription']->patient->user->gender == '0' ? 'Male' : 'Female'}}

                    <br>
                    
                            <label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.user.phone') }}:</label>
                                        
                            {{ !empty($prescription['prescription']->patient->user->phone) ? $prescription['prescription']->patient->user->phone : '' }}
                            

                    <br>

                            <label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.common.address') }}:</label>
                                        
                            {{ !empty($prescription['prescription']->patient->user->city) ? $prescription['prescription']->patient->user->city : '' }}

                    </td>
                    
                    <td style="width:2%;">
                    </td>
                    <td class="text-end desc ms-auto vertical-align-top bg-light">
                        <table class="table w-100">
                            
                            <tr class="">
                                     <td class="">
                                          <!--<label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.hospitals_list.hospital_name') }}:</label>-->
                                                            
                                                <b>{{ !empty($hospital) ? $hospital->hospital_name : '' }}</b>
                                                
                                        <br>
                                         
                                                <!--<label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.user.city') }}:</label>-->
                                                {{ !empty($hospital) ? $hospital->city : '' }}

                                        <br>
                    
                                                <!--<label for="name" class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.user.phone') }}:</label>-->
                                                            
                                                {{ !empty($hospital) ? $hospital->region_code : '' }}-{{ !empty($hospital) ? $hospital->phone : '' }}
                                    </td>
                            </tr>
                            
                            
                        </table>
                        {{-- <div class="d-flex flex-row">
                                <label for="name"
                                    class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.prescription.prescription_date') }}:</label>
                                <span class="fs-5 text-gray-800">
                                    {{ !empty(\Carbon\Carbon::parse($prescription['prescription']->created_at)->isoFormat('DD/MM/Y')) ? \Carbon\Carbon::parse($prescription['prescription']->created_at)->isoFormat('DD/MM/Y') : '' }}
                                </span>
                            </div> --}}
                        {{-- @if ($prescription['prescription']->patient->user->dob)
                                <div class="d-flex flex-row">
                                    <label for="name"
                                        class="pb-2 fs-5 text-gray-600 me-1">{{ __('messages.blood_donor.age') }}:</label>
                                    <span class="fs-5 text-gray-800">
                                        {{ \Carbon\Carbon::parse($prescription['prescription']->patient->user->dob)->diff(\Carbon\Carbon::now())->y }}
                                        {{ __('years') }}
                                    </span>
                                </div>
                            @endif --}}

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<div class="">
    <table class="table w-100 mb-20" width="100%">
        <tbody>
            <tr>
                <td width="4%" class=""></td>
                <td class="">
                    @if (!empty($prescription['prescription']->food_allergies))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.food_allergies') }}:
                                    <span class="text-gray-600 mb-2 fs-4 fw-l">
                                        {{ $prescription['prescription']->food_allergies }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->tendency_bleed))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.tendency_bleed') }}:
                                    <span class="text-gray-600 mb-2 fs-4 fw-l">
                                        {{ $prescription['prescription']->tendency_bleed }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->heart_disease))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.heart_disease') }}:
                                    <span class="text-gray-600 mb-2 fs-4 fw-l">
                                        {{ $prescription['prescription']->heart_disease }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->high_blood_pressure))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.high_blood_pressure') }}:
                                    <span class="text-gray-600 mb-2 fs-4 fw-l">
                                        {{ $prescription['prescription']->high_blood_pressure }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->diabetic))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.diabetic') }}:
                                    <span class="text-gray-600 mb-2 fs-4 fw-l">
                                        {{ $prescription['prescription']->diabetic }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->surgery))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.surgery') }}:
                                    <span class="text-gray-600 mb-2 fs-4 fw-l">
                                        {{ $prescription['prescription']->surgery }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->accident))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.accident') }}:
                                    <span
                                        class="text-gray-600 mb-2 fs-4 fw-l">{{ $prescription['prescription']->accident }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->others))
                        <div class="">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.others') }}:
                                    <span class="text-gray-600 mb-2 fs-4 fw-l">
                                        {{ $prescription['prescription']->others }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </td>
                <td class="">
                    @if (!empty($prescription['prescription']->medical_history))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.new_change.added_at') }}:
                                    <span class="text-gray-600 mb-2 fs-4 fw-l">
                                        {{ $prescription['prescription']->medical_history }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->current_medication))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.current_medication') }}:
                                    <span
                                        class="text-gray-600 mb-2 fs-4 fw-l">{{ $prescription['prescription']->current_medication }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->female_pregnancy))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.female_pregnancy') }}:
                                    <span class="text-gray-600 mb-2 fs-4 fw-l">
                                        {{ $prescription['prescription']->female_pregnancy }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->breast_feeding))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.breast_feeding') }}:
                                    <span
                                        class="text-gray-600 mb-2 fs-4 fw-l">{{ $prescription['prescription']->breast_feeding }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->plus_rate))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.plus_rate') }}:
                                    <span
                                        class="text-gray-600 mb-2 fs-4 fw-l">{{ $prescription['prescription']->plus_rate }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->temperature))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.temperature') }}:
                                    <span
                                        class="text-gray-600 mb-2 fs-4 fw-l">{{ $prescription['prescription']->temperature }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($prescription['prescription']->problem_description))
                        <div class="mb-20">
                            <div class="physical-data">
                                <div class="fw-6">
                                    {{ __('messages.prescription.problem_description') }}:
                                    <span
                                        class="text-gray-600 mb-2 fs-4 fw-l">{{ $prescription['prescription']->problem_description }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </td>
                <td width="2%" class=""></td>
            </tr>
        </tbody>
    </table>
</div>

    @if ($prescription['prescription']->problem_description != null)
        <div class="mb-20 px-30">
            <div class="heading">
                <div class="fw-6">{{ __('messages.prescription.problem') }}:</div>
            </div>
            <div class="">
                <p class="text-gray-600 mb-2 fs-4">{{ $prescription['prescription']->problem_description }}</p>
            </div>
        </div>
    @endif
    @if ($prescription['prescription']->test != null)
        <div class="mb-20 px-30">
            <div class="heading">
                <div class="fw-6">{{ __('messages.prescription.test') }}:</div>
            </div>
            <div class="">
                <p class="text-gray-600 mb-2 fs-4">{{ $prescription['prescription']->test }}</p>
            </div>
        </div>
    @endif
    @if ($prescription['prescription']->advice != null)
        <div class="mb-20 px-30">
            <div class="heading">
                <div class="fw-6">{{ __('messages.prescription.advice') }}:</div>
            </div>
            <div class="">
                <p class="text-gray-600 mb-2 fs-4">{{ $prescription['prescription']->advice }}</p>
            </div>
        </div>
    @endif


    <div class="px-30">
        <div class="heading mb-20">
            <div class="fw-6">{{ __('messages.prescription.rx') }}:</div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th scope="col">{{ __('messages.prescription.medicine_name') }}</th>
                    <th scope="col">{{ __('messages.ipd_patient_prescription.dosage') }}</th>
                    <th scope="col">{{ __('messages.prescription.duration') }}</th>
                    <th scope="col">{{ __('messages.medicine_bills.dose_interval') }}</th>
                </tr>
            </thead>
            <tbody>
                @if (empty($medicines))
                    {{ __('messages.common.n/a') }}
                @else
                    @foreach ($prescription['prescription']->getMedicine as $medicine)
                        @foreach ($medicine->medicines as $medi)
                            <tr>
                                <td class="py-4 border-bottom-0">{{ $medi->name }}</td>
                                <td class="py-4 border-bottom-0">
                                    {{ $medicine->dosage }}
                                    @if ($medicine->time == 0)
                                        (After Meal)
                                    @else
                                        (Before Meal)
                                    @endif
                                </td>
                                <td class="py-4 border-bottom-0">{{ $medicine->day }} {{ __('messages.day') }}
                                </td>
                                <td class="py-4 border-bottom-0">
                                    {{ App\Models\Prescription::DOSE_INTERVAL[$medicine->dose_interval] }}</td>
                            </tr>
                        @break

                    @endforeach
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<div class="px-30">
    <table width="100%">
        <tr>
            <td class="header-left">
                @if ($prescription['prescription']->next_visit_qty != null)
                    <h4>
                        {{ __('messages.prescription.next_visit') }} :
                        {{ $prescription['prescription']->next_visit_qty }}
                        @if ($prescription['prescription']->next_visit_time == 0)
                            {{ __('messages.prescription.days') }}
                        @elseif($prescription['prescription']->next_visit_time == 1)
                            {{ __('messages.month') }}
                        @else
                            {{ __('messages.year') }}
                        @endif
                    </h4>
                @endif
            </td>
            <td class="header-right">
                <h3 class="mb-0 lh-1">
                    {{ !empty($prescription['prescription']->doctor->doctorUser->full_name) ? $prescription['prescription']->doctor->doctorUser->full_name : '' }}
                </h3>
                <div class="fs-5 text-gray-600 fw-light mb-0 lh-1">
                    {{ !empty($prescription['prescription']->doctor->specialist) ? $prescription['prescription']->doctor->specialist : '' }}
                </div>
            </td>
        </tr>
    </table>
</div>
</div>
</body>
