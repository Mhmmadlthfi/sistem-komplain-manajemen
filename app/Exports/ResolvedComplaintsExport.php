<?php

namespace App\Exports;

use App\Models\ResolvedComplaint;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class ResolvedComplaintsExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = ResolvedComplaint::with('handling.complaint', 'handling.sale.customer', 'handling.sale.saleDetail', 'handling.user');

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['month'])) {
            $query->whereMonth('created_at', $this->filters['month']);
        }
        if (!empty($this->filters['year'])) {
            $query->whereYear('created_at', $this->filters['year']);
        }

        return $query->get()->map(function ($resolvedComplaint, $index) {
            return [
                'no' => $index + 1,
                'resolved_complaint' => $resolvedComplaint,
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
            'Status Penyelesaian',
            'Tgl Penyelesaian',
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
        $resolvedComplaint = $row['resolved_complaint'];
        $handling = $resolvedComplaint->handling;
        $location = '';
        foreach ($handling->sale->saleDetail as $saleDetail) {
            if ($saleDetail->serial_number === $handling->complaint->serial_number) {
                $location = $saleDetail->location;
                break;
            }
        }

        $teknisi = "{$handling->user->no_staff} | {$handling->user->name}";
        $rescheduleDate = $handling->reschedule_date ? $handling->reschedule_date : '-';
        $completionDate = Carbon::parse($resolvedComplaint->created_at)->format('Y-m-d');

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
            $resolvedComplaint->status,
            $completionDate,
            $handling->initial_condition,
            $handling->action,
            $handling->repair_result,
            $handling->repair_notes,
            $handling->repair_evidence,
            $handling->handling_location,
        ];
    }
}
