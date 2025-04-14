<?php

namespace App\Http\Controllers;

use App\Models\Handling;
use Illuminate\Http\Request;
use App\Exports\HandlingsExport;
use App\Models\Complaint;
use App\Models\RescheduleHistory;
use App\Models\ResolvedComplaint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class HandlingController extends Controller
{
    public function export(Request $request)
    {
        $filters = $request->only(['status', 'month', 'year']);

        // Cek data dari request apakah tersedia di database
        $query = Handling::query();
        if ($request->filled('status')) {
            $query->where('status', $filters['status']);
        }
        if ($request->filled('month')) {
            $query->whereMonth('handling_date', $filters['month']);
        }
        if ($request->filled('year')) {
            $query->whereYear('handling_date', $filters['year']);
        }
        $dataExists = $query->exists();

        if ($dataExists) {
            return (new HandlingsExport($filters))->download('daftarPenanganan.xlsx');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang sesuai untuk diekspor.');
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $handlings = Handling::with(['complaint', 'sale.customer', 'sale.saleDetail.product'])->whereDoesntHave('resolvedComplaint');

        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $handlings->where(function ($q) use ($search) {
                $q->where('complaint_id', 'like', "%{$search}%")
                    ->orWhere(function ($q) use ($search) {
                        $q->WhereHas('sale.customer', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })->orWhereHas('sale.saleDetail', function ($q) use ($search) {
                            $q->where('location', 'like', "%{$search}%");
                        });
                    })->orWhere('handling_date', 'like', "%{$search}%");
            });
        }

        if (request()->has('status') && request('status') != '') {
            $handlings->where('status', request('status'));
        }

        $handlings = $handlings->orderBy('id', 'desc')->paginate(10);

        $statusOptions = [
            'Dalam penanganan',
            'Sudah diperbaiki',
            'Penjadwalan ulang',
            'Tidak dapat diperbaiki'
        ];

        foreach ($handlings as $handling) {
            $handling->can_delete = $handling->resolvedComplaint()->count() == 0;
        }

        return view('admin.penanganan.index', compact('handlings', 'statusOptions'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Handling $handling)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $handling->load(['complaint', 'sale.customer', 'sale.saleDetail.product']);

        $resolvedComplaintExists = ResolvedComplaint::where('handling_id', $handling->id)->exists();

        return view('admin.penanganan.show', compact('handling', 'resolvedComplaintExists'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Handling $handling)
    {
        // return view('admin.penanganan.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Handling $handling)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $data = $request->validate(
            [
                'handling_date' => 'required|date|after_or_equal:today',
            ],
            [
                'handling_date.after_or_equal' => 'Tanggal penanganan tidak boleh kurang dari tanggal hari ini!'
            ]
        );

        $handling->update([
            'handling_date' => $data['handling_date']
        ]);

        return redirect()->route('handling.index')->with('success', [
            'message' => 'Berhasil! Mengubah tanggal penanganan no keluhan @complaintId menjadi tanggal  ' . $handling->handling_date . '.',
            'complaintId' => $handling->complaint_id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Handling $handling)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        if ($handling->resolvedComplaint()->count() !== 0) {
            return redirect()->back()->with('error', 'Data penanganan ini telah terhubung ke data keluhan selesai, tidak dapat dihapus.');
        }

        Complaint::where('id', $handling->complaint_id)->update(['status' => 'Diterima']);

        if ($handling->repair_evidence) {
            Storage::delete($handling->repair_evidence);
        }

        Handling::destroy($handling->id);

        return redirect()->route('handling.index')->with('success', [
            'message' => 'Berhasil! Data penanganan keluhan dengan no keluhan @complaintId berhasil dihapus.',
            'complaintId' => $handling->complaint_id,
        ]);
    }

    /**
     * Fungsi tambahan 
     */
    public function rescheduleStore(Request $request, Handling $handling)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $request->validate([
            'reschedule_date' => 'required|date|after_or_equal:today',
            'description' => 'required',
        ], [
            'reschedule_date.after_or_equal' => 'Tanggal penjadwalan ulang tidak boleh kurang dari tanggal penanganan dan kurang dari tanggal hari ini.',
            'description.required' => 'Deskripsi wajid diisi.'
        ]);

        $reschedule = new RescheduleHistory();
        $reschedule->handling_id = $handling->id;
        $reschedule->reschedule_date = $request->reschedule_date;
        $reschedule->description = $request->description;
        $reschedule->save();

        $handling->update([
            'reschedule_date' => $request->reschedule_date,
            'status' => 'Penjadwalan ulang'
        ]);

        return redirect()->route('handling.index')->with('success', [
            'message' => 'Berhasil! Penanganan dengan nomor keluhan @complaintId berhasil dijadwalkan ulang pada tanggal ' . $handling->reschedule_date . '.',
            'complaintId' => $handling->complaint_id,
        ]);
    }

    public function rescheduleHistories(Handling $handling)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $histories = RescheduleHistory::where('handling_id', $handling->id)->paginate(3);
        return view('admin.penanganan.rescheduleHistories', compact('histories', 'handling'));
    }

    public function repairEvidenceUpdate(Request $request, Handling $handling)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $validatedData = $request->validate(
            [
                'repair_evidence' => 'file|mimes:jpeg,png,jpg,pdf|max:3072',
            ],
            [
                'repair_evidence.file' => 'Unggahan harus berupa file.',
                'repair_evidence.mimes' => 'Hanya file berformat jpeg, jpg, png, dan pdf yang diperbolehkan.',
                'repair_evidence.max' => 'Ukuran file tidak boleh lebih dari 3MB.',
            ]
        );

        if ($request->hasFile('repair_evidence')) {
            if ($handling->repair_evidence) {
                Storage::delete($handling->repair_evidence);
            }

            $validatedData['repair_evidence'] = $request->file('repair_evidence')->store('handling-repair_evidence', 'public');
        }

        $handling->update($validatedData);

        return redirect()->back()->with('success', 'Berhasil! Mengubah hasil penanganan dari keluhan no ' . $handling->complaint_id . '.');
    }

    public function resolvedComplaintStore(Request $request, Handling $handling)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $validStatuses = ['Sudah diperbaiki', 'Tidak dapat diperbaiki'];

        if (!in_array($handling->status, $validStatuses)) {
            return redirect()->route('handling.index')->with('error', 'Status penanganan tidak valid.');
        }

        $data = [
            'handling_id' => $handling->id,
            'status' => $handling->status === 'Sudah diperbaiki' ? 'Selesai' : 'Tidak dapat diperbaiki',
        ];

        $resolvedComplaint = ResolvedComplaint::create($data);

        // Update status complaint berdasarkan status resolvedComplaint
        $complaintStatus = $resolvedComplaint->status;

        $updateComplaintStatus = Complaint::where('id', $handling->complaint_id)->update([
            'status' => $complaintStatus
        ]);

        if (!$updateComplaintStatus) {
            return redirect()->route('handling.index')->with('error', 'Gagal update status complaint.');
        }

        return redirect()->route('handling.index')->with('success', [
            'message' => 'Berhasil! Penanganan dengan nomor keluhan @complaintId telah berhasil diselesaikan.',
            'complaintId' => $handling->complaint_id,
        ]);
    }
}
