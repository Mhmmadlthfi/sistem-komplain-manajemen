<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Warranty;
use App\Exports\SalesExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{

    public function export(Request $request)
    {
        $filters = $request->only(['month', 'year']);

        $query = Sale::query();

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $filters['month']);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $filters['year']);
        }

        $dataExists = $query->exists();

        if ($dataExists) {
            return (new SalesExport($filters))->download('daftarPenjualan.xlsx');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang sesuai untuk diekspor.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sales = Sale::query();

        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $sales->where(function ($query) use ($search) {
                $query->where('SPK', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $sales = $sales->orderBy('id', 'desc')->paginate(10);

        foreach ($sales as $sale) {
            $sale->can_delete = $sale->handling()->count() == 0;
        }

        return view('admin.penjualan.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('marketing')) {
            abort(403);
        }

        $products = Product::all();
        $customers = Customer::all();
        $technicians = User::where('role', 'teknisi')
            ->where('status', true)
            ->get();

        return view('admin.penjualan.create', compact('products', 'customers', 'technicians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'customer_id' => 'required|exists:customers,id',
                'spk' => 'required|string|max:255|unique:sales',
                'sent_date' => 'required|date',
                'received_date' => 'required|date|after_or_equal:sent_date',
                'user_id' => 'required|exists:users,id',
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.serial_number' => 'required|string|max:255|unique:sale_details',
                'products.*.commissioning_date' => 'required|date|after_or_equal:received_date',
                'products.*.location' => 'required|string|max:255',
                'products.*.warranty.start_date' => 'required|date',
                'products.*.warranty.end_date' => 'required|date|after_or_equal:products.*.warranty.start_date',
            ],
            [
                'spk.unique' => 'SPK tersebut sudah tersedia dalam data penjualan lain, periksa kembali.',
                'received_date.after_or_equal' => 'Tanggal diterima tidak boleh kurang dari tanggal kirim.',
                'products.*.serial_number.unique' => 'Nomor seri tersebut sudah tersedia dalam data penjualan lain, periksa kembali.',
                'products.*.warranty.end_date.after_or_equal' => 'Tanggal berakhir garansi tidak boleh kurang dari tanggal mulai garansi.',
                'products.*.commissioning_date.after_or_equal' => 'Tanggal komisioning tidak boleh kurang dari tanggal diterima.',
            ]
        );

        $sale = Sale::create([
            'customer_id' => $data['customer_id'],
            'spk' => $data['spk'],
            'sent_date' => $data['sent_date'],
            'received_date' => $data['received_date'],
            'user_id' => $data['user_id'],
        ]);

        foreach ($data['products'] as $productData) {
            $saleDetail = $sale->saleDetail()->create([
                'product_id' => $productData['product_id'],
                'serial_number' => $productData['serial_number'],
                'commissioning_date' => $productData['commissioning_date'],
                'location' => $productData['location'],
            ]);

            Warranty::create([
                'sale_detail_id' => $saleDetail->id,
                'start_date' => $productData['warranty']['start_date'],
                'end_date' => $productData['warranty']['end_date'],
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        if (!Gate::allows('marketing')) {
            abort(403);
        }

        $sale = $sale->load(['customer', 'saleDetail.product', 'saleDetail.warranty']);

        return view('admin.penjualan.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $sale = Sale::with('saleDetail.warranty')->findOrFail($sale->id);
        $technicians = User::where('role', 'teknisi')
            ->where('status', true)
            ->get();
        $customers = Customer::all();
        $products = Product::all();

        return view('admin.penjualan.edit', compact('sale', 'technicians', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $data = $request->validate(
            [
                'customer_id' => 'required|exists:customers,id',
                'spk' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('sales')->ignore($sale->id),
                ],
                'sent_date' => 'required|date',
                'received_date' => 'required|date|after_or_equal:sent_date',
                'user_id' => 'required|exists:users,id',
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.serial_number' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('sale_details', 'serial_number')->ignore($sale->id, 'sale_id'),
                ],
                'products.*.commissioning_date' => 'required|date|after_or_equal:received_date',
                'products.*.location' => 'required|string|max:255',
                'products.*.warranty.start_date' => 'required|date',
                'products.*.warranty.end_date' => 'required|date|after_or_equal:products.*.warranty.start_date',
            ],
            [
                'spk.unique' => 'SPK tersebut sudah tersedia dalam data penjualan lain, periksa kembali.',
                'received_date.after_or_equal' => 'Tanggal diterima tidak boleh kurang dari tanggal kirim.',
                'products.*.serial_number.unique' => 'Nomor seri tersebut sudah tersedia dalam data penjualan lain, periksa kembali.',
                'products.*.warranty.end_date.after_or_equal' => 'Tanggal berakhir garansi tidak boleh kurang dari tanggal mulai garansi.',
                'products.*.commissioning_date.after_or_equal' => 'Tanggal komisioning tidak boleh kurang dari tanggal diterima.',
            ]
        );

        DB::beginTransaction();

        try {
            $sale->update([
                'customer_id' => $data['customer_id'],
                'spk' => $data['spk'],
                'sent_date' => $data['sent_date'],
                'received_date' => $data['received_date'],
                'user_id' => $data['user_id'],
            ]);

            Warranty::whereIn('sale_detail_id', $sale->saleDetail()->pluck('id'))->delete();

            $sale->saleDetail()->delete();

            foreach ($data['products'] as $productData) {
                $saleDetail = $sale->saleDetail()->create([
                    'product_id' => $productData['product_id'],
                    'serial_number' => $productData['serial_number'],
                    'commissioning_date' => $productData['commissioning_date'],
                    'location' => $productData['location'],
                ]);

                Warranty::create([
                    'sale_detail_id' => $saleDetail->id,
                    'start_date' => $productData['warranty']['start_date'],
                    'end_date' => $productData['warranty']['end_date'],
                ]);
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil diperbarui.');
        } catch (QueryException $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Data gagal diperbarui. Nomor Seri Produk bersifat unik dalam setiap data penjualan yang telah ada, pastikan tidak ada data yang sama, periksa kembali.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        if (!Gate::allows('marketing')) {
            abort(403);
        }

        if ($sale->handling()->count() !== 0) {
            return redirect()->back()->with('error', 'Data penjualan ini telah terhubung ke data penanganan keluhan, tidak dapat dihapus.');
        }

        Warranty::whereIn('sale_detail_id', $sale->saleDetail()->pluck('id'))->delete();

        $sale->saleDetail()->delete();

        Sale::destroy($sale->id);
        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil dihapus.');
    }

    // Fungsi Tambahan
    public function customerSearch(Request $request)
    {
        $data = Customer::where('name', 'LIKE', '%' . $request->input('q') . '%')->paginate(5);
        return response()->json($data);
    }

    public function productSearch(Request $request)
    {
        $data = Product::where('name', 'LIKE', '%' . $request->input('q') . '%')->paginate(5);
        return response()->json($data);
    }
}
