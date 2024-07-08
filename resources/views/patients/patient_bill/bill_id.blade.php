@if(Auth::user()->hasRole('Admin'))
    <a href="{{ url('bills',$row->id) }}">
        <span class="badge bg-light-info">{{ $row->id }}</span></a>
@elseif(Auth::user()->hasRole('Patient'))
    <a href="{{ url('employee/bills',$row->id) }}">
        <span class="badge bg-light-info">{{ $row->id }}</span></a>
@elseif(Auth::user()->hasRole('Accountant'))
    <a href="{{ url('bills',$row->id) }}">
        <span class="badge bg-light-info">{{ $row->id }}</span></a>
@else
    <span class="badge bg-light-info">{{ $row->id }}</span>
@endif
