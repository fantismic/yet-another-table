<?php

namespace Fantismic\YetAnotherTable\Traits;

trait Pagination
{

    public $paginationTheme = 'tailwind'; // Use Tailwind for pagination
    public $perPage = "10";
    public $perPageOptions = ["10", "15", "25", "50", "100", "Total"];
    public $with_pagination = true;

    public function updatedPerPage($value) {
        if ($value == 'Total') {
            $this->perPage = $this->getAfterFiltersData()->count();
        } else {
            $this->perPage = $value;
        }
    }

    public function usePagination(bool $bool) {
        $this->with_pagination = $bool;
    }

    public function setPerPageDefault(Int $number) {
        $this->perPage = $number;
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