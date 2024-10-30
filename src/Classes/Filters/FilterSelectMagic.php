<?php

namespace Fantismic\YetAnotherTable\Classes\Filters;


use Fantismic\YetAnotherTable\Classes\Filters\Filter;
use Fantismic\YetAnotherTable\Traits\Filters;

class FilterSelectMagic extends Filter
{
    use Filters;

    public $type = 'magic-select';
    public $options;

    public function __construct(string $label, ?string $index = null) {
        parent::__construct($label, $index);
    }

    public static function make(string $label, ?string $index = null): Filter
    {
        return new static($label, $index);
    }
}