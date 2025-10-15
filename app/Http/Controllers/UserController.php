<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenggunaModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:10', 'unique:pengguna_models,username'],
            'nama' => ['required', 'string'],
            'password' => ['required', 'min:4'],
            'department' => ['required', 'string'],
        ]);

        // Tentukan role otomatis berdasarkan department
        $role = 0;
        if ($request->department === 'GA') {
            $role = 1; // GA
        } elseif ($request->department === 'MIS') {
            $role = 2; // Admin
        }

        PenggunaModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'department' => $request->department,
            'role' => $role,
        ]);

        Session::flash('success', 'User successfully added!');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $user = PenggunaModel::findOrFail($id);

        $request->validate([
            'nama' => ['required', 'string'],
            'password' => ['nullable', 'min:4'],
            'department' => ['required', 'string'],
        ]);

        // Role otomatis saat edit
        $role = 0;
        if ($request->department === 'GA') {
            $role = 1;
        } elseif ($request->department === 'MIS') {
            $role = 2;
        }

        $user->update([
            'nama' => $request->nama,
            'department' => $request->department,
            'role' => $role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        Session::flash('success', 'User successfully updated!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = PenggunaModel::findOrFail($id);
        $user->delete();

        Session::flash('success', 'User successfully deleted!');
        return redirect()->back();
    }
}