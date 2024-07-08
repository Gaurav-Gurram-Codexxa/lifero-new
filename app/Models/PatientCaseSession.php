<?php

namespace App\Models;

use App\Models\PatientCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PatientCaseSession extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $table = 'patient_case_sessions';

    const SESSION_BEFORE = 'SESSION_BEFORE';
    const SESSION_AFTER = 'SESSION_AFTER';

    protected $fillable = [
        'case_id',
        'no',
        'session_date',
        'services',
        'status',
        'remark'
    ];

    protected $casts = [
        'services' => 'array',
        'remark' => 'array'
    ];


    public function case(): BelongsTo
    {
        return $this->belongsTo(PatientCase::class, 'case_id');
    }

}
