@if ($row->is_paid == App\Models\BillTransaction::PAID)
    <span class="badge bg-light-success">{{ __('messages.invoice.paid') }}</span>
@else
    <span class="badge bg-light-danger">{{ __('messages.employee_payroll.unpaid') }}</span>
@endif
