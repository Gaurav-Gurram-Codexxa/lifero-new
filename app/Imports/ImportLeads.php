<?php

namespace App\Imports;

use App\Models\ImportLeadModel;
use App\Models\Lead;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


class ImportLeads implements ToCollection
{
    /**
    * @param Collection $collection
    */
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
        ])->toArray());

        $importDate = now();

        $uploadedLeadsCount = count($collection);

        $uploadedBy = auth()->user()->id;

        ImportLeadModel::create([
            'import_date' => $importDate,
            'uploaded_lead_count' => $uploadedLeadsCount,
            'uploaded_by' => $uploadedBy,
        ]);
    }
}
