<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::with('doctors')->latest()->get();
        return view('admin.polis.index', compact('polis'));
    }

    public function show(Poli $poli)
    {
        $poli->load('doctors');
        return view('admin.polis.show', compact('poli'));
    }

    public function create()
    {
        return view('admin.polis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
        ]);

        $poli = Poli::create($validated);

        return redirect()->route('polis.index')->with('success', 'Poli berhasil ditambahkan.');
    }

    public function edit(Poli $poli)
    {
        return view('admin.polis.edit', compact('poli'));
    }

    public function update(Request $request, Poli $poli)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
        ]);

        $poli->update($validated);

        return redirect()->route('polis.index')->with('success', 'Poli berhasil diperbarui.');
    }

    public function destroy(Poli $poli)
    {
        $poli->delete();
        return redirect()->route('polis.index')->with('success', 'Poli berhasil dihapus.');
    }
}
