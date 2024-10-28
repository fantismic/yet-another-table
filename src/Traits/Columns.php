<?php

namespace Fantismic\YetAnotherTable\Traits;

use Closure;
use Exception;
use Illuminate\Support\Str;

trait Columns
{
    public $column_id = 'id';
    public $custom_column_id = 'id';
    public $columns;

    public function setColumns() {
        $this->columns = collect($this->columns());

        $this->columns = $this->columns->map(function ($item) {
            return (object) get_object_vars($item);
        });
    }

    public function setColumnID(String $column_id) {
        $this->custom_column_id = $column_id;
    }

    public function styling(String $classes): self {
        $this->classes = "!".str_replace(' ',' !',trim($classes));
        return $this;
    }

    public function isBool(): self {
        $this->isBool = true;
        return $this;
    }

    public function toHtml(): self {
        $this->isHtml = true;
        return $this;
    }

    public function text($text): self {
        if ($this->isLink) {
            $this->text = $text;
        }
        return $this;
    }

    public function href($href): self {
        if ($this->isLink) {
            $this->href = $href;
        }
        return $this;
    }

    public function classes($classes): self {
        if ($this->isLink) {
            $this->tag_classes = $classes;
        }
        return $this;
    }

    public function customData(Closure $function): self {
        $this->customData = $function;
        #$this->customData[$this->key] = $function;
        return $this;
    }

    public function hideWhen(Bool $bool): self {
        $this->isHidden = $bool;
        return $this;
    }

    public function hideFromSelector(Bool $bool): self {
        $this->hideFromSelector = $bool;
        return $this;
    }

    public function generateTempID() {
        if ($this->has_bulk) {
            if (!$this->yatTableData->isEmpty()) {
                $idColumn = $this->column_id;
                if (is_array($this->yatTableData->first())) {
                    if (!array_key_exists($idColumn, $this->yatTableData->first())) {
                        $this->yatTableData = $this->yatTableData->map(function ($item, $index) use ($idColumn) {
                            $item[$idColumn] = 'yat-' . $index; // Create a temporary ID
                            return $item;
                        });
                    }
                } else {
                    if(!property_exists($this->yatTableData->first(), $idColumn)) {
                        $this->yatTableData = $this->yatTableData->map(function ($item, $index) use ($idColumn) {
                            $item->$idColumn = 'yat-' . $index; // Create a temporary ID
                            return $item;
                        });
                    }
                }
            }
        }
    }
}

