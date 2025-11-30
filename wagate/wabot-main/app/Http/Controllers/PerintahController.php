<?php

namespace App\Http\Controllers;

use App\DataTables\PerintahDataTable;
use App\Models\Perintah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PerintahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PerintahDataTable $dataTable)
    {
        return $dataTable->render('perintah.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perintah = new Perintah();
        return view('perintah.create', compact('perintah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required','string','max:255','unique:perintah',Rule::notIn(['status'])],
            'pesan' => 'required|string|max:1000',
        ]);

        $perintah = Perintah::create([
            'nama' => $request->input('nama'),
            'pesan' => $request->input('pesan'),
        ]);

        return redirect()
            ->route('perintah.index')
            ->with('success', 'Perintah "'.$request->input('nama').'" berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perintah $perintah)
    {
        return view('perintah.edit', compact('perintah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perintah $perintah)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:perintah,nama,'.$perintah->id,
            'pesan' => 'required|string|max:1000',
        ]);

        $perintah->update($request->all());

        return redirect()
            ->route('perintah.index')
            ->with('success', 'Perintah "'.$perintah->nama.'" berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perintah $perintah)
    {
        $perintah->delete();
        return redirect()
            ->route('perintah.index')
            ->with('success', 'Perintah "'.$perintah->nama.'" berhasil dihapus');
    }
}
