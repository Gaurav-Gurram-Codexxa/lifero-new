<div class="d-flex align-items-center justify-content-end mt-2">
    @if(!empty($row->new_patient_charge))
        <p class="cur-margin">
              {{ getCurrencyFormat($row->new_patient_charge) }}
        </p>
    @else
        {{ __('messages.common.n/a')}}
    @endif
</div>

