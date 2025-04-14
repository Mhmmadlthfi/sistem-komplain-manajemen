<?php

namespace App\Http\Controllers;

use App\Models\Handling;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Models\RescheduleHistory;
use App\Models\ResolvedComplaint;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Exports\ResolvedComplaintsExport;

class ResolvedComplaintController extends Controller
{
    public function export(Request $request)
    {
        $filters = $request->only(['status', 'month', 'year']);

        // Cek data dari request apakah tersedia di database
        $query = ResolvedComplaint::query();
        if ($request->filled('status')) {
            $query->where('status', $filters['status']);
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $filters['month']);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $filters['year']);
        }
        $dataExists = $query->exists();

        if ($dataExists) {
            return (new ResolvedComplaintsExport($filters))->download('DataKeluhan.xlsx');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang sesuai untuk diekspor.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resolvedComplaints = ResolvedComplaint::with('handling.complaint', 'handling.sale.customer', 'handling.sale.saleDetail.product');

        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $resolvedComplaints->where(function ($q) use ($search) {
                $q->WhereHas('handling.sale.customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('handling.sale.saleDetail', function ($q) use ($search) {
                    $q->where('location', 'like', "%{$search}%");
                })->orWhereHas('handling', function ($q) use ($search) {
                    $q->where('complaint_id', 'like', "%{$search}%");
                });
            })->orWhere('created_at', 'like', "%{$search}%");
        }

        if (request()->has('status') && request('status') != '') {
            $resolvedComplaints->where('status', request('status'));
        }

        $resolvedComplaints = $resolvedComplaints->orderBy('id', 'desc')->paginate(10);

        $statusOptions = [
            'Selesai',
            'Tidak dapat diperbaiki'
        ];

        // return compact('resolvedComplaints');
        return view('admin.keluhanSelesai.index', compact('resolvedComplaints', 'statusOptions'));
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
    public function show(ResolvedComplaint $resolved_complaint)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $resolved_complaint->load(['handling.complaint', 'handling.sale.customer', 'handling.sale.saleDetail.product']);

        // return compact('resolved_complaint');
        return view('admin.keluhanSelesai.show', compact('resolved_complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResolvedComplaint $resolved_complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResolvedComplaint $resolved_complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResolvedComplaint $resolved_complaint)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        if ($resolved_complaint->handling->complaint->attachment) {
            Storage::delete($resolved_complaint->handling->complaint->attachment);
        }

        if ($resolved_complaint->handling->repair_evidence) {
            Storage::delete($resolved_complaint->handling->repair_evidence);
        }

        Complaint::destroy($resolved_complaint->handling->complaint_id);

        Handling::destroy($resolved_complaint->handling_id);

        ResolvedComplaint::destroy($resolved_complaint->id);

        return redirect()->route('resolved-complaint.index')->with('success', [
            'message' => 'Berhasil! Data keluhan selesai dengan no keluhan @complaintId berhasil dihapus.',
            'complaintId' => $resolved_complaint->handling->complaint_id,
        ]);
    }

    /**
     * Fungsi Tambahan
     */
    public function rescheduleHistories(ResolvedComplaint $resolved_complaint)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $histories = RescheduleHistory::where('handling_id', $resolved_complaint->handling->id)->get();

        // return compact('histories', 'resolved_complaint');
        return view('admin.keluhanSelesai.rescheduleHistories', compact('histories', 'resolved_complaint'));
    }
}
