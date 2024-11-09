<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query();

        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $users->where(function ($q) use ($search) {
                $q->where('no_staff', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('telp', 'like', "%{$search}%");
            });
        }

        if (request()->has('role') && request('role') != '') {
            $users->where('role', request('role'));
        }

        $users = $users->orderBy('id', 'desc')->paginate(5);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = [
            'aftersales' => 'Aftersales',
            'manager_marketing' => 'Manager Marketing',
            'marketing' => 'Marketing',
            'teknisi' => 'Teknisi',
        ];

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'no_staff' => 'required|digits:5',
                'name' => 'required|max:255',
                'email' => 'required|email:dns|unique:users',
                'telp' => 'required|max:13|regex:/^[0-9]+$/|unique:users',
                'role' => 'required',
                'password' => 'required|max:255'

            ],
            [
                'no_staff.digits' => 'No petugas harus berupa angka dan harus berjumlah 5 karakter!',
                'telp.regex' => 'No Telepon harus berupa angka!',
                'telp.max' => 'No Telepon tidak boleh lebih dari 13 angka!',
                'role.required' => 'Pilih role terlebih dahulu!',
                'email.email' => 'Masukan alamat email yang valid!'
            ]
        );

        User::create($data);

        return redirect()->route('manage-users.index')->with('success', 'User baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $manage_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $manage_user)
    {
        $roles = [
            'aftersales' => 'Aftersales',
            'manager_marketing' => 'Manager Marketing',
            'marketing' => 'Marketing',
            'teknisi' => 'Teknisi',
        ];

        $user = $manage_user;

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $manage_user)
    {
        $data =
            [
                'no_staff' => 'required|digits:5',
                'name' => 'required|max:255',
                'role' => 'required',
                'status' => 'boolean',
            ];

        if ($request->email != $manage_user->email) {
            $data['email'] = 'required|email:dns|unique:users';
        } else {
            $data['email'] = 'required|email:dns';
        }

        if ($request->telp != $manage_user->telp) {
            $data['telp'] = 'required|max:13|regex:/^[0-9]+$/|unique:users';
        } else {
            $data['telp'] = 'required|max:13|regex:/^[0-9]+$/';
        }

        $messages = [
            'no_staff.digits' => 'No petugas harus berupa angka dan harus berjumlah 5 karakter!',
            'telp.regex' => 'No Telepon harus berupa angka!',
            'telp.max' => 'No Telepon tidak boleh lebih dari 13 angka!',
            'role.required' => 'Pilih role terlebih dahulu!',
            'email.email' => 'Masukan alamat email yang valid!',
        ];

        $validatedData = $request->validate($data, $messages);

        $validatedData['status'] = $request->boolean('status');

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        }

        $manage_user->update($validatedData);

        return redirect()->route('manage-users.index')->with('success', "Data user dengan no petugas {$manage_user->no_staff} berhasil di update.");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $manage_user)
    {
        User::destroy($manage_user->id);
        return redirect()->route('manage-users.index')->with('success', 'Data user berhasil dihapus!');
    }
}
