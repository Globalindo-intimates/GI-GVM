<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterdataModel;
use Illuminate\Support\Facades\Storage;

class MasterController extends Controller
{
    // Menampilkan data kendaraan
    public function index()
    {
        $kendaraan = MasterdataModel::latest()->paginate(10);
        return view('content.masterdata', compact('kendaraan'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'no_polisi' => 'required|string|max:20',
            'merk' => 'required|string|max:50',
            'tahun' => 'required|integer',
            'jenis' => 'required|string',
        ]);

        MasterdataModel::create([
            'no_polisi' => $request->no_polisi,
            'merk' => $request->merk,
            'tahun' => $request->tahun,
            'jenis' => $request->jenis,
        ]);

        return redirect()->back()->with('success', 'Vehicle data has been successfully saved.');
    }

    // Update data kendaraan
    public function update(Request $request, $id)
    {
        $kendaraan = MasterdataModel::findOrFail($id);

        $request->validate([
        'no_polisi' => 'required|string|max:20',
        'merk'      => 'required|string|max:100',
        'tahun'     => 'required|numeric',
        'jenis'     => 'required|string',
    ]);

    $kendaraan = MasterdataModel::findOrFail($id);

    $kendaraan->update([
        'no_polisi' => $request->no_polisi,
        'merk'      => $request->merk,
        'tahun'     => $request->tahun,
        'jenis'     => $request->jenis,
    ]);

        return redirect()->back()->with('success', 'Vehicle data has been successfully updated.');
    }

    // Hapus data kendaraan
    public function destroy($id)
    {
        $kendaraan = MasterdataModel::findOrFail($id);

        // hapus foto
        $kendaraan->delete();

        return redirect()->back()->with('success', 'Vehicle data has been successfully deleted.');
    }
}
