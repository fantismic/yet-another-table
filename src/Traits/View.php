<?php

namespace Fantismic\YetAnotherTable\Traits;

trait View
{
    public $title;
    public $titleClasses;
    public $customHtmlTitle;

    public function setTitle($title) {
        $this->title = $title;
    }

    public function overrideTitleClasses($classes) {
        $this->titleClasses = $classes;
    }

    public function setCustomHtmlForTitle($html) {
        $this->customHtmlTitle = $html;
    }
}