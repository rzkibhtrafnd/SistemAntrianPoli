<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $polis = Poli::all(); // Ambil data poli untuk dropdown
        return view('admin.users.create', compact('polis'));
    }

    /**
     * Menyimpan pengguna baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,staff',
            'poli_id' => 'nullable|exists:polis,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Menyimpan data pengguna
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'poli_id' => $request->poli_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit pengguna yang ada.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $polis = Poli::all(); // Ambil data poli untuk dropdown
        return view('admin.users.edit', compact('user', 'polis'));
    }

    /**
     * Mengupdate data pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,staff',
            'poli_id' => 'nullable|exists:polis,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit', $user->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        // Mengupdate data pengguna
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->poli_id = $request->poli_id;

        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
