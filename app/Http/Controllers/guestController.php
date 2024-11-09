<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;

class guestController extends Controller
{
    public function index()
    {
        return view('guest.home');
    }

    public function store(Request $request)
    {
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

        $complaint = Complaint::create($data);

        return redirect()->route('guest.show', Crypt::encrypt($complaint->id))->with('success', 'Berhasil! Keluhan anda akan segera di proses oleh petugas kami.');
    }

    public function show($id)
    {
        $complaint = Complaint::findOrFail(Crypt::decrypt($id));

        return view('guest.show', compact('complaint'));
    }

    public function checkDataView()
    {
        return view('guest.checkData');
    }

    public function checkData(Request $request)
    {
        $request->validate(
            [
                'id' => 'required|numeric',
                'serial_number' => 'required|max:255',
            ],
            [
                'id.numeric' => 'No keluhan berupa angka.'
            ]
        );

        $complaintNumber = $request->input('id');
        $serialNumber = $request->input('serial_number');

        $complaint = Complaint::where('id', $complaintNumber)
            ->where('serial_number', $serialNumber)
            ->first();

        if ($complaint) {
            return redirect()->route('guest.checkDataResult', Crypt::encrypt($complaint->id));
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
    }

    public function checkDataResult($id)
    {
        $complaint = Complaint::findOrFail(Crypt::decrypt($id));

        return view('guest.show', compact('complaint'));
    }

    public function downloadPdf($id)
    {
        $complaint = Complaint::findOrFail(Crypt::decrypt($id));

        // return view('guest.download-pdf', compact('complaint'));

        $data = $complaint->toArray();

        $pdf = Pdf::loadView('guest.download-pdf', $data);
        return $pdf->stream("bukti-pengajuan-keluhan-{$complaint->id}.pdf");
    }
}
