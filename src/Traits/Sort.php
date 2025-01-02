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
        
        $sort_column = $this->columns->where('key',$column)->first();
        $sort_column = $sort_column->index."_sort" ?? $column;

        if ($this->sortColumn === $sort_column) {
            // If already sorting by this column, toggle the direction
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // Otherwise, set to this column and default to ascending
            $this->sortColumn = $sort_column;
            $this->sortDirection = 'asc';
        }
    }

    public function sortData($data) {
        if ($this->sortColumn) {
            $data = $data->sortBy(function ($item) {
                return $item[strtolower($this->sortColumn)];
            });
        
            if ($this->sortDirection === 'desc') {
                $data = $data->reverse();
            }
        }

        return $data;
    }
}

