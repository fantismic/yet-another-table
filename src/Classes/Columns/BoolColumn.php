<?php

namespace Fantismic\YetAnotherTable\Classes\Columns;


use Fantismic\YetAnotherTable\Classes\Columns\Column;
use Fantismic\YetAnotherTable\Traits\Columns;

class BoolColumn extends Column
{
    use Columns;

    public $isBool = true;
    public $what_is_true = 1;
    public $true_icon = '✔️';
    public $false_icon = '❌';


    public function __construct(string $label, ?string $key = null) {
        parent::__construct($label, $key);
    }

    public static function make(string $label, ?string $key = null): Column
    {
        return new static($label, $key);
    }
}