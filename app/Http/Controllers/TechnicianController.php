<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Handling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $handlings = Handling::where('user_id', $user->id)->orderBy('id', 'desc')
            ->with(['complaint', 'sale.customer', 'sale.saleDetail.product'])
            ->whereDoesntHave('resolvedComplaint')
            ->get();

        // return $handlings;

        return view('admin.penangananTeknisi.index', compact('handlings'));
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
    public function show(Handling $technician_handling)
    {
        $handling = $technician_handling->load(['complaint', 'sale.customer', 'sale.saleDetail.product', 'sale.saleDetail.warranty']);

        return view('admin.penangananTeknisi.show', compact('handling'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Handling $technician_handling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Handling $technician_handling)
    {
        $validatedData = $request->validate(
            [
                'initial_condition' => 'required|string',
                'action' => 'required|string',
                'repair_result' => 'required|string',
                'repair_notes' => 'required|string',
                'repair_evidence' => 'required|file|mimes:jpeg,png,jpg,pdf|max:3072',
                'handling_location' => 'required|string',
                'status' => 'required|string',
            ],
            [
                'initial_condition.required' => 'Harap isi kondisi awal.',
                'action.required' => 'Harap isi tindakan yang dilakukan.',
                'repair_result.required' => 'Harap isi hasil perbaikan.',
                'repair_notes.required' => 'Harap isi catatan perbaikan.',
                'repair_evidence.required' => 'Harap Upload Hasil atau Bukti Penanganan.',
                'repair_evidence.file' => 'Unggahan harus berupa file.',
                'repair_evidence.mimes' => 'Hanya file berformat jpeg, jpg, png, dan pdf yang diperbolehkan.',
                'repair_evidence.max' => 'Ukuran file tidak boleh lebih dari 3MB.',
                'handling_location.required' => 'Lokasi penanganan wajib ada.',
                'status.required' => 'Pilih status keluhan yang valid.',
            ]
        );

        if ($request->hasFile('repair_evidence')) {
            if ($technician_handling->repair_evidence) {
                Storage::delete($technician_handling->repair_evidence);
            }

            $validatedData['repair_evidence'] = $request->file('repair_evidence')->store('handling-repair_evidence', 'public');
        }

        $technician_handling->update($validatedData);

        return redirect()->route('technician-handling.index')->with('success', [
            'message' => 'Berhasil! Data keluhan dengan no keluhan @complaintId telah tandai sebagai status penanganan @status.',
            'complaintId' => $technician_handling->complaint_id,
            'status' => $request->status,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Handling $technician_handling)
    {
        //
    }
}
