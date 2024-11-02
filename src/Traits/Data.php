<?php

namespace Fantismic\YetAnotherTable\Traits;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

trait Data
{

    public $cachePrefix = '';
    public $all_data_count;
    public $filtered_data_count;

    public function getAllData() {
        return $this->getCachedData();
    }

    public function getAfterFiltersData() {
        $data = $this->filteredData();
        $data = $this->applyFilters($data);
        $this->filtered_data_count = count($data);
        return $data;
    }

    public function getSelectedData() {
        return $this->getAllData()->whereIn('id', $this->getSelectedRows())->values();
    }

    public function parseData() {

        $this->clearData();

        $this->userData = collect();

        $data = $this->data();

        $this->dispatch('yatDataGathered');
        if ($data) {
            $this->dispatch('yatDataGatheredWithData');
        } else {
            $this->dispatch('yatDataGatheredEmpty');
        }

        $customData = $this->getCustomData();
        $linkColumns = $this->getLinkColumns();

        foreach ($data as $key => $row) {
            $parsedRow = [];
            $row = (array) $row;
            foreach ($this->columns as $column) {
                $parsedValue = $row[$column->index] ?? '';
                if (isset($customData[$column->key])) {
                    $parsedValue = call_user_func_array($customData[$column->key]['function'], [$row, $row[$column->index] ?? null]);
                }
                if (isset($linkColumns[$column->key])) {
                    $parsedValue = [];
                    $parsedValue['parsed_href'] = call_user_func_array($linkColumns[$column->key]['function'], [$row, $row[$column->index] ?? null]);
                    $parsedValue['text'] = $column->text ?? $row[$column->index];
                }
                $parsedRow[$column->key] = $parsedValue;
            }
            if ($this->has_bulk && $this->custom_column_id) {
                $parsedRow['id'] = $row[$this->custom_column_id];
            }
            $this->userData->push($parsedRow);
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

    public function getLinkColumns() {
        $linkColumns = [];
        foreach ($this->columns as $key => $column) {
            if (property_exists($column,'isLink') && $column->isLink) {
                $linkColumns[$column->key] = ['index'=> $column->index, 'function' => $column->href];
            }
            unset($this->columns[$key]->href);
        }
        return $linkColumns;
    }

}