<div class="d-flex align-items-center mt-3">
    @if(getLoggedinPatient())
        <a data-id="{{$row->id}}" href="{{url('patient'.'/'.'my-cases'.'/'.$row->id)}}"
           class="badge bg-light-primary text-decoration-none">{{$row->case_id}}</a>
    @else
        <a href="{{route('patient_case_show', ['patient_case' => $row->id])}}"
           class="badge bg-light-info cursor-pointer text-decoration-none">{{$row->case_id}}</a>
    @endif
</div>


