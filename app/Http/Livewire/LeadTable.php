<?php

namespace App\Http\Livewire;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Column;

class LeadTable extends LivewireTableComponent
{
    use WithPagination;

    public $telecallerFilter;

    protected $model = Lead::class;

    public $showButtonOnHeader = true;

    public $paginationIsEnabled = true;

    public $showFilterOnHeader = true;

    public $FilterComponent = ['leads.filter-button', Lead::FILTER_STATUS_ARR];

    public $buttonComponent = 'leads.add-button';

    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPage'];

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
            ->setDefaultSort('leads.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function changeFilter($param, $value)
    {
        $this->telecallerFilter = $value;
        $this->resetPage($this->getComputedPageName());
        $this->setBuilder($this->builder());
    }

    public function updatingTelecallerFilter($value)
    {
        $this->telecallerFilter = $value;
        $this->resetPage();
    }

    public function updatedTelecallerFilter()
    {
        $this->setBuilder($this->builder());
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.leads'), 'name')
                ->searchable()
                ->sortable(),

            Column::make('Disposition', 'disposition'),

            Column::make('Status', 'status'),

            Column::make('Recent Remarked By', 'user.first_name')
                ->searchable()
                ->view('leads.remarkedBy'),

            Column::make(__('messages.common.action'), 'id')
                ->view('leads.action'),

            Column::make(__('messages.case.patient'), 'opened_by')->hideIf(1),
        ];
    }

    public function builder(): Builder
    {
        /** @var Builder $query */
        $query = Lead::query()
            ->leftJoin('users', 'leads.opened_by', '=', 'users.id')
            ->select('leads.*', 'users.first_name as fname', 'users.last_name as lname');

        $query->when($this->telecallerFilter, function (Builder $q) {
            $q->where('leads.opened_by', $this->telecallerFilter);
        });

        return $query;
    }
}
