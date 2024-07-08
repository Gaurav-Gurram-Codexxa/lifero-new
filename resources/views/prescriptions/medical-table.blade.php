<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive medicineTable">
            <table class="table table-striped" id="prescriptionMedicalTbl">
                <thead class="thead-dark">
                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                    <th class="">{{ __('messages.medicines') }}</th>
                    <th class="">{{ __('messages.ipd_patient_prescription.dosage') }}</th>
                    <th class="">{{ __('messages.prescription.duration') }}</th>
                    <th class="">{{ __('messages.prescription.time') }}</th>
                    <th class="">{{ __('messages.medicine_bills.dose_interval') }}</th>
                    <th class="">{{ __('messages.prescription.comment') }}</th>
                    
                    <th class="table__add-btn-heading text-center form-label fw-bolder text-gray-700 mb-3">
                        <a href="javascript:void(0)" type="button" class="btn btn-primary text-star add-medicine-btn" id="addPrescriptionMedicineBtn">
                            {{ __('messages.common.add') }}
                        </a>
                    </th>

                    
                </tr>
                </thead>
                <tbody class="prescription-medicine-container custom-table">
                @if(isset($prescription))
                    @foreach($prescription->getMedicine as $key => $prescription)
                    @php
                        $availableQuantity = App\Models\Medicine::whereId($prescription->medicine)->first()->available_quantity;
                    @endphp
                        <tr>
                            
                            <td>
                                <div class="available-qty-div mt-5">
                                    {{ Form::select('medicine[]', $medicines['medicines'], $prescription->medicine,['class' => 'form-select prescriptionMedicineId', 'data-id' => $key]) }}
                                    <small class="available-quantity{{ $key }} {{ ($availableQuantity <= 10) ? 'text-danger' : 'text-success' }}" id="availableQuantity{{ $key }}">{{ __('messages.item.available_quantity').' : '. $availableQuantity }}</small>
                                </div>
                            </td>
                            
                            <td>
                                {{ Form::text('dosage[]', $prescription->dosage, ['class' => 'form-control prescription-dose', 'id' => 'prescriptionMedicineNameId']) }}
                                <small class="text-danger avalable-amount"></small>
                            </td>
                            <td>
                                {{ Form::text('day[]',  $prescription->day, ['class' => 'form-control prescriptionMedicineDayId']) }}
                            </td>
                            <td>
                                {{ Form::select('time[]', \App\Models\Prescription::MEAL_ARR, $prescription->time,['class' => 'form-select prescriptionMedicineMealId']) }}
                            </td>
                            <td>
                                {{ Form::select('dose_interval[]', \App\Models\Prescription::DOSE_INTERVAL, $prescription->dose_interval,['class' => 'form-select prescriptionMedicineMealId']) }}
                            </td>
                            <td>
                                {{ Form::textarea('comment[]', $prescription->comment, ['class' => 'form-control', 'rows'=>1]) }}
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)" title="{{__('messages.common.delete')}}"
                                    class="delete-prescription-medicine-item btn px-1 text-danger fs-3 pe-0">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>

                        <td>
                            <div class="available-qty-div">
                            {{ Form::select('medicine[]', $medicines['medicines'], null,['class' => 'form-select prescriptionMedicineId', 'data-id' => 1]) }}
                            <small class="available-quantity1" id="availableQuantity1"></small>
                            </div>
                        </td>
                        
                        <td>
                            {{ Form::text('dosage[]', null, ['class' => 'form-control prescription-dose', 'id' => 'prescriptionMedicineNameId']) }}
                        </td>

                        <td>
                            {{ Form::text('day[]', null , ['class' => 'form-control prescriptionMedicineDayId']) }}
                        </td>

                        <td>
                            {{ Form::select('time[]', \App\Models\Prescription::MEAL_ARR, null,['class' => 'form-select prescriptionMedicineMealId']) }}
                        </td>
                        <td>
                            {{ Form::select('dose_interval[]', \App\Models\Prescription::DOSE_INTERVAL, null,['class' => 'form-select prescriptionMedicineMealId']) }}
                        </td>
                        <td>
                            {{ Form::textarea('comment[]', null, ['class' => 'form-control', 'rows'=>1]) }}
                        </td>
                        <td class="text-center">
                            <a href="javascript:void(0)" title="{{__('messages.common.delete')}}"
                               class="delete-prescription-medicine-item btn px-1 text-danger fs-3 pe-0">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endif
             </tbody>
            </table>
        </div>
    </div>
</div>
