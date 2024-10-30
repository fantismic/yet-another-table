<?php

namespace Fantismic\YetAnotherTable\Traits;

trait View
{
    public $title;
    public $titleClasses;
    public $customHeader;
    public $main_wrapper_classes;
    public $table_classes;
    public $override_table_classes = false;
    public $sticky_header = false;
    public $loading_table_spinner = true;
    public $loading_table_spinner_custom_view;

    public function setTitle($title) {
        $this->title = $title;
    }

    public function overrideTitleClasses($classes) {
        $this->titleClasses = $classes;
    }

    public function setCustomHeader($html) {
        $this->customHeader = $html;
    }

    public function setComponentClasses(string $classes) {
        $this->main_wrapper_classes = $classes;
    }

    public function addTableClasses(string $classes) {
        $this->table_classes = $classes;
    }

    public function setTableClasses(string $classes) {
        $this->override_table_classes = true;
        $this->table_classes = $classes;
    }
    
    public function setStickyHeader() {
        $this->sticky_header = true;
    }

    public function useTableSpinner(bool $bool) {
        $this->loading_table_spinner = $bool;
    }

    public function setTableSpinnerView(string $view) {
        $this->loading_table_spinner_custom_view = $view;
    }
}