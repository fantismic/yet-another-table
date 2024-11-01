<?php

namespace Fantismic\YetAnotherTable\Traits;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

trait Data
{

    private $cachePrefix = '';

    public function getAllData() {
        return Cache::get($this->cachePrefix.static::class.'\\'.Auth::user()->username);
    }

    public function getAfterFiltersData() {
        $data = $this->filteredData();
        $data = $this->applyFilters($data);
        return $data;
    }

    public function getSelectedData() {
        return $this->getAllData()->whereIn('id', $this->getSelectedRows())->values();
    }

    public function setCachePrefix(string $string) {
        $this->cachePrefix = $string;
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
                    $column->parsed_href[$key] = call_user_func_array($linkColumns[$column->key]['function'], [$row, $row[$column->index] ?? null]);
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

    public function cacheData() {
        if (!Cache::has($this->cachePrefix.static::class.'\\'.Auth::user()->username)) {
            Cache::put($this->cachePrefix.static::class.'\\'.Auth::user()->username, $this->userData, now()->addMinutes(30));
        }
    }

    public function clearData() {
        Cache::forget($this->cachePrefix.static::class.'\\'.Auth::user()->username);
    }

}