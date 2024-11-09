<?php

namespace App\Exports;

use App\Models\Handling;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class HandlingsExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Handling::with(['complaint', 'sale.customer', 'sale.saleDetail', 'user'])->whereDoesntHave('resolvedComplaint');

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['month'])) {
            $query->whereMonth('handling_date', $this->filters['month']);
        }

        if (!empty($this->filters['year'])) {
            $query->whereYear('handling_date', $this->filters['year']);
        }

        return $query->orderBy('id', 'desc')->get()->map(function ($handling, $index) {
            return [
                'no' => $index + 1,
                'handling' => $handling,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'No Keluhan',
            'Pelapor',
            'No Telp Pelapor',
            'Customer',
            'SPK',
            'No Telp Customer',
            'Lokasi',
            'Tgl Keluhan',
            'Tgl Penanganan',
            'Tgl Penjadwalan Ulang',
            'Teknisi',
            'Status Penanganan',
            'Kondisi Awal',
            'Tindakan',
            'Hasil Perbaikan',
            'Catatan Perbaikan',
            'Bukti Perbaikan',
            'Lokasi Penanganan',
        ];
    }

    public function map($row): array
    {
        $handling = $row['handling'];
        $location = '';
        foreach ($handling->sale->saleDetail as $saleDetail) {
            if ($saleDetail->serial_number === $handling->complaint->serial_number) {
                $location = $saleDetail->location;
                break;
            }
        }

        $teknisi = "{$handling->user->no_staff} | {$handling->user->name}";

        $rescheduleDate = $handling->reschedule_date ? $handling->reschedule_date : '-';

        return [
            $row['no'],
            $handling->complaint_id,
            $handling->complaint->reporter,
            $handling->complaint->telp,
            $handling->sale->customer->name,
            $handling->sale->spk,
            $handling->sale->customer->telp,
            $location,
            $handling->complaint->date,
            $handling->handling_date,
            $rescheduleDate,
            $teknisi,
            $handling->status,
            $handling->initial_condition,
            $handling->action,
            $handling->repair_result,
            $handling->repair_notes,
            $handling->repair_evidence,
            $handling->handling_location,
        ];
    }
}
