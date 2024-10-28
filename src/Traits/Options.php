<?php

namespace Fantismic\YetAnotherTable\Traits;

trait Options
{

    public $options;

    public function setOptions() {
        try {
            $this->options = $this->options();
        } catch (\Throwable $th) {}
    }
}