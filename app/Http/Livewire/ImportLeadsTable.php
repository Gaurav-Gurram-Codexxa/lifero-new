<?php

namespace App\Http\Livewire;

use App\Models\ImportLeadModel;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ImportLeadsTable extends LivewireTableComponent
{
    use WithPagination;

    protected $model = Lead::class;

    public $showButtonOnHeader = true;

    public $paginationIsEnabled = true;

    public $buttonComponent = 'leads.import-button';

    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPage'];

    public function changeFilter($param, $value)
    {
        $this->resetPage($this->getComputedPageName());
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
            ->setDefaultSort('import_lead_models.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.import_date'), 'import_date'),

            Column::make(__('messages.uploaded_leads_count'), 'uploaded_lead_count'),


        ];
    }

    public function builder(): Builder
    {
        // /** @var Builder $query */
        // $query = Lead::query()
        // ->leftJoin('users','leads.opened_by','=','users.id')
        // ->select('users.first_name as fname','users.last_name as lname');

        // $query->when(isset($this->statusFilter), function (Builder $q) {
        //     $status = $this->statusFilter == 1 ? Lead::ACTIVE : Lead::INACTIVE;
        //     $q->where('status', $status);
        // });


        $query = ImportLeadModel::query();

        return $query;
    }

}
