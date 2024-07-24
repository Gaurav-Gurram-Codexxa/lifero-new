<div class="row">
    <!-- Patient Name Field -->
    @if(Auth::user()->hasRole('Patient'))
    <input type="hidden" name="patient_id" value="{{ Auth::user()->owner_id }}">
    @else
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('patient_name', __('messages.case.patient').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        <select name="patient_id" class="form-select" id="appointmentsPatientId" placeholder={{__('messages.document.select_patient')}} data-control="select2" required>
            <option value="{{$patient->id}}" selected>{{$patient->text}}</option>
        </select>

    </div>
    @endif

    <div class="form-group col-sm-6 mb-5" hidden>
        {{ Form::label('hospital_name', __('messages.hospitals_list.hospital_name').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::select('hospital_id', (isset($hospitals) ? $hospitals : [] ),null, ['class' => 'form-select', 'required', 'id' => 'appointmentHospitalId', 'data-control' => 'select2' ]) }}
    </div>

    <!-- Department Name Field -->
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('department_name', __('messages.appointment.doctor_department').':', ['class' => 'form-label']) }}
        <span class="required"></span>

        {{ Form::select('department_id', $departments->pluck('title', 'id'), isset($selectedDepartment) ? $selectedDepartment : null, [
            'class' => 'form-select',
            'required',
            'id' => 'appointmentDepartmentId',
            'data-control' => 'select2'
        ]) }}

        {{-- <select name="department_id" class="form-select" id="appointmentDepartmentId" data-control="select2" required>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" @if(isset($selectedDepartment) && $selectedDepartment == $department->id) selected @endif>{{ $department->title }}</option>
            @endforeach
        </select> --}}

    </div>

<!-- Doctor Name Field -->
<div class="form-group col-sm-6 mb-5">
    {{ Form::label('doctor_name', __('messages.case.doctor').':', ['class' => 'form-label']) }}
    <span class="required"></span>
    {{ Form::select('doctor_id',(isset($doctors) ? $doctors : []), $appointment->doctor_id, ['class' => 'form-select','required','id' => 'appointmentDoctorId','placeholder'=> __('messages.web_appointment.select_doctor'), 'data-control' => 'select2']) }}
</div>
<div class="form-group col-sm-6 mb-5">
        {{ Form::label('fee', 'Fee:', ['class' => 'form-label']) }}
        <span class="required"></span>
        <input type="number" name="fee" value="{{$appointment->fee}}" class="form-control" id="fee" readonly>
    </div>



    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('is_paid', 'Is Paid?:', ['class' => 'form-label']) }}
        <br>
        <div class="form-check form-switch">
            <input class="form-check-input w-35px h-20px" name="is_paid" type="checkbox" value="1" {{$appointment->is_paid ? 'checked' : ''}}>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#selectBillDiv').hide();
            function toggleSelectBillDiv() {
                if ($('input[name="is_paid"]').prop('checked')) {
                    $('#selectBillDiv').show();
                    $('#appointmentBillPaid').prop('required', true);
                } else {
                    $('#selectBillDiv').hide();
                    $('#appointmentBillPaid').prop('required', false);
                }
            }
            toggleSelectBillDiv();
            $('input[name="is_paid"]').change(function() {
                toggleSelectBillDiv();
            });
        });
    </script>

    <div id="selectBillDiv" class="form-group col-sm-3 mb-5">
        {{ Form::label('bill', __('messages.select_bill').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        <select name="bill_id" class="form-select" id="appointmentBillPaid" data-control="select2">
            <option>Select Bill</option>
            @foreach($bill as $t)
                <option value="{{$t->bill_id}}" selected>{{$t->bill_id}}</option>
            @endforeach
        </select>
    </div>



    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('is_attended', 'Is Attended?:', ['class' => 'form-label']) }}
        <br>
        <div class="form-check form-switch">
            <input class="form-check-input w-35px h-20px" name="is_attended" type="checkbox" value="1" {{$appointment->is_attended ? 'checked' : ''}} {{auth()->user()->hasRole('Doctor') ? '' : 'disabled'}}>
        </div>
    </div>
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('payment_mode', 'Payment Method:', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::select('payment_mode',['' => 'Choose Payment', 'cash' => 'Cash', 'online' => 'Online'], $appointment->payment_mode, ['class' => 'form-select','required','placeholder'=> 'Select Payment Mode', 'data-control' => 'select2']) }}
    </div>

    @if(!Auth::user()->hasRole('Patient'))
    <!-- Date Field -->
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('opd_date', __('messages.appointment.date').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('opd_date', isset($appointment) ? $appointment->opd_date->format('Y-m-d') : null, ['id'=>'appointmentOpdDate', 'class' => (getLoggedInUser()->thememode ? 'bg-light opdDate form-control' : 'bg-white opdDate form-control'), 'required', 'autocomplete'=>'off']) }}
    </div>
    <!-- Notes Field -->
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('problem', __('messages.appointment.description').':', ['class' => 'form-label']) }}
        {{ Form::textarea('problem', $appointment->description, ['class' => 'form-control', 'rows'=>'4']) }}
    </div>
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('status', 'Appointment Confirmed?:', ['class' => 'form-label']) }}
        <br>
        <div class="form-check form-switch">
            <input class="form-check-input w-35px h-20px" name="status" type="checkbox" value="1" {{$appointment->is_completed ? 'checked' : ''}}>
        </div>
    </div>
    <div class="form-group col-sm-6 mb-5">
        <div class="doctor-schedule" style="display: none">
            <i class="fas fa-calendar-alt"></i>
            <span class="day-name"></span>
            <span class="schedule-time"></span>
        </div>
        <strong class="error-message" style="display: none"></strong>
        <div class="slot-heading">
            <h3 class="available-slot-heading" style="display: none">{{ __('messages.appointment.available_slot').':' }}</h3>
        </div>
        <div class="row">
            <div class="available-slot form-group col-sm-12">
            </div>
        </div>
        <div align="right" style="display: none">
            <span><i class="fa fa-circle color-information" aria-hidden="true"> </i> {{ __('messages.appointment.no_available') }}</span>
        </div>
    </div>
    @endif

    @if(Auth::user()->hasRole('Patient'))
    <!-- Date Field -->
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('opd_date', __('messages.appointment.date').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('opd_date', null, ['id'=>'appointmentOpdDate', 'class' => (getLoggedInUser()->thememode ? 'bg-light opdDate form-control' : 'bg-white opdDate form-control'), 'required', 'autocomplete'=>'off']) }}
    </div>

    <!-- Notes Field -->
    <div class="form-group col-sm-6 mb-5">
        {{ Form::label('problem', __('messages.appointment.description').':', ['class' => 'form-label']) }}
        {{ Form::textarea('problem', null, ['class' => 'form-control', 'rows'=>'4']) }}
    </div>
    <div class="form-group col-sm-6 available-slot-div">
        <div class="doctor-schedule" style="display: none">
            <i class="fas fa-calendar-alt"></i>
            <span class="day-name"></span>
            <span class="schedule-time"></span>
        </div>
        <strong class="error-message" style="display: none"></strong>
        <div class="slot-heading">
            <strong class="available-slot-heading" style="display: none">{{ __('messages.appointment.available_slot').':' }}</strong>
        </div>
        <div class="row">
            <div class="available-slot form-group col-sm-10">
                <div class="available-slot form-group col-sm-12" style="display: block;">

                    <div class="time-slot">
                        <span class="time-interval" data-id="0">10:00</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="1">10:35</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="2">11:10</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="3">11:45</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="4">12:20</span>
                    </div>

                    <div class="time-slot time-slot-book booked" style="background-color: rgb(255, 167, 33); border: 1px solid rgb(255, 167, 33); color: rgb(255, 255, 255);">
                        <span class="time-interval" data-id="5">12:55</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="6">14:40</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="7">15:15</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="8">15:50</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="9">16:25</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="10">17:00</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="11">17:35</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="12">18:10</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="13">18:45</span>
                    </div>

                    <div class="time-slot">
                        <span class="time-interval" data-id="14">19:20</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="color-information" align="right" style="display: none">
            <span><i class="fa fa-circle fa-xs" aria-hidden="true"> </i> {{ __('messages.appointment.no_available') }}</span>
        </div>
    </div>
    @endif
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12 d-flex justify-content-end">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3','id'=>'saveAppointment']) }}
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
    </div>
</div>
