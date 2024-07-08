<?php

namespace App\Http\Livewire;

use App\Models\TeleCaller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TeleCallerTable extends LivewireTableComponent
{
    use WithPagination;

    protected $model = TeleCaller::class;

    public $showButtonOnHeader = true;

    public $showFilterOnHeader = true;

    public $paginationIsEnabled = true;

    public $buttonComponent = 'tele_callers.add-button';

    public $FilterComponent = ['tele_callers.filter-button', TeleCaller::FILTER_STATUS_ARR];

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
            ->setDefaultSort('tele_callers.created_at', 'desc')
            ->setQueryStringStatus(false);
        $this->setThAttributes(function (Column $column) {
            return [
                'class' => '',
            ];
        });
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '3') {
                return [
                    'class' => 'text-center',
                    'width' => '8%',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.tele_callers'), 'user.first_name')
                ->view('tele_callers.columns.accountant')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.user.phone'), 'user.phone')
                ->view('tele_callers.columns.phone')
                ->sortable()->searchable(),
            Column::make(__('messages.common.status'), 'user.email')
                ->view('tele_callers.columns.status')
                ->searchable(),
            Column::make('Mistake', 'leads_count')
                ->label(function ($row) {
                    return $row->leads_count;
                })
                ->searchable(),
            Column::make(__('messages.common.action'), 'id')
                ->view('tele_callers.action'),
            Column::make(__('last_name'), 'user.last_name')->hideIf(1),
            Column::make(__('email'), 'user.email')->hideIf(1),
        ];
    }

    public function builder(): Builder
    {
        /** @var Builder $query */
        $query = TeleCaller::with('user')
            ->select('tele_callers.*', DB::raw('(select count(1) from lead_closes where user_id = users.id) as leads_count'));

        $query->when(isset($this->statusFilter), function (Builder $q) {
            $q->whereHas('user', function (Builder $query) {
                if ($this->statusFilter == 1) {
                    $query->where('status', TeleCaller::ACTIVE);
                }
                if ($this->statusFilter == 0) {
                    $query->where('status', TeleCaller::INACTIVE);
                }
            });
        });

        return $query;
    }
}
