<?php

namespace App\Imports;

use App\Models\ImportLeadModel;
use App\Models\Lead;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class LeadImport implements ToCollection, WithBatchInserts, WithChunkReading
{
    protected $tenant_id = '';

    public function __construct($tenant_id) {
        $this->tenant_id = $tenant_id;
    }


    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function collection(Collection $collection)
    {

        Lead::insert($collection->map(fn ($row) => [
            'name' => $row[0],
            'email' => $row[1],
            'contact' => $row[2],
            'address' => $row[3],
            'city' => $row[4],
            'state' => $row[5],
            'pincode' => $row[6],
            'disposition' => '',
            'created_at' => now(),
            'updated_at' => now(),
            'tenant_id' => $this->tenant_id,
        ])->toArray());

        $importDate = now();

        $uploadedLeadsCount = count($collection);
        $uploadedBy = auth()->user()->id;

        ImportLeadModel::create([
            'import_date' => $importDate,
            'uploaded_leads_count' => $uploadedLeadsCount,
            'uploaded_by' => $uploadedBy,
        ]);





    }
}
