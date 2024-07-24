<div class="d-flex align-items-center mt-2">
    @if($row->discharge_date === null)
        N/A
    @else
        <div class="badge bg-light-info">
            <div>{{ \Carbon\Carbon::parse($row->discharge_date )->translatedFormat('jS M, Y') }}</div>
        </div>
    @endif    
</div>

