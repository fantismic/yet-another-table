<?php

namespace Fantismic\YetAnotherTable\Traits;

trait Pagination
{

    public $paginationTheme = 'tailwind'; // Use Tailwind for pagination
    public $perPage = "10";
    public $perPageDisplay = "10";
    public $perPageOptions = ["10", "15", "25", "50", "100", "Total"];
    public $with_pagination = true;

    public function updatedPerPageDisplay($value) {
        if ($value == 'Total') {
            $this->perPage = 9999999999999;
            $this->perPageDisplay = 'Total';
        } else {
            $this->perPage = $value;
            $this->perPageDisplay = $value;
        }
        $this->updatedSelectAll(false);
        $this->selectAll = false;
        $this->allSelected = false;
        $this->pageSeleted = false;
    }

    public function usePagination(bool $bool) {
        $this->with_pagination = $bool;
    }

    public function setPerPageDefault(Int $number) {
        if ($number == 0) {
            $this->perPage = 9999999999999;
            $this->perPageDisplay = 'Total';
        } else {
            $this->perPage = $number;
            $this->perPageDisplay = $number;
        }
    }

    public function setPerPageOptions(Array $array) {
        $this->perPageOptions = $array;
    }

    public function paginateData() {
        $data = $this->getAfterFiltersData();
        
        // Apply sorting before pagination
        $data = $this->sortData($data);
        
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        
        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $data->forPage($currentPage, $this->perPage),
            $data->count(),
            $this->perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginatedData;
    }
}