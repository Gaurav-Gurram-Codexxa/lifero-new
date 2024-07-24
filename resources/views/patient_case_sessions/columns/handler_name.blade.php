<div class="d-flex align-items-center">
    @if(Auth::user()->hasRole('Patient|Case Manager'))
            <div class="image image-mini me-3">
            <div>
                <img src="{{ $row->case_handler->user->imageUrl }}" alt="" class="user-img image image-circle object-contain" width="35px" height="35px">
            </div>
        </div>
        <div class="d-flex flex-column">
            <span class="mb-1 text-dark text-decoration-none object-contain">{{ $row->case_handler->user->full_name }}</span>
            <span>{{ $row->case_handler->user->email }}</span>
        </div>
    @else
        <div class="image image-circle image-mini me-3">
            <a href="{{ url('case-handlers',$row->case_handler->id) }}">
                <div>
                    <img src="{{ $row->case_handler->user->imageUrl }}"
                         alt=""
                         class="user-img image image-circle object-contain" width="35px" height="35px">
                </div>
            </a>
        </div>
        <div class="d-flex flex-column">
            <a href="{{ url('case-handlers',$row->case_handler->id) }}"
               class="mb-1 text-decoration-none">{{ $row->case_handler->user->full_name }}</a>
            <span>{{ $row->case_handler->user->email }}</span>
        </div>
    @endif
</div>
