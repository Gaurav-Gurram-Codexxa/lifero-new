<?php

namespace App\Jobs;

use App\Imports\LeadImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportLeadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $tenant;

    public function __construct($file, $tenant)
    {
        $this->tenant = $tenant;
        $this->file = $file;
    }

    public function handle()
    {
        Log::info('Job dispatched ' . $this->file);
        Excel::import(new LeadImport($this->tenant), $this->file);
    }
}
