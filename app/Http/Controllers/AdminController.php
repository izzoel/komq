<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $rewards = Reward::all();
        return view('admin', compact('rewards'));
    }

    public function login()
    {
        return view('login');
    }

    public function logout(Request $request)
    {
        // hapus semua session
        $request->session()->flush();

        // redirect ke halaman login
        return redirect('/login')->with('success', 'Berhasil logout!');
    }


    public function proses(Request $request)
    {
        // $passwordBenar = "komq"; // ganti sesuai password kamu

        // if ($request->password === $passwordBenar) {
        //     session(['admin_login' => true]);
        //     return redirect('/admin');
        // }

        // return back()->with('gagal', true);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['success' => true, 'message' => 'Sukses']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal']);
        }
    }
}
