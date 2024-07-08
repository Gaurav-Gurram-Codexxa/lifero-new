@if(auth()->user()->hasAnyRole(['Admin', 'Doctor', 'Patient', 'Case Manager']))
<a href="{{route('case-sessions.edit', ['case_session' => $row->session_id])}}" title="{{__('messages.common.edit') }}" data-id="{{ $row->session_id }}"
   class="btn px-1 text-primary fs-3 ps-0">
    <i class="fa-solid fa-pen-to-square"></i>
</a>
@endif