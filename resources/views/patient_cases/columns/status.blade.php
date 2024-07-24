<?php
$bg = [
        0 => 'warning',
        1 => 'warning',
        2 => 'info',
        3 => 'success'
];
$status = [
        0 => 'Pending',
        1 => 'Pending',
        2 => 'In Progress',
        3 => 'Closed'
]
?>

<div class="d-flex justify-content-center">
        <span class="badge bg-light-{{$bg[$row->status]}}">{{$status[$row->status]}}</span>
</div>