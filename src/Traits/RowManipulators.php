<?php

namespace Fantismic\YetAnotherTable\Traits;

trait RowManipulators
{

    public function removeRowFromTable($id, $resetSelected = true) {
        $data = $this->getAllData();
        $data = $data->reject(function ($item) use ($id) {
            return $item[$this->column_id] == $id;
        });
        if ($resetSelected) {
            $this->selected = [];
        }
        $this->updateCacheData($data);
    }

    public function addRowToTable($row) {
        $data = $this->getAllData();
        if (!isset($row['id'])) {
            $row['id'] = $row[$this->column_id];
        }
        $data->push($row);
        $this->updateCacheData($data);
    }

}