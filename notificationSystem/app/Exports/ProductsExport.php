<?php

namespace App\Exports;

use App\Models\AppModelsProduct;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all(['name', 'quantity_in_stock', 'minimum_threshold']);
    }

    /**
     * Return the headings for the Excel file
     */
    public function headings(): array
    {
        return [
            'Product Name',
            'Stock Quantity',
            'Minimum Threshold',
        ];
    }

    /**
     * Return the sheet title
     */
    public function title(): string
    {
        return 'Products';
    }
}
