<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    //
    public function index(){
        // Mengambil semua data departemen
        $departemens = Departemen::paginate(6);

        // Mengembalikan view dengan data departemen
        return view('departemen.dashboard', compact('departemens'));
    }

    public function create(){
        // Menampilkan form untuk menambah departemen baru
        return view('departemen.create');
    }

    public function store(Request $request)
{
    // Validasi
    $request->validate([
        'nama_departemen' => 'required|string|max:50|unique:departemens,nama_departemen',
    ]);

    // Simpan ke database
    Departemen::create([
        'nama_departemen' => $request->nama_departemen
    ]);

    // Redirect dengan notifikasi sukses
    return redirect()->route('departemen.dashboard')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit($id_departemen)
{
    $departemen = Departemen::findOrFail($id_departemen);
    return view('departemen.edit', compact('departemen'));
}

public function update(Request $request, $id_departemen)
{
    $request->validate([
        'nama_departemen' => 'required|string|max:50|unique:departemens,nama_departemen,' . $id_departemen . ',id_departemen',
    ]);

    $departemen = Departemen::findOrFail($id_departemen);
    $departemen->update([
        'nama_departemen' => $request->nama_departemen,
    ]);

    return redirect()->route('departemen.dashboard')->with('success', 'Departemen berhasil diperbarui.');
}

public function destroy($id_departemen)
{
    $departemen = Departemen::findOrFail($id_departemen);
    $departemen->delete();

    return redirect()->route('departemen.dashboard')->with('success', 'Departemen berhasil dihapus.');
}

}
