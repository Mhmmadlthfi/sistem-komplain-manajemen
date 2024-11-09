<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Sale::with('customer', 'saleDetail.product', 'saleDetail.warranty');

        if (!empty($this->filters['month'])) {
            $query->whereMonth('created_at', $this->filters['month']);
        }

        if (!empty($this->filters['year'])) {
            $query->whereYear('created_at', $this->filters['year']);
        }

        $sales = $query->orderBy('id', 'desc')->get();

        $exportData = collect();

        foreach ($sales as $sale) {
            foreach ($sale->saleDetail as $saleDetail) {
                $exportData->push([
                    'no' => $exportData->count() + 1,
                    'customer' => $sale->customer->name ?? '',
                    'spk' => $sale->spk ?? '',
                    'telp' => $sale->customer->telp ?? '',
                    'email' => $sale->customer->email ?? '',
                    'sent_date' => $sale->sent_date ?? '',
                    'received_date' => $sale->received_date ?? '',
                    'pic' => $sale->user->name ?? '',
                    'serial_number' => $saleDetail->serial_number ?? '',
                    'product_name' => $saleDetail->product->name ?? '',
                    'commissioning_date' => $saleDetail->commissioning_date ?? '',
                    'location' => $saleDetail->location ?? '',
                    'warranty_start_date' => $saleDetail->warranty->start_date ?? '',
                    'warranty_end_date' => $saleDetail->warranty->end_date ?? '',
                ]);
            }
        }
        return $exportData;
    }


    public function headings(): array
    {
        return [
            'No',
            'Customer',
            'SPK',
            'Telp',
            'Email',
            'Tgl Kirim',
            'Tgl Diterima',
            'PIC',
            'No Seri Produk',
            'Nama Produk',
            'Tgl Komisioning',
            'Lokasi',
            'Tgl Mulai Garansi',
            'Tgl Berakhir Garansi',
        ];
    }

    public function map($row): array
    {
        return [
            $row['no'],
            $row['customer'],
            $row['spk'],
            $row['telp'],
            $row['email'],
            $row['sent_date'],
            $row['received_date'],
            $row['pic'],
            $row['serial_number'],
            $row['product_name'],
            $row['commissioning_date'],
            $row['location'],
            $row['warranty_start_date'],
            $row['warranty_end_date'],
        ];
    }
}
