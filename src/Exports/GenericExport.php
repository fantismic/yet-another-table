<?php

namespace Fantismic\YetAnotherTable\Exports;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GenericExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{

    protected $headers;
    protected $sheetName;
    protected $data;
    protected $strip_tags;

    public function __construct($data,$strip_tags = false, $sheetName = null)
    {
        $this->sheetName = $sheetName;
        $this->data = $data;
        $this->strip_tags = $strip_tags;
    }

    public function collection(): Collection
    {
        if ($this->strip_tags) {
            return $this->data->map(function ($item) {
                // Strip HTML tags from each value
                return collect($item)->map(fn($value) => strip_tags($value));
            });
        } else {
            return $this->data;
        }
    }

    public function headings(): array
    {
        $this->headers = $this->data->isNotEmpty() ? array_keys((array)$this->data->first()) : [];
        return $this->headers;
    }

    public function styles(Worksheet $sheet)
    {
        if (!empty($this->headers)){
            $sheet->setAutoFilter('A1:'.chr(64 + count($this->headers)).'1');
        }

        if ($this->sheetName) {
            $sheet->setTitle($this->sheetName);
        }

        return [
            1 => [ // Apply styles to the first row (headers)
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFCCCCCC'], // Light gray background
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        $widths = [];
        if ($this->data->isNotEmpty()) {
            // Get headings
            $headings = $this->headings();

            // Set widths based on headings and longest values
            foreach ($headings as $index => $heading) {
                $maxLength = strlen($heading); // Start with the length of the heading

                // Check each row to find the maximum length of the data in this column
                foreach ($this->data as $item) {
                    $valueLength = strlen((string)$item[$heading] ?? ''); // Access property using object notation
                    if ($valueLength > $maxLength) {
                        $maxLength = $valueLength;
                    }
                }

                $widths[chr(65 + $index)] = $maxLength + 2; // Add a little padding
            }
        }
        return $widths;
    }
}
