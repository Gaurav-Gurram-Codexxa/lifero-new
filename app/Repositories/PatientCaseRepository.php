<?php

namespace App\Repositories;

use App\Models\CaseHandler;
use App\Models\Doctor;
use App\Models\Notification;
use App\Models\Package;
use App\Models\Patient;
use App\Models\PatientCase;
use App\Models\PatientCaseSession;
use App\Models\Receptionist;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class PatientCaseRepository
 *
 * @version February 19, 2020, 4:48 am UTC
 */
class PatientCaseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'case_id',
        'patient_id',
        'phone',
        'doctor_id',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PatientCase::class;
    }

    public function getPatients()
    {
        /** @var Patient $patients */
        $patients = Patient::with('patientUser')->get()->where('patientUser.status', '=', 1)->pluck('patientUser.full_name', 'id')->sort();

        return $patients;
    }

    public function getDoctors()
    {
        /** @var Doctor $doctors */
        $doctors = Doctor::with('doctorUser')->get()->where('doctorUser.status', '=', 1)->pluck('doctorUser.full_name', 'id')->sort();

        return $doctors;
    }

    public function getCaseHandler()
    {
        /** @var CaseHandler $caseHandlers */
        $caseHandlers = CaseHandler::with('user')->get()->where('user.status', '=', 1)->pluck('user.full_name', 'id')->sort();

        return $caseHandlers;
    }

    public function getPackages()
    {
        /** @var Package $packages */
        $packages = Package::all()->pluck('name', 'id')->sort();
        return $packages;
    }

    /**
     * @return bool|UnprocessableEntityHttpException
     */
    public function store(array $input)
    {
        try {
            // $input['case_id'] = mb_strtoupper(PatientCase::generateUniqueCaseId());
            $input['case_id'] = '';

            $sessionItemInputArray = array_values($input['session']);
            $packageServiceItemInput = $this->prepareInputForSessionItem($sessionItemInputArray);

            $sessions = collect($packageServiceItemInput)->groupBy('session_id')->toArray();

            $caseStartDate = $input['caseStartDate'];
            $sessionDuration = $input['sessionDuration'];

            $patientCase = PatientCase::create($input);
            $patientCase->update(['case_id' => 'LC' . str_pad("{$patientCase->id}", 5, '0', STR_PAD_LEFT)]);

            $date = new DateTime($caseStartDate);

            $multiDate = $date;
            $accumulatedFee = 0;

            foreach ($sessions as $k => $data) {
                /** @var PatientCaseSession $sessionItem */

                    if (is_string($data)) {
                        $data = json_decode($data, true);
                    }

                    $totalRate = 0;

                    if (is_array($data)) {
                        foreach ($data as $item) {
                            if (isset($item['rate'])) {
                                $totalRate += (float)$item['rate']; // Convert rate to float and accumulate
                            }
                        }
                    }

                PatientCaseSession::create([
                    'no' => $k + 1,
                    'session_date' => $sessionItemInputArray[$k]['session_date'] != null
                    ? Carbon::parse($sessionItemInputArray[$k]['session_date'])
                    : $multiDate,
                    'services' => $data, 'case_id' => $patientCase->id,
                    'status' => 'Pending'
                ]);

                $accumulatedFee += $totalRate;

                $multiDate = $date->modify("+{$sessionDuration} days");
            }

            $patientCase->update(['fee' => $accumulatedFee]);


            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }


    public function prepareInputForSessionItem(array $input): array
    {
        $items = [];
        foreach ($input as $key => $data) {

            foreach ($data['service_id'] as $index => $value) {
                $items[] = [
                    'service_id' => $input[$key]['service_id'][$index],
                    'quantity' => $input[$key]['quantity'][$index],
                    'rate' => removeCommaFromNumbers($input[$key]['rate'][$index]),
                    'session_id' => $key,
                ];
            }
        }

        return $items;
    }

    public function createNotification(array $input)
    {
        try {
            $patient = Patient::with('patientUser')->where('id', $input['patient_id'])->first();
            $doctor = Doctor::with('doctorUser')->where('id', $input['doctor_id'])->first();
            $receptionists = Receptionist::pluck('user_id', 'id')->toArray();
            $caseHandeler = CaseHandler::pluck('user_id', 'id')->toArray();
            $userIds = [
                $doctor->user_id => Notification::NOTIFICATION_FOR[Notification::DOCTOR],
                $patient->user_id => Notification::NOTIFICATION_FOR[Notification::PATIENT],
            ];

            foreach ($receptionists as $key => $userId) {
                $userIds[$userId] = Notification::NOTIFICATION_FOR[Notification::RECEPTIONIST];
            }

            foreach ($caseHandeler as $key => $userId) {
                $userIds[$userId] = Notification::NOTIFICATION_FOR[Notification::CASE_HANDLER];
            }
            $users = getAllNotificationUser($userIds);

            foreach ($users as $key => $notification) {
                if ($notification == Notification::NOTIFICATION_FOR[Notification::PATIENT]) {
                    $title = $patient->patientUser->full_name . ' your case has been created.';
                } else {
                    $title = $patient->patientUser->full_name . ' case has been created.';
                }
                addNotification([
                    Notification::NOTIFICATION_TYPE['Cases'],
                    $key,
                    $notification,
                    $title,
                ]);
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
