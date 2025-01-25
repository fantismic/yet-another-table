<?php

namespace Fantismic\YetAnotherTable\Traits;

trait Bulk
{
    public $has_bulk = false;
    public $yat_selected_checkbox = [];
    public $selectAll = false; // Controls the "Select All" checkbox

    public function hasBulk(Bool $bool) {
        $this->has_bulk = $bool;
    }

    public function updatedSelectAll($value)
    {
        $this->select_all_data($value);
    }

    public function select_all_data($value) {
        $data = $this->getAfterFiltersData();
        // If selectAll is checked, select all visible row IDs; otherwise, clear the selected array
        $this->yat_selected_checkbox = $value ? $data->pluck($this->column_id)->toArray() : [];
    }

    public function changeYatSelectedCheckbox($id)
    {

        if (in_array($id, $this->yat_selected_checkbox)) {
            $this->yat_selected_checkbox = array_diff($this->yat_selected_checkbox, [$id]);
        } else {
            $this->yat_selected_checkbox[] = $id;
        }

    }

    public function getSelectedRows() {
        return $this->yat_selected_checkbox;
    }

}