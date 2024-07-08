<div class="d-flex align-items-center pb-10">
    <img alt="Logo" src="{{ asset(getLogoUrl()) }}" height="100px" width="100px">
    <a target="_blank" href="{{ route('bills.pdf',['bill' => $bill->id]) }}"
       class="btn btn-success ms-auto text-white">{{ __('messages.bill.print_bill') }}</a>
</div>
<div class="m-0">
    <div class="fs-3 text-gray-800 mb-8">{{ __('messages.bill.bill') }} #{{ $bill->bill_id }}</div>
    <div class="row g-5 mb-11">
        <div class="col-sm-3">
            <div class="pb-2 fs-5 text-gray-600">{{ __('messages.case.patient').':' }}</div>
            <div class="fs-5 text-gray-800">{{ $bill->patient->patientUser->full_name }}</div>
        </div>


        <div class="col-sm-3">
            <div class="pb-2 fs-5 text-gray-600">{{ __('messages.bill.bill_date').':' }}</div>
            <div class="fs-5 text-gray-800">{{ Carbon\Carbon::parse($bill->bill_date)->format('jS M, Y g:i A') }}</div>
        </div>

        <div class="col-sm-3">
            <div class="pb-2 fs-5 text-gray-600">{{ __('messages.bill.due_date').':' }}</div>
            <div class="fs-5 text-gray-800">{{ Carbon\Carbon::parse($bill->due_date)->format('jS M, Y g:i A') }}</div>
        </div>

        <div class="col-sm-3">
            <div class="pb-2 fs-5 text-gray-600">{{ __('messages.bill.patient_email').':' }}</div>
            <div class="fs-5 text-gray-800">{{ $bill->patient->patientUser->email }}</div>
        </div>
    </div>
    <div class="row g-5 mb-11">
        <div class="col-sm-3">
            <div class="pb-2 fs-5 text-gray-600">{{ __('messages.bill.patient_cell_no').':' }}</div>
            <div class="fs-5 text-gray-800">{{ !empty($bill->patient->patientUser->phone) ? $bill->patient->patientUser->region_code.$bill->patient->patientUser->phone : __('messages.common.n/a') }}</div>
        </div>
        <div class="col-sm-3">
            <div class="pb-2 fs-5 text-gray-600">{{ __('messages.bill.patient_gender').':' }}</div>
            <div class="fs-5 text-gray-800">{{ (!$bill->patient->patientUser->gender) ? __('messages.user.male') : __('messages.user.female') }}</div>
        </div>
        <div class="col-sm-3">
            <div class="pb-2 fs-5 text-gray-600">{{ __('messages.bill.patient_dob').':' }}</div>
            <div class="fs-5 text-gray-800">{{ (!empty($bill->patient->patientUser->dob)) ? \Carbon\Carbon::parse($bill->patient->patientUser->dob)->translatedFormat('jS M, Y') : __('messages.common.n/a') }}</div>
        </div>
       
    </div>

    <div class="flex-grow-1">
        <table class="table border-bottom-2">
            <thead>
            <tr class="border-bottom fs-6 fw-bolder text-muted">
                <th class="min-w-175px pb-2">{{ __('messages.bill.item_name') }}</th>
                <th class="min-w-70px text-end pb-2">{{ __('messages.bill.price') }}</th>
                <th class="min-w-70px text-end pb-2">{{ __('messages.bill.qty') }}</th>
                <th class="min-w-80px text-end pb-2">{{ __('messages.bill.amount') }}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($bill->billItems as $index => $billItem)
                <tr class="fw-bolder text-gray-700 fs-5 text-end">
                    <td class="d-flex align-items-center pt-6 text-gray-700 text-center">
                        
                        @php
                         $opening_parenthesis_position = strpos($billItem->item_name, '(');
                         $closing_parenthesis_position = strpos($billItem->item_name, ')');

                        if ($opening_parenthesis_position !== false && $closing_parenthesis_position !== false) {
                            $first_part = substr($billItem->item_name, 0, $opening_parenthesis_position);
                            echo nl2br(trim($first_part)) . "<br>"; 
                            $part_in_parenthesis = substr($billItem->item_name, $opening_parenthesis_position, $closing_parenthesis_position - $opening_parenthesis_position + 1);
                            echo nl2br(trim($part_in_parenthesis)) . "<br>";
                            $rest_of_string = substr($billItem->item_name, $closing_parenthesis_position + 1);
                            $parts = preg_split('/(\([^)]+\))/', $rest_of_string, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
                        
                            foreach ($parts as $index => $part) {
                                $formatted_part = strtoupper(str_replace('_', ' ', trim($part)));
                                echo nl2br($formatted_part) . "<br>";
                            }
                        } 
                        else {
                            echo $billItem->item_name;
                        }

                        @endphp

                    </td>

                    <td class="pt-6 text-gray-700">
                        {{ getCurrencyFormat($billItem->price) }}</td>
                    <td class="pt-6 text-gray-700">{{ $billItem->qty }}</td>
                    <td class="pt-6 text-dark fw-boldest">
                        {{ getCurrencyFormat($billItem->amount) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end">
        <div class="mw-300px">
            <div class="d-flex flex-stack">
                <div class="fw-bold pe-10 text-gray-600 fs-7">{{ __('messages.bill.total_amount').(':') }}</div>
                <div class="text-end fs-5 text-gray-800">{{ getCurrencyFormat($bill->amount) }}</div>
            </div>
        </div>
    </div>
</div>
