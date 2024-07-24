<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="icon" href="{{ asset('web/img/hms-saas-favicon.ico') }}" type="image/png">
    <title>{{ __('messages.bill.bill') }}</title>
    <link href="{{ asset('assets/css/bill-pdf.css') }}" rel="stylesheet" type="text/css" />
    @if (getCurrentCurrency() == 'inr')
        <style>
            body {
                font-family: DejaVu Sans, sans-serif !important;
            }
        </style>
    @endif
    <style>
        * {
            font-family: DejaVu Sans, Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
        }
    </style>
</head>

<body>
    <table width="100%" class="mb-20">
        <table width="100%">
            <tr>
                <td class="header-left">
                    <div class="main-heading">{{ __('messages.bill.bill') }}</div>
                    <div class="invoice-number font-color-gray">{{ __('messages.bill.bill_id') }}
                    #{{ $bill->bill_id }} <br>
                    {{ \Carbon\Carbon::parse($bill->bill_date)->format('jS M,Y g:i A') }}
                </div>
                </td>
                <td class="header-right">
                    <div class="logo"><img width="150px" src="{{ $setting['app_logo'] }}" alt=""></div>
                    <div class="hospital-name">Lifero Skin & Hair Clinic</div>
                    <!--<div class="hospital-name font-color-gray">Allankit Villa, near Hotel Imperio, Baner, Pune, Maharashtra</div>-->
                </td>
            </tr>
        </table>
        <hr>
        <div class="">
            <table class="table w-100">
                <tbody>
                    <tr>
                        <td class="desc vertical-align-top bg-light">
                            <table class="table w-100">



                                <tr class="lh-2">
                                    <td class="">
                                        <label for="name"
                                            class="pb-2 fs-5 font-weight-bold me-1">{{ __('messages.investigation_report.patient') }}:</label>
                                        {{ $bill->patient->user->full_name }}
                                    </td>

                                </tr>



                                <tr class="lh-2">
                                    <td class="">
                                        <label for="name"
                                            class="pb-2 fs-5 font-weight-bold me-1">{{ __('messages.user.email') }}:</label>
                                        {{ $bill->patient->user->email }}
                                    </td>

                                </tr>


                                <tr class="lh-2">
                                    <td class="">
                                        <label for="name"
                                            class="pb-2 fs-5 font-weight-bold me-1">{{ __('messages.bill.cell_no') }}:</label>
                                        {{ !empty($bill->patient->user->phone) ? $bill->patient->user->region_code.$bill->patient->user->phone : __('messages.common.n/a') }}
                                    </td>

                                </tr>

                                <tr class="lh-2">
                                    <td class="">
                                        <label for="name"
                                            class="pb-2 fs-5 font-weight-bold me-1">{{ __('messages.user.gender') }}:</label>
                                        {{ $bill->patient->user->gender == 0 ? 'Male' : 'Female' }}
                                    </td>

                                </tr>

                                <tr class="lh-2">
                                    <td class="">
                                        <label for="name"
                                            class="pb-2 fs-5 font-weight-bold me-1">{{ __('messages.user.dob') }}:</label>
                                        {{ !empty($bill->patient->user->dob) ? Datetime::createFromFormat('Y-m-d', $bill->patient->user->dob)->format('jS M, Y g:i A') : 'N/A' }}
                                    </td>

                                </tr>




                            </table>
                        </td>
                        <td style="width:2%;">
                        </td>
                        <td class="text-end desc ms-auto vertical-align-top bg-light">
                            <table class="table w-100">


                            <tr class="lh-2">
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
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table w-100">
                <tr>
                    <td colspan="2">
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.bill.item_name') }}</th>
                                    <th class="number-align">{{ __('messages.bill.qty') }}</th>
                                    <th class="number-align">{{ __('messages.bill.price') }}
                                        (<b>{{ getAPICurrencySymbol() }}</b>)
                                    </th>
                                    <th class="number-align">{{ __('messages.bill.amount') }}
                                        (<b>{{ getAPICurrencySymbol() }}</b>)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($bill) && !empty($bill))
                                    @foreach ($bill->billItems as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{-- {{ $item->item_name }} --}}
                                                @php
                                                $opening_parenthesis_position = strpos($item->item_name, '(');
                                                $closing_parenthesis_position = strpos($item->item_name, ')');

                                               if ($opening_parenthesis_position !== false && $closing_parenthesis_position !== false) {
                                                   $first_part = substr($item->item_name, 0, $opening_parenthesis_position);
                                                   echo nl2br(trim($first_part)) . "<br>";
                                                   $part_in_parenthesis = substr($item->item_name, $opening_parenthesis_position, $closing_parenthesis_position - $opening_parenthesis_position + 1);
                                                   echo nl2br(trim($part_in_parenthesis)) . "<br>";
                                                   $rest_of_string = substr($item->item_name, $closing_parenthesis_position + 1);
                                                   $parts = preg_split('/(\([^)]+\))/', $rest_of_string, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

                                                   foreach ($parts as $index => $part) {
                                                       $formatted_part = strtoupper(str_replace('_', ' ', trim($part)));
                                                       echo nl2br($formatted_part) . "<br>";
                                                   }
                                               }
                                               else
                                               {
                                                   echo $item->item_name;
                                               }

                                               @endphp
                                            </td>
                                            <td class="number-align">{{ $item->qty }}</td>
                                            <td class="number-align">{{ number_format($item->price, 2) }}</td>
                                            <td class="number-align">{{ number_format($item->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <table class="bill-footer">
                            <tr>
                                <td class="font-weight-bold">{{ __('messages.bill.total_amount') . ':' }}</td>
                                <td>{{ getCurrencyFormatForPDF($bill->tax_amount) }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('messages.bill.total_amount') . ':' }}</td>
                                <td>{{ getCurrencyFormatForPDF($bill->amount) }}</td>
                            </tr>
                        </table>

                        {{-- <table class="bill-footer">
                            <tr class="border-bottom fs-6 fw-bolder text-muted">
                                <th class="min-w-70px">{{ __('messages.sub_total').(':') }} </th>
                                <td class="text-gray-700 text-end">{{ getCurrencyFormat($bill->sub_amount) }}</td>
                            </tr>

                            @foreach($taxList as $tx)
                            <tr class="border-bottom fs-6 fw-bolder text-muted">
                                <th class="min-w-70px">{{ $tx->name }} ({{ $tx->rate }}%)</th>
                                <td class="text-end text-gray-700 ">{{ ($tx->rate / 100) * $bill->sub_amount }}</td>
                            </tr>
                            @endforeach

                            <tr class="border-bottom fs-6 fw-bolder text-muted">
                                <th class="min-w-70px">{{ __('messages.bill.total_amount').(':') }}</th>
                                <td class="text-dark fw-boldest">{{ getCurrencyFormat($bill->amount) }}</td>
                            </tr>
                    </table> --}}

                    </td>
                </tr>
            </table>
        </div>
    </table>


</body>

</html>
