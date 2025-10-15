<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\PenggunaModel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('login/login');
    }
    public function signIn(Request $request)
    {
        return redirect()->route('content.dashboard');
    }
    public function register(): View
    {
        return view('register.register');
    }
    public function signOut()
    {
        Session::flush();
        Session::flash('msgOut', 'You have successfully signed out.');
        return redirect('/');
    }

    public function signUp(Request $request): RedirectResponse
    {
        ##dd($request->all());
        $request->validate([
            'username' => ['required', 'string', 'max:10'],
            'nama' => ['required', 'string'],
            'password' => ['required', 'min:4'],
            'department' => ['required', 'string'],

        ]);
        $role = 0;// all department = member
        if ($request->department === 'GA') {
            $role = 1; //GA
        } elseif ($request->department === 'MIS') {
            $role = 2; //Admin
        }
        $user = PenggunaModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'department' => $request->department,
            'role' => $role,
        ]);
        // event(new Registered($user));
        Session::flash('msgOut', 'You have successfully sign up.');
        return redirect('/');
    }

    public function loginsubmit(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:4',
        ]);

        // Cari user berdasarkan username
        $user = DB::table('pengguna_models')->where('username', $data['username'])->first();

        // Cek apakah user ada dan password cocok
        if ($user && Hash::check($data['password'], $user->password)) {

            // Simpan data user ke session
            $request->session()->put('user', [
                'id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
                'departement' => $user->department,
                'role' => $user->role
            ]);

            Session::flash('msgOut', 'You have successfully login.');

            // Arahkan sesuai role
            if ($user->role === 1) {
                return redirect()->route('content.dashboardGA');
            } elseif ($user->role === 2) {
                return redirect()->route('content.dashboardAdmin');
            } else {
                return redirect()->route('content.dashboard');
            }
        }

        // Kalau gagal (username / password salah)
        return redirect()->back()->with('error', 'Invalid username or password!');
    }
    public function usernameValidate(Request $request)
    {
        $exists = PenggunaModel::where('username', $request->username)->exists();

        return response()->json([
            'exists' => $exists
        ]);

    }


}
