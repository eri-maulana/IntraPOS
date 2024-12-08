<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ProductsExport(),
            new CategoriesExport(),
        ];
    }
}

class ProductsExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'name',
            'category_id',
            'stock',
            'price',
            'is_active',
            'image',
            'barcode',
            'description'
        ];
    }

    public function title(): string
    {
        return 'Template Produk';
    }
}

class CategoriesExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::select('id', 'name')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'nama kategori',
        ];
    }

    public function title(): string
    {
        return 'Template Kategori';
    }
}
