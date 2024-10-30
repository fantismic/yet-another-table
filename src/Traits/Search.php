<?php

namespace Fantismic\YetAnotherTable\Traits;

trait Search
{

    public $search = ''; // Search input binding

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filteredData()
    {

        $data = $this->getAllData();
        
        // Ensure the search term is properly trimmed and lowercased
        $searchTerm = strtolower(trim($this->search));
    
        // If no search term, return the original collection
        if (empty($searchTerm)) {
            return $data;
        }
        
        // Apply filtering across all columns
        return $data->filter(function ($item) use ($searchTerm) {
            // Check if the search term exists in any of the item's values
            foreach ($item as $value) {
                if (str_contains(strtolower($value), $searchTerm)) {
                    return true; // Return true if found in any column
                }
            }
            return false; // Return false if not found
        });
    }
}

