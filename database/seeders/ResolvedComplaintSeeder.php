<?php

namespace Database\Seeders;

use App\Models\Handling;
use App\Models\Complaint;
use Illuminate\Database\Seeder;
use App\Models\ResolvedComplaint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResolvedComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resolvedComplaints = [
            [
                "handling_id" => 1,
                "status" => "Selesai",
                "created_at" => "2024-05-13 00:00:00",
            ],
            [
                "handling_id" => 2,
                "status" => "Selesai",
                "created_at" => "2024-05-23 00:00:00",
            ],
            [
                "handling_id" => 3,
                "status" => "Selesai",
                "created_at" => "2024-06-02 00:00:00",
            ],
            [
                "handling_id" => 4,
                "status" => "Selesai",
                "created_at" => "2024-06-06 00:00:00",
            ],
            [
                "handling_id" => 5,
                "status" => "Selesai",
                "created_at" => "2024-06-09 00:00:00",
            ],
            [
                "handling_id" => 6,
                "status" => "Selesai",
                "created_at" => "2024-06-13 00:00:00",
            ],
            [
                "handling_id" => 7,
                "status" => "Selesai",
                "created_at" => "2024-06-16 00:00:00",
            ],
            [
                "handling_id" => 8,
                "status" => "Selesai",
                "created_at" => "2024-06-18 00:00:00",
            ],
            [
                "handling_id" => 9,
                "status" => "Selesai",
                "created_at" => "2024-06-23 00:00:00",
            ],
            [
                "handling_id" => 10,
                "status" => "Selesai",
                "created_at" => "2024-06-26 00:00:00",
            ],
            [
                "handling_id" => 11,
                "status" => "Selesai",
                "created_at" => "2024-06-28 00:00:00",
            ],
            [
                "handling_id" => 12,
                "status" => "Selesai",
                "created_at" => "2024-07-05 00:00:00",
            ],
            [
                "handling_id" => 13,
                "status" => "Tidak dapat diperbaiki",
                "created_at" => "2024-07-13 00:00:00",
            ],
            [
                "handling_id" => 14,
                "status" => "Tidak dapat diperbaiki",
                "created_at" => "2024-07-21 00:00:00",
            ],
            [
                "handling_id" => 15,
                "status" => "Tidak dapat diperbaiki",
                "created_at" => "2024-07-28 00:00:00",
            ],
        ];

        foreach ($resolvedComplaints as $resolvedComplaint) {
            ResolvedComplaint::create($resolvedComplaint);
        }

        foreach ($resolvedComplaints as $resolvedComplaint) {
            $handlingId = $resolvedComplaint['handling_id'];
            $resolvedStatus = $resolvedComplaint['status'];

            $handling = Handling::find($handlingId);

            if ($handling) {
                $complaint = Complaint::find($handling->complaint_id);

                if ($complaint) {
                    $complaint->update(['status' => $resolvedStatus]);
                }
            }
        }
    }
}
