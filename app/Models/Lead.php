<?php

namespace App\Models;

use App\Traits\PopulateTenantID;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * Class Lead
 *
 * @version February 17, 2020, 5:34 am UTC
 *
 * @property int $id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Address $address
 * @property-read User $user
 *
 * @method static Builder|Lead newModelQuery()
 * @method static Builder|Lead newQuery()
 * @method static Builder|Lead query()
 * @method static Builder|Lead whereCreatedAt($value)
 * @method static Builder|Lead whereId($value)
 * @method static Builder|Lead whereUpdatedAt($value)
 * @method static Builder|Lead whereUserId($value)
 *
 * @mixin Model
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EmployeePayroll[] $payrolls
 * @property-read int|null $payrolls_count
 * @property int $is_default
 *
 * @method static Builder|Lead whereIsDefault($value)
 */
class Lead extends Model
{
    use BelongsToTenant, PopulateTenantID;

    /**
     * @var string
     */
    public $table = 'leads';

    /**
     * @var array
     */
    public $fillable = [
        'name',
        'email',
        'contact',
        'address',
        'city',
        'state',
        'pincode',
        'remarks',
        'disposition',
        'status',
        'opened_by',
    ];

    const STATUS_ALL = 2;

    const ACTIVE = 1;

    const INACTIVE = 0;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Deactive',
    ];

    const DISPOSITION = [
        'CNR',
        'Call Later',
        'Not Interested',
        'Interested',
    ];

    const STATUS = [
        'Lost',
        'Win',
    ];

    const FILTER_STATUS_ARR = [
        0 => 'All',
        1 => 'Active',
        2 => 'Deactive',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'remarks' => 'array',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required|email:filter|unique:leads,email',
        'contact' => 'required|digits:10|unique:leads',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'open_by');
    }
}
