<?php

namespace App\Http\Livewire;

use App\Models\TaxModel;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TaxTable extends LivewireTableComponent
{
    protected $model = TaxModel::class;

    public $showButtonOnHeader = true;

    public $buttonComponent = 'super_admin.tax.add-button';

    protected $listeners = ['refresh' => '$refresh', 'changeFilter', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('tax_models.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.rate'), 'rate')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.common.action'), 'id')
                ->view('super_admin.tax.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = TaxModel::select('*');

        return $query;
    }
}
