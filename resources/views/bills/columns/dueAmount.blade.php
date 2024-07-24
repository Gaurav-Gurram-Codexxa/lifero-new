@if($row->amount - $row->paid_amount !=0)
    <div class="d-flex justify-content-end">
        {{getCurrencyFormat($row->amount - $row->paid_amount)}}
    </div>
@endif