<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterItemsExport implements FromCollection, WithHeadings, WithMapping
{
    private $rowNumber = 0;

    public function collection()
    {
        return MasterItem::with('categories')->orderBy('id', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Nama Items',
            'Nama Supplier',
            'Harga',
            'Laba',
            'Harga Jual',
        ];
    }

    public function map($item): array
    {
        $this->rowNumber++;
        $categoriesString = $item->categories->pluck('nama')->implode(', ');
        $hargaJual = round($item->harga_beli + ($item->harga_beli * $item->laba / 100));

        return [
            $this->rowNumber,
            $categoriesString ?: '-',
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $item->laba,
            $hargaJual,
        ];
    }
}
