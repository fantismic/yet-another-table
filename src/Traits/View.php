<?php

namespace Fantismic\YetAnotherTable\Traits;

trait View
{
    public $title;
    public $titleClasses;
    public $customHeader;

    public function setTitle($title) {
        $this->title = $title;
    }

    public function overrideTitleClasses($classes) {
        $this->titleClasses = $classes;
    }

    public function setCustomHeader($html) {
        $this->customHeader = $html;
    }
}