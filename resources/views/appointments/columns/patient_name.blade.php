
@php
use App\Models\DoctorOPDCharge;
use App\Models\Appointment;

$doctorCharges = DoctorOPDCharge::where('doctor_id', '=', $row->doctor->id)->first();
$appointment = Appointment::where('patient_id','=',$row->patient_id)->count();

$newPatientCharge = $doctorCharges['new_patient_charge'];

@endphp

@if(!empty($row->patient))
    <div class="d-flex align-items-center">
        <div class="image image-mini me-3">
            <a href="{{route('patients.show',$row->patient->id)}}">
                <div>
                    <img src="{{$row->patient->patientUser->image_url}}" alt=""
                         class="user-img image image-circle object-contain">
                </div>
            </a>
        </div>

<style>
    .blink {
  animation: blink 1s steps(1, end) infinite;
  color: red;
}

@keyframes blink {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
    </style>
        <div class="d-flex flex-column">
            <a href="{{route('patients.show',$row->patient->id)}}"
               class="mb-1 text-decoration-none">{{$row->patient->patientUser->full_name}}

                @if($row->fee == $newPatientCharge )

                    @if($appointment > 1)
                        <span></span>
                    @else
                    <span class="blink">New</span>
                    @endif

                @else
                    <span></span>
                @endif
                </a>

            <span>{{$row->patient->patientUser->email}}</span>
        </div>

    </div>
 @else
    <div class="d-flex align-items-center">
        <div class="image image-mini me-3">
            <a href="javascript:void(0)">
                <div>
                    <img src="{{ !empty($row->patient) ? $row->patient->patientUser->image_url  : asset('web/img/logo.jpg')  }}"
                         class="user-img image image-circle object-contain">
                </div>
            </a>
        </div>
        <div class="d-flex flex-column">
            <a href="javascript:void(0)"
               class="mb-1 text-decoration-none">N/a</a>
            <span>N/a<a href=""></a></span>
        </div>
    </div>
@endif
