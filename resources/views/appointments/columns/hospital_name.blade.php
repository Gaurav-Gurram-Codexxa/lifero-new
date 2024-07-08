<div class="d-flex align-items-center justify-content-end mt-2">
   
{{-- @if(auth()->user()->hasRole('Super Admin')) --}}
    @if(!empty($row->hname))
        <p class="cur-margin text-end me-5">{{ $row->hname }}
    @endif  
{{-- @endif --}}

</div>

