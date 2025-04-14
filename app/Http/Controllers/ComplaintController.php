<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Handling;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Exports\ComplaintsExport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function export(Request $request)
    {
        $filters = $request->only(['status', 'month', 'year']);

        $query = Complaint::query();
        if ($request->filled('status')) {
            $query->where('status', $filters['status']);
        }
        if ($request->filled('month')) {
            $query->whereMonth('date', $filters['month']);
        }
        if ($request->filled('year')) {
            $query->whereYear('date', $filters['year']);
        }
        $dataExists = $query->exists();

        if ($dataExists) {
            return (new ComplaintsExport($filters))->download('DataKeluhanMasuk.xlsx');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang sesuai untuk diekspor.');
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Complaint::query();
        $statusOptions = [
            'Diterima',
            'Diproses',
            'Tidak dapat diperbaiki',
            'Selesai',
            'Tidak Valid',
        ];

        // Pencarian berdasarkan 'search'
        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $complaints->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('reporter', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('telp', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%")
                    ->orWhere('date', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if (request()->has('status') && request('status') != '') {
            $complaints->where('status', request('status'));
        }

        $complaints = $complaints->orderBy('id', 'desc')->paginate(10);

        foreach ($complaints as $complaint) {
            $complaint->can_delete = $complaint->handling()->count() == 0;
        }

        return view('admin.keluhanMasuk.index', compact('complaints', 'statusOptions'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        return view('admin.keluhanMasuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $data = $request->validate(
            [
                'reporter' => 'required|max:255',
                'serial_number' => 'required|max:255',
                'location' => 'required|max:255',
                'telp' => 'required|max:13|regex:/^[0-9]+$/|unique:users',
                'institution' => 'required|max:255',
                'description' => 'required',
                'attachment' => 'file|mimes:jpeg,png,jpg,pdf|max:3072',
            ],
            [
                'telp.regex' => 'No Telepon harus berupa angka!',
                'telp.max' => 'No Telepon tidak boleh lebih dari 13 angka!',
                'attachment.file' => 'Unggahan harus berupa file.',
                'attachment.mimes' => 'Hanya file berformat jpeg, jpg, png, dan pdf yang diperbolehkan.',
                'attachment.max' => 'Ukuran file tidak boleh lebih dari 3MB.',
            ]
        );

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('complaint-attachment', 'public');
        }

        $data['date'] = Carbon::now();

        Complaint::create($data);

        return redirect()->route('complaint.index')->with('success', [
            'message' => 'Berhasil! Data keluhan baru berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $serialNumber = $complaint->serial_number;

        $sale = Sale::whereHas('saleDetail', function ($query) use ($serialNumber) {
            $query->where('serial_number', $serialNumber);
        })->with(['customer', 'saleDetail.product', 'saleDetail.warranty'])->first();

        $technicians = User::where('role', 'teknisi')
            ->where('status', true)
            ->get();

        return view('admin.keluhanMasuk.show', compact('complaint', 'sale', 'technicians'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        return view('admin.keluhanMasuk.edit', compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $data = [
            'reporter' => 'required|max:255',
            'serial_number' => 'required|max:255',
            'location' => 'required|max:255',
            'institution' => 'required|max:255',
            'description' => 'required',
        ];

        if ($request->telp != $complaint->telp) {
            $data['telp'] = 'required|max:13|regex:/^[0-9]+$/|unique:users';
        } else {
            $data['telp'] = 'required|max:13|regex:/^[0-9]+$/';
        }

        $messages = [
            'telp.regex' => 'No Telepon harus berupa angka!',
            'telp.max' => 'No Telepon tidak boleh lebih dari 13 angka!',
        ];

        $validatedData = $request->validate($data, $messages);

        $complaint->update($validatedData);

        return redirect()->route('complaint.index')->with('success', [
            'message' => 'Berhasil! Data keluhan no @complaintId berhasil diupdate.',
            'complaintId' => $complaint->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        if ($complaint->handling()->count() !== 0) {
            return redirect()->back()->with('error', 'Data keluhan ini telah terhubung ke data penanganan, tidak dapat dihapus.');
        }

        if ($complaint->attachment) {
            Storage::delete($complaint->attachment);
        }

        Complaint::destroy($complaint->id);
        return redirect()->route('complaint.index')->with('success', [
            'message' => 'Berhasil! Data keluhan dengan no keluhan @complaintId berhasil dihapus.',
            'complaintId' => $complaint->id,
        ]);
    }


    /**
     * Fungsi Tambahan 
     */
    public function handlingStore(Request $request, Complaint $complaint)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'user_id' => 'required|exists:users,id',
            'handling_date' => 'required|date|after_or_equal:today',
        ], [
            'handling_date.after_or_equal' => 'Tanggal penanganan tidak boleh kurang dari tanggal hari ini.',
        ]);

        Handling::create([
            'complaint_id' => $complaint->id,
            'sale_id' => $request->sale_id,
            'user_id' => $request->user_id,
            'handling_date' => $request->handling_date,
        ]);

        $complaint->update(['status' => 'Diproses']);

        return redirect()->route('complaint.index')->with('success', [
            'message' => 'Berhasil! Keluhan dengan nomor keluhan @complaintId berhasil dijadwalkan untuk ditangani.',
            'complaintId' => $complaint->id,
        ]);
    }

    public function invalidData(Complaint $complaint)
    {
        if (!Gate::allows('aftersales')) {
            abort(403);
        }

        $complaint->update(['status' => 'Tidak Valid']);

        return redirect()->route('complaint.index')->with('success', [
            'message' => 'Berhasil! Keluhan dengan nomor keluhan @complaintId telah ditandai sebagai @status',
            'complaintId' => $complaint->id,
            'status' => 'Tidak Valid',
        ]);
    }
}
