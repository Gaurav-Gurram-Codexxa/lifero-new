<?php
$bg = [
        0 => 'danger',
        1 => 'success',
        2 => 'warning'
];
$status = [
        0 => 'Not Paid',
        1 => 'Paid',
        2 => 'In Progress'
]
?>

<div class="d-flex justify-content-center">
    <span class="badge bg-light-{{$bg[$row->payment_status]}}">{{$status[$row->payment_status]}}</span>
</div>
