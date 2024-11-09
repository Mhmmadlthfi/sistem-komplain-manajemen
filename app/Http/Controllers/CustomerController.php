<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::query();

        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $customers->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('telp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $customers->orderBy('id', 'desc')->paginate(5);

        foreach ($customers as $customer) {
            $customer->can_delete = $customer->sale()->count() == 0;
        }

        return view('admin.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required|max:255',
                'telp' => 'required|max:13|regex:/^[0-9]+$/|unique:users',
                'email' => 'required|email:dns|unique:users',

            ],
            [
                'telp.regex' => 'No Telepon harus berupa angka!',
                'telp.max' => 'No Telepon tidak boleh lebih dari 13 angka!',
                'email.email' => 'Masukan alamat email yang valid!'
            ]
        );

        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Customer berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate(
            [
                'name' => 'required|max:255',
                'telp' => 'required|max:13|regex:/^[0-9]+$/|unique:users',
                'email' => 'required|email:dns|unique:users',

            ],
            [
                'telp.regex' => 'No Telepon harus berupa angka!',
                'telp.max' => 'No Telepon tidak boleh lebih dari 13 angka!',
                'email.email' => 'Masukan alamat email yang valid!'
            ]
        );

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if (!Gate::allows('marketing')) {
            abort(403);
        }

        if ($customer->sale()->count() !== 0) {
            return redirect()->back()->with('error', 'Data customer ini telah terhubung ke data penjualan, tidak dapat dihapus.');
        }

        Customer::destroy($customer->id);
        return redirect()->route('customers.index')->with('success', 'Data Customer berhasil dihapus.');
    }
}
