<?php

namespace Fantismic\YetAnotherTable\Classes\Columns;


use Fantismic\YetAnotherTable\Classes\Columns\Column;
use Fantismic\YetAnotherTable\Traits\Columns;

class LinkColumn extends Column
{
    use Columns;

    public $isLink = true;
    public $href;
    public $text;
    public $tag_styles;
    public $has_modified_data = false;

    public function __construct(string $label, ?string $key = null) {
        parent::__construct($label, $key);
    }

    public static function make(string $label, ?string $key = null): Column
    {
        return new static($label, $key);
    }
}