<div class="d-flex align-items-center">
    <a href="{{ route('tele-callers.edit',$row->id)}}" title="{{__('messages.common.edit') }}"
       class="edit-tele-caller-btn btn px-1 text-primary fs-3 ps-0">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    <a href="javascript:void(0)" title="{{__('messages.common.delete')}}" data-id="{{ $row->id }}"
       class="tele-caller-delete-btn btn px-2 text-danger fs-3 ps-0">
        <i class="fa-solid fa-trash"></i>
    </a>
</div>
