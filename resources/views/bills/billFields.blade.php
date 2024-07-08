<div class="row">
    {{ Form::hidden('search', route('patients.search'), ['class' => 'searchPatient']) }}
    <div class="form-group col-sm-6 mb-5">
        <label for="patient_name" class="form-label d-flex justify-content-between">
            <span>Patient:<span class="required"></span></span>
        </label>

        <select name="patient_id" class="form-select" id="appointmentsPatientId" placeholder={{__('messages.document.select_patient')}} data-control="select2" required>   
        @if(isset($patient))
            <option value="{{$patient->id}}" selected>{{$patient->text}}</option>
            @endif
        </select>
    </div>
    {{ Form::hidden('patient_admission_id', '0', ['id' => 'pAdmissionId']) }}

    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('bill_date', __('messages.bill.bill_date').(':'),['class'=>'form-label']) }}
        <span class="required"></span>
        {{ Form::text('bill_date', $bill->bill_date->format('Y-m-d') ?? null, ['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'), 'id' => 'editBillDate', 'autocomplete' => 'off']) }}
    </div>

    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('due_date', 'Due Date:',['class'=>'form-label']) }}
        <span class="required"></span>
        {{ Form::text('due_date', $bill->due_date->format('Y-m-d') ?? null, ['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'), 'id' => 'editDueDate', 'autocomplete' => 'off']) }}
    </div>


    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('bill_date', __('messages.bill.amount').(':'),['class'=>'form-label']) }}
        <span class="required"></span>
        {{ Form::text('amount', $bill->amount ?? null, ['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'), 'id' => 'editBillAmount', 'autocomplete' => 'off','readonly']) }}
    </div>

    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('bill_date', __('messages.bill.paid_amount').(':'),['class'=>'form-label']) }}
        <span class="required"></span>
        {{ Form::text('paid_amount', $bill->paid_amount ?? null, ['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'), 'id' => 'editPaidAmount', 'autocomplete' => 'off','readonly']) }}
    </div>


    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('bill_date', __('messages.bill.due').(':'),['class'=>'form-label']) }}
        <span class="required"></span>
        {{ Form::text('due', ($bill->amount - $bill->paid_amount) ?? null, ['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'), 'id' => 'editDueAmount', 'autocomplete' => 'off','readonly']) }}
    </div>

    {{-- Pay Now Amount --}}

    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('bill_date', __('messages.bill.pay').(':'),['class'=>'form-label']) }}
        <span class="required"></span>
        {{ Form::text('payingAmount',($bill->amount - $bill->paid_amount) ?? null, ['class' =>  'bg-white form-control', 'id' => 'payAmount', 'autocomplete' => 'off']) }}
        <span id="error"></span>
    </div>

    <div class="form-group col-sm-6 mb-5">
        <label for="payment_method" class="form-label d-flex justify-content-between">
            <span>Payment Method :<span class="required"></span></span>
        </label>
        <select name="payment_method" class="form-select" id="paymentMethod" placeholder={{__('messages.document.select_payment_method')}} data-control="select2" required>   
            <option value="Cash">Cash</option>
            <option value="Online">Online</option>
            <option value="Check">Check</option>
        </select>
    </div>

    <script>
        $(document).ready(function (){
            var billAmount = $('#editBillAmount').val();
            var paidAmount = $('#editPaidAmount').val() || 0;
            $(document).on('click','#payNow',function (e){
                const enteredValue = $('#payAmount').val();
                if (enteredValue > (billAmount - paidAmount)) 
                {
                    $('#error').html('Error: Entered amount cannot be greater than the remaining bill amount.').css('color','red','size','5px');
                    $('#payAmount').css('border-color','red');
                    e.preventDefault();
                }    
                setTimeout(function() {
                        window.location.href = '/bills';
                }, 1000);
            })  

        });
    </script>
</div>

<!-- Submit Field -->
<div class="float-end">


    {{ Form::submit(__('messages.bill.pay'), ['class' => 'btn btn-primary','id' => 'payNow']) }}



    <a href="{{ route('bills.index') }}" class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
</div>