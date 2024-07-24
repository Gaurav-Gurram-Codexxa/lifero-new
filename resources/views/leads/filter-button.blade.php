@php
use App\Models\TeleCaller;
$telecallers = DB::table('tele_callers')
        ->join('users', 'tele_callers.user_id', '=', 'users.id')
        ->select('users.id as uid', 'users.first_name as fname','users.last_name as lname')
        ->get();
@endphp
<div class="ms-0 ms-md-2" >
    <div class="dropdown d-flex align-items-center me-4 me-md-5" >
        <select class="form-select status-selector" wire:model="telecallerFilter" name="status">
            <option value="">Select Telecaller</option>
            @foreach ($telecallers as $t)
                <option value={{ $t->uid }}>{{ $t->fname }} {{ $t->lname }}</option>
            @endforeach
         </select>
    </div>
</div>
