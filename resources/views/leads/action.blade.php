<div class="d-flex align-items-center">
    @if(auth()->user()->hasRole('Super Admin') || (auth()->user()->hasRole('Tele Caller')  ))
    <a href="{{ route('leads.edit',$row->id)}}" title="{{__('messages.common.edit') }}" class="edit-lead-btn btn px-1 text-primary fs-3 ps-0">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    @endif
    @role('Super Admin')
    <a href="javascript:void(0)" title="{{__('messages.common.delete')}}" data-id="{{ $row->id }}" class="lead-delete-btn btn px-2 text-danger fs-3 ps-0">
        <i class="fa-solid fa-trash"></i>
    </a>
    @endrole
</div>