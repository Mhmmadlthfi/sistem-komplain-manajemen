<?php

namespace App\Http\Controllers;

use App\Models\Handling;
use App\Models\ResolvedComplaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $handlings = Handling::where('user_id', $user->id)
            ->with(['sale.customer', 'sale.saleDetail'])
            ->whereHas('resolvedComplaint');

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
            'Sudah diperbaiki',
            'Tidak dapat diperbaiki'
        ];

        return view('admin.riwayatPenanganan.index', compact('handlings', 'statusOptions'));
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
    public function show(Handling $technician_history)
    {
        $handling = $technician_history;
        $handling->load(['complaint', 'sale.customer', 'sale.saleDetail.product']);

        return view('admin.riwayatPenanganan.show', compact('handling'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Handling $technician_history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Handling $technician_history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Handling $technician_history)
    {
        //
    }
}
