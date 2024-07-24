
@if(isset($row->patient_status))
    @if ($row->patient_status == 1)
        <span class="badge bg-light-success">{{ __('messages.filter.active') }}</span>
    @else
        <span class="badge bg-light-danger">{{ __('messages.filter.deactive') }}</span>
    @endif
@else
    N/A
@endif
