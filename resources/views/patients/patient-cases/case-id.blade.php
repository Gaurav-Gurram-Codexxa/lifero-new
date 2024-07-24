@if(!Auth::user()->hasRole('Patient|Nurse|Case Manager|Accountant'))
    <a href="{{route('patient_case_show', ['patient_case' => $row->id])}}"><span
                class="badge bg-light-info">{{ $row->case_id}}</span></a>
@else
<a href="{{route('patient_case_show', ['patient_case' => $row->id])}}"><span
                class="badge bg-light-info">{{ $row->case_id}}</span></a>
@endif
