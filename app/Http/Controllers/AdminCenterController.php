<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminCenterController extends Controller
{
    public function index()
    {
        $this->ensureSuperAdmin();

        $centers = User::where(function ($query) {
                $query->where('super_admin', false)->orWhereNull('super_admin');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'username', 'email', 'telephone', 'company', 'expire_date']);

        return view('admin-centers.index', compact('centers'));
    }

    public function create()
    {
        $this->ensureSuperAdmin();

        return view('admin-centers.create');
    }

    public function store(Request $request)
    {
        $this->ensureSuperAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'company' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
            'expire_date' => ['nullable', 'date'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        User::create([
            'name' => $data['name'],
            'username' => strtolower($data['username']),
            'email' => $data['email'],
            'company' => $data['company'] ?? null,
            'telephone' => $data['telephone'] ?? null,
            'password' => Hash::make($data['password']),
            'expire_date' => $data['expire_date'] ?? Carbon::today()->addMonth(),
            'export_test' => false,
            'super_admin' => false,
        ]);

        return redirect()->route('admin.centers.create')->with('success', 'Center created successfully. You can now import tests to it.');
    }

    public function resetPassword(Request $request, User $center)
    {
        $this->ensureSuperAdmin();
        abort_if($center->super_admin, 403);

        $data = $request->validate([
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        $center->password = Hash::make($data['password']);
        $center->save();

        return redirect()->route('admin.centers.index')->with('success', 'Password updated for '.$center->name.'.');
    }

    private function ensureSuperAdmin()
    {
        abort_unless(auth()->user() && auth()->user()->super_admin, 403);
    }
}
