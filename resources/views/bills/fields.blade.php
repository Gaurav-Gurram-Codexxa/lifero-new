<div class="row">   
                 <div id="bill_paying_modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">Add New Bills</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                    <div class="col-md-12">
                                        <div class="form-group mb-5">
                                            <div class="d-flex align-items-center" style="justify-content: space-evenly;">
                                                <div class="form-check">
                                                    <label class="form-label" for="malePatient">Consultation</label>&nbsp;&nbsp;
                                                    <input class="form-check-input" tabindex="6" id="modal-consultation" checked="checked" name="modal-newBill" type="radio" value="0"  onclick="show1();">
                                                    &nbsp;
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-label" for="femalePatient">Case Session</label>
                                                    <input class="form-check-input" tabindex="7" id="modal-caseSession" name="modal-newBill" type="radio" value="1"  onclick="show2();">
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-label" for="femalePatient">Others</label>
                                                    <input class="form-check-input" tabindex="7" id="modal-other" name="modal-newBill" type="radio" value="1"  onclick="show3();">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="for_consultation">
                                            <!-- Doctor Name Field -->
                                            <div class="form-group col-sm-6 mb-5">
                                                {{ Form::label('doctor_name', __('messages.case.doctor').':', ['class' => 'form-label']) }}
                                                <span class="required"></span>
                                                {{ Form::select('doctor_id',(isset($doctors) ? $doctors : []), null, ['class' => 'form-select','id' => 'billDoctorId1','placeholder'=> __('messages.web_appointment.select_doctor'), 'data-control' => 'select2']) }}
                                            </div>

                                            <div class="form-group col-sm-12 mb-5">
                                                {{ Form::label('consultation_time', __('messages.doctor_opd_charge.consultation_type').':', ['class' => 'form-label']) }}
                                                <span class="required"></span>
                                                <select name="consultation_time" class="form-select" id="consultationTime" placeholder="{{ __('messages.document.select_patient') }}" data-control="select2" >
                                                    <option value="Select" selected>Select Consultation</option>
                                                    <option value="new_patient_charge">New Consultation</option>
                                                    <option value="standard_charge">Existing Consultation</option>
                                                </select>
                                            </div>

                                            <style>
                                                .amt_label{
                                                    margin-right:20px;
                                                }
                                            </style>
                                           <div class="col-md-6">
                                             <div class="d-flex">
                                                <div class="amt_label">
                                                    <h4 style="font-weight:400">Total Amount: </h4>
                                                </div>
                                                <div class="amt_digit">
                                                    <strong><h4 style="" id="charges">Rs.0</h4></strong>
                                                </div>
                                            </div>
                                           </div>
                                        <div class="modal-footer pt-0">
                                            <button type="button" class="btn btn-primary m-0" id="addSelectedItem" >Add</button>
                                            <button type="button" aria-label="Close" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>

                                    <div id="for_casesession" style="display:none">

                                        <div class="form-group col-sm-12 mb-5">
                                            <div class="form-group col-sm-6 mb-5">
                                                {{ Form::label('case_title', __('messages.case.case').':', ['class' => 'form-label']) }}
                                                <span class="required"></span>
                                                {{ Form::select('case_id',(isset($caseList) ? $caseList : []), null, ['class' => 'form-select','id' => 'caseId','placeholder'=> __('messages.case.select_case'), 'data-control' => 'select2']) }}                                            
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-12 mb-5">
                                            {{ Form::label('sessionSelected', __('messages.doctor_opd_charge.selected_session').':', ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            <select name="selectedSessions" class="form-select" id="selectedSessions" data-control="select2" >
                                            </select>

                                        </div>
                                            <style>
                                                .amt_label{
                                                    margin-right:20px;
                                                }
                                            </style>
                                           <div class="col-md-6">
                                             <div class="d-flex">
                                                <div class="amt_label">
                                                    <h5 style="font-weight:400">Total Amount: </h5>
                                                </div>
                                                <div class="amt_digit">
                                                    <strong><h5 style="" id="sessionFee">Rs.0</h5></strong>
                                                    <strong><h5 style="" hidden id="mainCaseId"></h5></strong>
                                                    <strong><h5 style="" hidden id="packageName"></h5></strong>
                                                </div>
                                            </div>
                                           </div>

                                           <div class="modal-footer pt-0">
                                            <button type="button" class="btn btn-primary m-0" id="addSelectedCase" >Add</button>
                                            <button type="button" aria-label="Close" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>

                                    <div id="for_others" style="display:none">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-5">
                                            {{ Form::label('itemName', __('messages.doctor_opd_charge.item_name').':', ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            <input class="bg-white form-control "  autocomplete="off" name="other_item_name" id="other_item_name" type="text"  >
                                        </div>
                                         <div class="col-lg-12 col-md-12 col-sm-12 mb-5">
                                            {{ Form::label('other_item_charges', __('messages.doctor_opd_charge.charges').':', ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            <input class="bg-white form-control "  autocomplete="off" name="other_item_charges" id="other_item_charges" type="text"  >
                                        </div>
                                         <div class="col-md-6">
                                             <div class="d-flex">
                                                <div class="amt_label">
                                                    <h3 style="font-weight:400">Total Amount: </h3>
                                                </div>
                                                <div class="amt_digit">
                                                    <strong><h3 style="" id="totalAmount">Rs.0</h3></strong>
                                                </div>
                                            </div>
                                           </div>

                                           <div class="modal-footer pt-0">
                                            <button type="button" class="btn btn-primary m-0" id="addSelectedOtherItems" >Add</button>
                                            <button type="button" aria-label="Close" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>    
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- new popup[add bill] -->
    <script>
        function show1(){
        document.getElementById('for_consultation').style.display = 'block';
        document.getElementById('for_others').style.display ='none';
        document.getElementById('for_casesession').style.display = 'none';
        }
        function show2(){
        document.getElementById('for_consultation').style.display = 'none';
        document.getElementById('for_others').style.display ='none';
        document.getElementById('for_casesession').style.display = 'block';
        }
        function show3(){
        document.getElementById('for_consultation').style.display = 'none';
        document.getElementById('for_others').style.display ='block';
        document.getElementById('for_casesession').style.display = 'none';
        }
    </script>


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

    @if(isset($bill))
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
    @else
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('bill_date', __('messages.bill.bill_date').(':'),['class'=>'form-label']) }}
        <span class="required"></span>
        {{ Form::text('bill_date', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'), 'id' => 'bill_date', 'autocomplete' => 'off']) }}
    </div>
    
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5">
        {{ Form::label('due_date', 'Due Date:',['class'=>'form-label']) }}
        <span class="required"></span>
        {{ Form::text('due_date', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light form-control' : 'bg-white form-control'), 'id' => 'due_date', 'autocomplete' => 'off']) }}
    </div>
    @endif
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 myclass d-none">
        {{ Form::label('name', __('messages.case.patient').(':'),['class'=>'form-label']) }}
        {{ Form::text('name', 'N/A', ['class' => 'form-control', 'id' => 'name', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('email', __('messages.bill.patient_email').(':'),['class'=>'form-label']) }}
        {{ Form::text('email', 'N/A', ['class' => 'form-control', 'id' => 'userEmail', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('phone', __('messages.bill.patient_cell_no').(':'),['class'=>'form-label']) }}
        {{ Form::text('phone', 'N/A', ['class' => 'form-control', 'id' => 'userPhone', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('gender', __('messages.bill.patient_gender').(':'),['class'=>'form-label']) }}
        <br>
        <div class="d-flex align-items-center mt-3">
            <div class="form-check me-10 mb-0">
                {{ Form::radio('gender', '0', true, ['class' => 'form-check-input', 'tabindex' => '6', 'id' => 'genderMale']) }}
                &nbsp;
                <label class="form-check-label" for="genderMale">{{ __('messages.user.male') }}</label>
            </div>
            <div class="form-check mb-0">
                {{ Form::radio('gender', '1', false, ['class' => 'form-check-input', 'tabindex' => '7', 'id' => 'genderFemale']) }}
                <label class="form-check-label" for="genderFemale">{{ __('messages.user.female') }}</label>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('dob', __('messages.bill.patient_dob').(':'),['class'=>'form-label']) }}
        {{ Form::text('dob', 'N/A', ['class' => 'form-control', 'id' => 'dob', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('doctor_id', __('messages.case.doctor').(':'),['class'=>'form-label']) }}
        {{ Form::text('doctor_id', 'N/A', ['class' => 'form-control', 'id' => 'billDoctorId', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('admission_date', __('messages.bill.admission_date').(':'),['class'=>'form-label']) }}
        {{ Form::text('admission_date', 'N/A', ['class' => 'form-control', 'id' => 'admissionDate', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('discharge_date', __('messages.bill.discharge_date').(':'),['class'=>'form-label']) }}
        {{ Form::text('discharge_date', 'N/A', ['class' => 'form-control', 'id' => 'dischargeDate', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('package_id', __('messages.bill.package_name').(':'),['class'=>'form-label']) }}
        {{ Form::text('package_id', 'N/A', ['class' => 'form-control', 'id' => 'packageId', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('insurance_id', __('messages.bill.insurance_name').(':'),['class'=>'form-label']) }}
        {{ Form::text('insurance_id', 'N/A', ['class' => 'form-control', 'id' => 'insuranceId', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('total_days', __('messages.bill.total_days').(':'),['class'=>'form-label']) }}
        {{ Form::text('total_days', 'N/A', ['class' => 'form-control', 'id' => 'totalDays', 'readonly']) }}
    </div>
    <div class="col-lg-3 col-md-4 col-sm-12 mb-5 d-none">
        {{ Form::label('policy_no', __('messages.bill.policy_no').(':'),['class'=>'form-label']) }}
        {{ Form::text('policy_no', 'N/A', ['class' => 'form-control', 'id' => 'policyNo', 'readonly']) }}
    </div>
</div>

<div class="com-sm-12">
    {{-- <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end mb-4">
        <button type="button" class="btn btn-primary text-star" id="addBillItem"> {{ __('messages.invoice.add') }}</button>
    </div> --}}

    <div class="radio_bills">
        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end mb-4">
            <a href="#" class="btn btn-primary addItemBtn" data-bs-toggle="modal" data-bs-target="#bill_paying_modal">
               Add Items
            </a>
        </div>
     </div>  

    <div class="table-responsive-sm">
        <table class="table table-striped" id="billTbl">
            <thead>
                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                    <th class="text-center">#</th>
                    <th class="required">{{ __('messages.bill.item_name') }}</th>
                    <th class="required">{{ __('messages.bill.price') }}</th>
                    <th class="required">{{ __('messages.bill.qty') }}</th>
                    <th class="text-right">{{ __('messages.bill.amount') }}</th>
                    <th class="text-center">
                        {{ __('messages.common.action') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bill-item-container text-gray-600 fw-bold">
                @if(isset($bill))
                @foreach($bill->billItems as $billItem)
                <tr>
                    <td class="text-center item-number">{{ $loop->iteration }}</td>
                    <td class="table__item-desc">
                        {{ Form::text('item_name[]', $billItem->item_name, ['class' => 'form-control itemName','required']) }}
                    </td>
                    <td>
                        {{ Form::text('price[]', number_format($billItem->price), ['class' => 'form-control decimal-number price','required']) }}
                    </td>
                    <td class="table__qty">
                        {{ Form::number('qty[]', $billItem->qty, ['class' => 'form-control qty quantity','required']) }}
                    </td>
                    <td class="amount text-right itemTotal">{{ number_format($billItem->amount) }}
                    </td>
                    <td class="text-center">
                        <i class="fa fa-trash text-danger delete-bill-add-item pointer"></i>
                    </td>
                </tr>
                @endforeach                
                @endif
            </tbody>
        </table>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 float-right p-0">
        <table class="w-100">
            <tbody class="bill-item-footer">
                <tr>
                    <td class="form-label text-right">{{ __('messages.bill.total_amount').(':') }}</td>
                    <td class="text-right"><b>{{ getCurrencySymbol() }}</b>
                        <span id="totalPrice" class="price">{{ isset($bill) ? number_format($bill->amount,2) : 0 }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<script>
$(document).ready(function() {

// Consultation Page Starts

  $('#consultationTime').select2();
  $('#consultationTime').on('change', function() {
    const selectedOptionId = $(this).val(); 
    const doctorId = $('#billDoctorId1').val();

    $('#billDoctorId1').next('.select2').find('.select2-selection').css('border-color', '');
    $('#consultationTime').next('.select2').find('.select2-selection').css('border-color', '');


    $.ajax({
      url: "/employee/doctorFee",
      type: "get", 
      data: {
              doctor_id: doctorId,
            },
      success: function(response) 
      {
          var newChargeValue = response.data[0]['new_patient_charge']; 
          var standardChargeValue = response.data[0]['standard_charge']; 

        if (selectedOptionId === 'new_patient_charge') 
        {
        $('#consultationTime').val('new_patient_charge'); 
        $("#charges").html(newChargeValue);
        } 
        
        else if (selectedOptionId === 'standard_charge') 
        {
          $('#consultationTime').val('standard_charge');
          $("#charges").html(standardChargeValue);
        } 
        
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error fetching data:', textStatus, errorThrown);
      }
    });

  });


// Case Session Page Starts

  $('#caseId').select2();
  $('#caseId').on('change', function() {
    const caseId = $(this).val(); 

    $('#caseId').next('.select2').find('.select2-selection').css('border-color', '');


    $.ajax({
      url: "/employee/caseDetails",
      type: "get", 
      data: {
              case_id: caseId,
            },
      success: function(response) 
      {
            $('#selectedSessions').empty().append('<option selected disabled></option>');

            for (var index = 0; index < response.data.length; index++) 
            {
                var sessionId = JSON.parse(response.data[index].services);
                for (var i = 0; i < sessionId.length; i++) {
                    const serviceId = sessionId[i]['session_id'];
                    $('#selectedSessions').append(`<option value="${serviceId}" selected>Service ID ${serviceId}</option>`);
                }
            }
            $('#selectedSessions').select2();
            $("#sessionFee").html(response.data[0]['fee']);
            $("#mainCaseId").html(response.data[0]['case_id']);
            $("#packageName").html(response.data[0]['packname']);

      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error fetching data:', textStatus, errorThrown);
      }
    });
  });


// Other Page Starts

    $('#other_item_charges').on('keyup', function() {
    const amount = $(this).val(); 
    $("#totalAmount").html('Rs.' + amount);
    });

// Add Selected Items to Fields

function addNewRow(item) {
    var newRowHtml = `
        <tr>
            <td class="text-center item-number">${$('.bill-item-container tr').length + 1}</td>
            <td class="table__item-desc">
                {{ Form::text('item_name[]', '${item.item_name}', ['class' => 'form-control itemName','required']) }}
            </td>
            <td>
                {{ Form::text('price[]', '${item.price.toFixed(2)}', ['class' => 'form-control decimal-number price','required']) }}
            </td>
            <td class="table__qty">
                {{ Form::number('qty[]', '${item.qty}', ['class' => 'form-control qty quantity','required']) }}
            </td>
            <td class="amount text-right itemTotal">${item.amount.toFixed(2)}</td>
            <td class="text-center">
                <i class="fa fa-trash text-danger delete-bill-add-item pointer"></i>
            </td>
        </tr>
    `;
    $('.bill-item-container').append(newRowHtml);

    $('.bill-item-container').on('click', '.delete-bill-add-item', function() {
        $(this).closest('tr').remove();
        updateItemNumbers();
    });
}

function updateItemNumbers() {
    $('.bill-item-container tr').each(function(index) {
        $(this).find('.item-number').text(index + 1);
        $('#totalPrice').text($('.itemTotal').text());
    });
}


    $('#addSelectedItem').click(function() {

        // var doctorName = $('#billDoctorId').val();
        var a= $('#billDoctorId1').find('option:selected');
        var doctorName = a.text();
        var price =  parseFloat($("#charges").text());
        var consultType = $('#consultationTime').val();

        var consultationData = [
            {
                item_name: `Consultation Charges (Dr. ${doctorName})`,
                price: price,
                qty: 1,
                amount: price
            }
        ];


        if($('#billDoctorId1').val()>0)
        {
            if($('#consultationTime').val() != "Select")
            {
                consultationData.forEach(function(item) {
                    addNewRow(item);
                });
                $('#bill_paying_modal').modal('hide')
            }
            else
            {
                $('#consultationTime').next('.select2').find('.select2-selection').css('border-color', 'red');
            }
        }
        else
        {
            $('#billDoctorId1').next('.select2').find('.select2-selection').css('border-color', 'red');
        }

        var totalPrice = 0;
        $(".bill-item-container tr").each(function() {
            totalPrice += parseFloat($(this).find(".amount").text());
        });

        $("#totalPrice").text(totalPrice.toFixed(2));
        $("#totalAmount").val(totalPrice.toFixed(2)); 

        setTimeout(function() {
            $(".price").trigger("keyup");
        }, 500);
    });


    $('#addSelectedCase').click(function() {

        var caseId = $('#caseId').find('option:selected');
        var b = caseId.text();
        var caseNo =  $("#mainCaseId").text();
        var packageName = $("#packageName").text();

        var price = parseFloat($("#sessionFee").text());
        var selectedSessions = $("#selectedSessions").find("option");
        var sele = selectedSessions.text();
        var services = "Session " + sele.replace(/Service ID (\d+)/g, function(match, id) {
            return id + ","; 
        });

        services = services.slice(0, -1);

        // console.log("Case Id : ",caseId)
        // console.log("Price : ",price)
        // console.log(services)
        // console.log(b)
        // console.log(caseNo)

        var consultationData = [
            {
                item_name: "Package Name : "+packageName+" (Case ID : "+caseNo+" "+services+")", 
                price: price,
                qty: 1,
                amount: price
            }
        ];

        if($('#caseId').val()>0)
        {          
            consultationData.forEach(function(item) {
                addNewRow(item);
            });  
            $('#bill_paying_modal').modal('hide')
        }
        else
        {
            $('#caseId').next('.select2').find('.select2-selection').css('border-color', 'red');
        }


        var totalPrice = 0;
        $(".bill-item-container tr").each(function() {
            totalPrice += parseFloat($(this).find(".amount").text());
        });

        $("#totalPrice").text(totalPrice.toFixed(2));
        $("#totalAmount").val(totalPrice.toFixed(2)); 

    setTimeout(function() {
        $(".price").trigger("keyup");
    }, 500);
});

    $('#addSelectedOtherItems').click(function() {

    var itemName = $('#other_item_name').val();
    var itemCharges = parseFloat($('#other_item_charges').val());

    $('#other_item_name').css('border-color', '');

    var consultationData = [
        {
            item_name: itemName, 
            price: itemCharges,
            qty: 1,
            amount: itemCharges
        }
    ];

    if($('#other_item_name').val().length>0)
        {        
            if(parseFloat($('#other_item_charges').val())>0)
            {    
                consultationData.forEach(function(item) {
                    addNewRow(item);
                });  
                $('#other_item_charges').css('border-color', '');
                $('#bill_paying_modal').modal('hide')
            }
            else
            {
                $('#other_item_charges').css('border-color', 'red');
            }
        }
        else
        {
            $('#other_item_name').css('border-color', 'red');
        }

    var totalPrice = 0;
    $(".bill-item-container tr").each(function() {
        totalPrice += parseFloat($(this).find(".amount").text());
    });

    $("#totalPrice").text(totalPrice.toFixed(2));
    $("#totalAmount").val(totalPrice.toFixed(2)); 

    setTimeout(function() {
    $(".price").trigger("keyup");
    }, 500);
});


$('#billSave').click(function(e) {
    var totalPrice = parseFloat($('#totalPrice').text());
    if (totalPrice <= 0) {
        alert('Please add items to bill.'); 
        e.preventDefault(); 
    }
});


});
</script>

<!-- Total Amount Field -->
{{ Form::hidden('total_amount', 'N/A', ['class' => 'form-control', 'id' => 'totalAmount']) }}

<!-- Submit Field -->
<div class="float-end">
    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2','id' => 'billSave']) }}
    <a href="{{ route('bills.index') }}" class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
</div>