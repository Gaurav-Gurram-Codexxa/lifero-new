<?php

namespace App\Http\Livewire;

use App\Models\Lead;
use App\Models\TeleCaller;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ConvertedLeadsTable extends LivewireTableComponent
{
    use WithPagination;

    protected $model = Lead::class;

    public $paginationIsEnabled = true;

    public $showFilterOnHeader = true;

    public $FilterComponent = ['leads.teleFilter', Lead::FILTER_STATUS_ARR];

    protected $startDate = '';

    protected $endDate = '';

    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPage','changeDateFilter'];

    public function __construct()
    {
        $this->startDate = now();
        $this->endDate = now();
    }

    public function changeDateFilter($param, $value)
    {
        $this->resetPage($this->getComputedPageName());
        $this->startDate = $value[0];
        $this->endDate = $value[1];
        $this->setBuilder($this->builder());
    }

    public function changeFilter($param, $value)
    {
        $this->resetPage($this->getComputedPageName());
        $this->startDate = $value[0];
        $this->endDate = $value[1];
        $this->statusFilter = $value;

        $this->setBuilder($this->builder());
    }

    public function resetPage($pageName = 'page')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        $prevPageNum = $rowsPropertyData['current_page'] - 1;
        $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
        $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;

        $this->setPage($pageNum, $pageName);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('tele_callers.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.invoice.patient_id'),'id')
                        ->view('leads.convertedLeads.patient_id'),
            Column::make(__('messages.lead_name'),'id')
                        ->view('leads.convertedLeads.patient_name'),
            Column::make(__('messages.lead_converted_by'), 'id')
                        ->view('leads.convertedLeads.telecaller_name'),
            Column::make(__('messages.converted_date'), 'id')
                        ->view('leads.convertedLeads.convertedDate'),
            Column::make(__('messages.status'), 'id')
                        ->view('leads.convertedLeads.patient_status'),
        ];
    }

    public function builder(): Builder
    {
        $query = TeleCaller::query()
        ->join('users as telecaller', 'tele_callers.user_id', '=', 'telecaller.id')
        ->join('appointments', 'tele_callers.user_id', '=', 'appointments.telecaller_id')
        ->join('patients', 'appointments.patient_id', '=', 'patients.id')
        ->join('users as patient_user', 'patients.user_id', '=', 'patient_user.id')
        ->leftJoin('users', 'patients.user_id', '=', 'users.id')
        ->whereBetween('appointments.opd_date', [$this->startDate, $this->endDate])
        ->select(
            'telecaller.first_name as telecaller_first_name',
            'telecaller.last_name as telecaller_last_name',
            'patient_user.first_name as patient_first_name',
            'patient_user.last_name as patient_last_name',
            'appointments.opd_date as patient_created_at',
            'appointments.patient_id as patient_id',
            'users.status as patient_status'
        );

     return $query;

    }
}
