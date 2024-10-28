<?php

namespace Fantismic\YetAnotherTable\Traits;

trait Sort
{

    public $sortColumn; // Default column to sort by
    public $sortDirection = 'asc'; // Default sort direction

    public function setSortDirectionAsc(Bool $bool) {
        if ($bool) {
            $this->sortDirection = 'asc';
        }
    }

    public function setSortDirectionDesc(Bool $bool) {
        if ($bool) {
            $this->sortDirection = 'desc';
        }
    }

    public function setSortColumn(String $column) {
        $this->sortColumn = $column;
    }

    public function sortBy($column)
    {

        if ($this->sortColumn === $column) {
            // If already sorting by this column, toggle the direction
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // Otherwise, set to this column and default to ascending
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }
}

