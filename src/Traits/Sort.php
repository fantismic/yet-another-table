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
        $this->emptySelection();
        $sort_column = $this->columns->where('key',$column)->first()->key;

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
            $sort_column = $this->columns->where('key',strtolower($this->sortColumn))->first();           

            if ($sort_column->has_modified_data) {
                $sort_column = $sort_column->key."_original";
            } else {
                $sort_column = $sort_column->key;    
            }

            if ($this->sortDirection === 'desc') {
                
/*                 $data = $data->sortByDesc(function ($item) use ($sort_column) {
                    return $item[strtolower($sort_column)];
                },SORT_NATURAL|SORT_FLAG_CASE); */
                $data = $data->sortByDesc(function ($item) use ($sort_column) {
                    $value = $item[strtolower($sort_column)];
                    return is_array($value) ? implode(' ', $value) : $value;
                }, SORT_NATURAL | SORT_FLAG_CASE);
            } else {
/*                 $data = $data->sortBy(function ($item) use ($sort_column) {
                    return $item[strtolower($sort_column)];
                },SORT_NATURAL|SORT_FLAG_CASE); */
                $data = $data->sortBy(function ($item) use ($sort_column) {
                    $value = $item[strtolower($sort_column)];
                    return is_array($value) ? implode(' ', $value) : $value;
                }, SORT_NATURAL | SORT_FLAG_CASE);
            }
        }

        return $data;
    }
}

