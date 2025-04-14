<?php

namespace App\Exports;

use App\Models\Complaint;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class ComplaintsExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Complaint::query();

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['month'])) {
            $query->whereMonth('date', $this->filters['month']);
        }

        if (!empty($this->filters['year'])) {
            $query->whereYear('date', $this->filters['year']);
        }

        return $query->orderBy('id', 'desc')->get()->map(function ($complaint, $index) {
            return [
                'no' => $index + 1,
                'complaint' => $complaint,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'No Keluhan',
            'Pelapor',
            'No Seri Produk',
            'Lokasi',
            'Deskripsi',
            'No Telepon',
            'Institusi',
            'Tanggal',
            'Status'
        ];
    }

    public function map($row): array
    {
        $complaint = $row['complaint'];

        return [
            $row['no'],
            $complaint->id,
            $complaint->reporter,
            $complaint->serial_number,
            $complaint->location,
            $complaint->description,
            $complaint->telp,
            $complaint->institution,
            $complaint->date,
            $complaint->status,
        ];
    }
}
