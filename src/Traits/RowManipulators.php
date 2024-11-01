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

}