<?php

namespace Fantismic\YetAnotherTable\Traits;

use Exception;

trait Data
{

    public $yatTableData;

    public function parseData() {

        $this->yatTableData = collect();

        $data = $this->data();

        $customData = $this->getCustomData();

        foreach ($data as $row) {
            $parsedRow = [];
            $row = (array) $row;
            foreach ($this->columns as $column) {
                $parsedValue = $row[$column->index] ?? '';
                if (isset($customData[$column->key])) {
                    $parsedValue = call_user_func_array($customData[$column->key]['function'], [$row, $row[$column->index] ?? null]);
                }
/*                 if (isset($customClasses[$column->key])) {
                    $parsedValue = '<div class="'.$customClasses[$column->key]['classes'].'">'.$parsedValue.'</div>';
                } */
                $parsedRow[$column->key] = $parsedValue;
            }
            if ($this->has_bulk && $this->custom_column_id) {
                $parsedRow['id'] = $row[$this->custom_column_id];
            }
            $this->yatTableData->push($parsedRow);
        }

    }

    public function getCustomData() {
        $customData = [];
        foreach ($this->columns as $key => $column) {
            if (is_callable($column->customData)) {
                $customData[$column->key] = ['index'=> $column->index, 'function' => $column->customData];
            }
            unset($this->columns[$key]->customData);
        }
        return $customData;
    }

    public function determineIndexCustomColumnID($firstRow) {
        if ($this->has_bulk && $this->custom_column_id) {
            $firstRow = (array) $firstRow;
            if (!isset($firstRow[$this->custom_column_id])) {
                throw new Exception("[setColumnID] Data doesnt have a key ".$this->custom_column_id);
            }
            return $hasColumnID->first()->index;
        }
        return false;
    }

}

