<?php

namespace Fantismic\YetAnotherTable;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Fantismic\YetAnotherTable\Traits\Bulk;
use Fantismic\YetAnotherTable\Traits\Data;
use Fantismic\YetAnotherTable\Traits\Sort;
use Fantismic\YetAnotherTable\Traits\View;
use Fantismic\YetAnotherTable\Traits\Cache;
use Fantismic\YetAnotherTable\Traits\Search;
use Fantismic\YetAnotherTable\Traits\Columns;
use Fantismic\YetAnotherTable\Traits\Filters;
use Fantismic\YetAnotherTable\Traits\Options;
use Fantismic\YetAnotherTable\Traits\Spinner;
use Fantismic\YetAnotherTable\Traits\Pagination;
use Fantismic\YetAnotherTable\Traits\StateHandler;
use Fantismic\YetAnotherTable\Traits\RowManipulators;

class YATBaseTable extends Component
{

    use
        WithPagination, WithoutUrlPagination
        ;
    use 
        Cache,
        Data,
        Columns,
        Bulk,
        Search,
        Pagination,
        Sort,
        Options,
        StateHandler,
        RowManipulators,
        View,
        Filters,
        Spinner
        ;

    private $userData;

    #[On('refresh')]
    public function refresh(): void
    {
        $this->mount();
    }

    public function mount() {
        $this->setColumns();
        $this->settings();
        $this->parseData();
        $this->cacheData();
        $this->setOptions();
        $this->setTableState();
        $this->setFilters();
    }

    public function render()
    {
        
        if ($this->with_pagination) {
            $paginatedData = $this->paginateData();
        } else {
            $paginatedData=$this->getAfterFiltersData();
            $paginatedData = $this->sortData($paginatedData);
        }
        
        return view('YATPackage::livewire.yat-table', [
            'rows' => $paginatedData
        ]);
    }
}