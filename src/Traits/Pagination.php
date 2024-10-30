<?php

namespace Fantismic\YetAnotherTable\Traits;

trait Pagination
{

    public $paginationTheme = 'tailwind'; // Use Tailwind for pagination
    public $perPage = "10";
    public $perPageOptions = ["10", "15", "25", "50"];
    public $with_pagination = true;

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
        if ($this->sortColumn) {
            $data = $data->sortBy(function ($item) {
                return $item[strtolower($this->sortColumn)];
            });
        
            if ($this->sortDirection === 'desc') {
                $data = $data->reverse();
            }
        }

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