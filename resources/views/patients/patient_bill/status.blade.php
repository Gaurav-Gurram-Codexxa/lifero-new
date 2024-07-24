@php
    $mytime = \Carbon\Carbon::now();
@endphp

@if ($mytime->greaterThan($row->due_date) && !in_array($row->status, [1, 2]))
    <span class="badge bg-light-danger">{{ __('messages.bill.overdue') }}</span>

@elseif ($row->status == 0 || empty($row->status))
    <span class="badge bg-light-danger">{{ __('messages.employee_payroll.unpaid') }}</span>

@elseif ($row->status == 2)
    <span class="badge bg-light-info">{{ __('messages.appointment.pending') }}</span>

@elseif ($row->status == 1)
    <span class="badge bg-light-success">{{ __('messages.invoice.paid') }}</span>
@endif


<input type="hidden" value="{{ $row->amount }}" class="bill-amount">
<input type="hidden" value="{{ $row->id }}" class="bill-id">
