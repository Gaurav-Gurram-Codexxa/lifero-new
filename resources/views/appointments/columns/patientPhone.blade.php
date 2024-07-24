<div class="d-flex align-items-center justify-content-end mt-2">
    @if(!empty($row->patient->patientUser->phone))
        <p class="cur-margin text-end me-5">{{$row->patient->patientUser->phone}}
    @endif  
</div>
                
                