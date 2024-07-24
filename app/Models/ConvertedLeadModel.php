<?php

namespace App\Models;

use App\Traits\PopulateTenantID;
use Eloquent as Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ConvertedLeadModel extends Model
{
    use BelongsToTenant, PopulateTenantID;

    /**
     * @var string
     */
    public $table = 'converted_lead_models';

    /**
     * @var array
     */
    public $fillable = [
        'lead_id','lead_converted_by','status','converted_date'
    ];

    const STATUS_ALL = 2;

    const ACTIVE = 1;

    const INACTIVE = 0;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Deactive',
    ];

    const FILTER_STATUS_ARR = [
        2 => 'All',
        1 => 'Active',
        0 => 'Deactive',
    ];

}
