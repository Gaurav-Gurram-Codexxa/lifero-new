@if($row->status == null || $row->status == '2  ')
<a href="{{ route('bills.payedit',$row->id) }}" title="<?php echo __('messages.bill.pay') ?>"
    class="btn btn-primary">Pay</a>
@endif