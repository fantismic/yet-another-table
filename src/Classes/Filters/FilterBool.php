<?php

namespace Fantismic\YetAnotherTable\Classes\Filters;


use Fantismic\YetAnotherTable\Classes\Filters\Filter;
use Fantismic\YetAnotherTable\Traits\Filters;

class FilterBool extends Filter
{
    use Filters;

    public $type = 'bool';
    public $compared_with;

    public function __construct(string $label, ?array $compared_with = null, ?string $index = null) {
        parent::__construct($label, $index);

        if (!$compared_with) {
            $compared_with = ["true" => true, "false" => false];
        }
        $this->compared_with = $compared_with;
    }

    public static function make(string $label, ?array $compared_with = null, ?string $index = null): Filter
    {
        return new static($label, $compared_with, $index);
    }
}