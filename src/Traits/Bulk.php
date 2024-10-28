<?php

namespace Fantismic\YetAnotherTable\Traits;

trait Bulk
{
    public $has_bulk = false;
    public $selected = []; // Stores the selected row IDs
    public $selectAll = false; // Controls the "Select All" checkbox

    public function hasBulk(Bool $bool) {
        $this->has_bulk = $bool;
    }

    public function updatedSelectAll($value)
    {
        // Get the filtered data based on search
        $filteredData = $this->yatTableData->filter(function ($item) {
            return collect($item)->filter(fn($value) => str_contains(strtolower($value), strtolower($this->search)))->isNotEmpty();
        });

        // If selectAll is checked, select all visible row IDs; otherwise, clear the selected array
        $this->selected = $value ? $filteredData->pluck($this->column_id)->toArray() : [];
    }

    public function toggleSelection($id)
    {
        if (in_array($id, $this->selected)) {
            $this->selected = array_diff($this->selected, [$id]);
        } else {
            $this->selected[] = $id;
        }
    }

    public function getSelectedRows() {
        return $this->selected;
    }

}