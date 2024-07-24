<?php

namespace App\Models;

use App\Traits\PopulateTenantID;
use Eloquent as Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ImportLeadModel extends Model
{
    use BelongsToTenant, PopulateTenantID;

    /**
     * @var string
     */
    public $table = 'import_lead_models';

    /**
     * @var array
     */
    public $fillable = [
        'import_date','uploaded_lead_count','uploaded_by','tenant_id'
    ];
}
