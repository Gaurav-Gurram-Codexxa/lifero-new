<?php

namespace App\Models;

use App\Traits\PopulateTenantID;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Str;

/**
 * Class PatientCase
 *
 * @version February 19, 2020, 4:48 am UTC
 *
 * @property int $id
 * @property string $case_id
 * @property int $patient_id
 * @property int $phone
 * @property int $doctor_id
 * @property string $date
 * @property int $status
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Doctor $doctor
 * @property-read Patient $patient
 *
 * @method static Builder|PatientCase newModelQuery()
 * @method static Builder|PatientCase newQuery()
 * @method static Builder|PatientCase query()
 * @method static Builder|PatientCase wherePatientCaseId($value)
 * @method static Builder|PatientCase whereCreatedAt($value)
 * @method static Builder|PatientCase whereDate($value)
 * @method static Builder|PatientCase whereDescription($value)
 * @method static Builder|PatientCase whereDoctorId($value)
 * @method static Builder|PatientCase whereId($value)
 * @method static Builder|PatientCase wherePatientId($value)
 * @method static Builder|PatientCase wherePhone($value)
 * @method static Builder|PatientCase whereStatus($value)
 * @method static Builder|PatientCase whereUpdatedAt($value)
 *
 * @mixin Model
 *
 * @property float $fee
 *
 * @method static Builder|PatientCase whereFee($value)
 * @method static Builder|PatientCase whereCaseId($value)
 *
 * @property int $is_default
 * @property-read \App\Models\BedAssign $bedAssign
 *
 * @method static Builder|PatientCase whereIsDefault($value)
 */
class PatientCase extends Model
{
    use BelongsToTenant, PopulateTenantID;

    /**
     * @var string
     */
    public $table = 'patient_cases';

    const STATUS_ALL = 0;

    const PENDING = 1;

    const IN_PROGRESS = 2;

    const CLOSED = 3;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::PENDING => 'Pending',
        self::IN_PROGRESS => 'In Progress',
        self::CLOSED => 'Closed',
    ];

    const FILTER_STATUS_ARR = [
        0 => 'All',
        1 => 'Pending',
        2 => 'In Progress',
        3 => 'Closed',
    ];

    /**
     * @var array
     */
    public $fillable = [
        'case_id',
        'patient_id',
        'phone',
        'doctor_id',
        'date',
        'status',
        'description',
        'fee',
        'discount',
        'case_handler_id',
        'caseStartDate',
        'sessionDuration',
        'package_id',
        'payment_status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'case_id' => 'string',
        'patient_id' => 'integer',
        'doctor_id' => 'integer',
        'fee' => 'double',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'patient_id' => 'required',
        'phone' => 'nullable|numeric',
        'doctor_id' => 'required',
        'date' => 'required',
        'description' => 'nullable',
        'fee' => 'required',
        'case_handler_id' => 'required',
        'caseStartDate'=> 'required',
        'sessionDuration'=> 'required',
    ];

    public static function generateUniqueCaseId(): string
    {
        $caseId = Str::random(8);
        while (true) {
            $isExist = self::whereCaseId($caseId)->exists();
            if ($isExist) {
                self::generateUniqueCaseId();
            }
            break;
        }

        return $caseId;
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function case_handler(): BelongsTo
    {
        return $this->belongsTo(CaseHandler::class, 'case_handler_id');
    }

    public function bedAssign(): BelongsTo
    {
        return $this->belongsTo(BedAssign::class, 'case_id', 'case_id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(PatientCaseSession::class, 'case_id');
    }

    public function prepareData()
    {
        return [
            'patient_case' => $this->case_id . ' ' . $this->patient->patientUser->full_name,
        ];
    }

    public function preparePatientCaseDetailData()
    {
        return [
            'id' => $this->id,
            'case_id' => $this->case_id,
            'case_date' => isset($this->date) ? \Carbon\Carbon::parse($this->date)->translatedFormat('jS M, Y,g:i A') : __('messages.common.n/a'),
            'patient' => $this->patient->patientUser->full_name ?? __('messages.common.n/a'),
            'phone' => $this->phone ?? __('messages.common.n/a'),
            'fee' => $this->fee ?? __('messages.common.n/a'),
            'created_on' => $this->created_at->diffForHumans() ?? __('messages.common.n/a'),
            'description' => $this->description ?? __('messages.common.n/a'),
            'currency' =>  getAPICurrencySymbol() ?? __('messages.common.n/a'),
        ];
    }

    public function preparePatientCase()
    {
        return [
            'id' => $this->id,
            'doctor_name' => $this->doctor->doctorUser->full_name ?? __('messages.common.n/a'),
            'doctor_image' => $this->doctor->doctorUser->getApiImageUrlAttribute() ?? __('messages.common.n/a'),
            'case_id' => $this->case_id ?? __('messages.common.n/a'),
            'status' => self::STATUS_ARR[$this->status] ?? __('messages.common.n/a'),
            'case_date' => isset($this->date) ? Carbon::parse($this->date)->format('jS M, Y') : __('messages.common.n/a'),
            'case_time' => isset($this->date) ? Carbon::parse($this->date)->format('h:i A') : __('messages.common.n/a'),
            'fee' => $this->fee ?? __('messages.common.n/a'),
            'created_on' => $this->created_at->diffForHumans() ?? __('messages.common.n/a'),
            'description' => $this->description ?? __('messages.common.n/a'),
            'currency' => getAPICurrencySymbol() ?? __('messages.common.n/a'),
        ];
    }
}
