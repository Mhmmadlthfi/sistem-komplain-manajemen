<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Handling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MobileApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $handlings = Handling::where('user_id', $user->id)
            ->orderByDesc('id')
            ->with([
                'user',
                'complaint',
                'sale.customer',
                'sale.saleDetail.product',
                'sale.saleDetail.warranty'
            ])
            ->whereDoesntHave('resolvedComplaint')
            ->get();

        return response()->json([
            'handlings' => $handlings,
        ], 200);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Handling $handling)
    {
        $validator = Validator::make($request->all(), [
            'initial_condition' => 'required|string',
            'action' => 'required|string',
            'repair_result' => 'required|string',
            'repair_notes' => 'required|string',
            'repair_evidence' => 'required|file|mimes:jpeg,png,jpg,pdf|max:3072',
            'handling_location' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan, periksa kembali!',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $request->only([
            'initial_condition',
            'action',
            'repair_result',
            'repair_notes',
            'status',
            'handling_location'
        ]);

        if ($request->hasFile('repair_evidence')) {
            if ($handling->repair_evidence) {
                Storage::delete($handling->repair_evidence);
            }

            $validatedData['repair_evidence'] = $request->file('repair_evidence')->store('handling-repair_evidence', 'public');
        }

        $handling->update($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menyimpan data.',
            'data' => $handling,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Handling $handling)
    {
        //
    }
}
