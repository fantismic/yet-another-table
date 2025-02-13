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

    public function stripModifiedRows($collection) {
        $collection = collect($collection);
        $collection = $collection->transform(function ($item) {
            foreach ($item as $key => $value) {
                if (str_ends_with($key, '_original')) {
                    $originalKey = substr($key, 0, -9);
                    $item[$originalKey] = $value;
                    unset($item[$key]);
                }
            }
            return $item;
        });
        return $collection;
    }

    public function getAllOriginalData() {
        return $this->stripModifiedRows($this->getAllData());
    }

    public function getAllData() {
        return $this->getCachedData();
    }

    public function getAfterFiltersOriginalData() {
        return $this->stripModifiedRows($this->getAfterFiltersData());
    }

    public function getAfterFiltersData() {
        $data = $this->filteredData();
        $data = $this->applyFilters($data);
        if (is_null($data)) {                         
            $this->filtered_data_count = 0;               
        } else {                                      
            $this->filtered_data_count = count($data);    
        }
        return $data;                                             
    }

    public function getSelectedOriginalData() {
        return $this->stripModifiedRows($this->getSelectedData());
    }

    public function getSelectedData() {
        return $this->getAllData()->whereIn('id', $this->getSelectedRows())->values();
    }

    public function getCurrentPageData() {
        if ($this->with_pagination) {
            $paginatedData = $this->paginateData();
            return collect($paginatedData->items());
        } else {
            $paginatedData=$this->getAfterFiltersData();
            return $this->sortData($paginatedData);
        }
    }

    public function parseData() {

        $this->clearData();
        $this->resetPage();

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
                    $parsedRow[strtolower($column->key."_original")] = $row[$column->index] ?? '';
                    $column->has_modified_data = true;
                }
                if (isset($linkColumns[$column->key])) {
                    $href = call_user_func_array($linkColumns[$column->key]['function'], [$row, $row[$column->index] ?? null]);
                    $text = $column->text ?? $row[$column->index];
                    $parsedValue = json_encode(array($href,$text));
                    $parsedRow[strtolower($column->key."_original")] = $text ?? '';
                    $column->has_modified_data = true;
                }
                $parsedRow[$column->key] = $parsedValue;
            }
            if ($this->has_bulk && $this->custom_column_id) {
                $parsedRow['id'] = $row[$this->custom_column_id];
            }
            $this->userData->push($parsedRow);
        }
        
        $this->userData = $this->userData->map(function ($item) {
            return collect($item)->except(['_original'])->toArray();
        });
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