<?php

namespace App\Http\Controllers;

//import model product
use App\Models\KendaraanModel;
use App\Models\MasterdataModel;

//import return type View
use DB;
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Http Request
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * index
     *
     * @return void
     */

    
    public function index(): View
    {
        $vehicle = KendaraanModel::latest()->paginate(10);
        return view('content.lihatdata', compact('vehicle'));
    }

    public function create(): View
    {
        return view('content.dashboard');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'nama_pelapor' => 'required|string|max:255',
            'id_kendaraan' => 'required|int',
            // 'no_polisi' => 'required|string|max:255',
            // 'merk' => 'required|string|max:100',
            // 'tahun' => 'required|string|max:10',
            // 'jenis' => 'nullable|in:Motor,Mobil,Truck',
            'tanggal' => 'required|date',
            'oli_mesin' => 'nullable|in:✔,✖',
            'oli_power_steering' => 'nullable|in:✔,✖',
            'oli_rem' => 'nullable|in:✔,✖',
            'body_kendaraan' => 'nullable|in:✔,✖',
            'otomatis_starter' => 'nullable|in:✔,✖',
            'radiator' => 'nullable|in:✔,✖',
            'baterai_aki' => 'nullable|in:✔,✖',
            'wipers_depan' => 'nullable|in:✔,✖',
            'wipers_belakang' => 'nullable|in:✔,✖',
            'ban_depan' => 'nullable|in:✔,✖',
            'ban_belakang' => 'nullable|in:✔,✖',
            'lampu_depan' => 'nullable|in:✔,✖',
            'lampu_belakang' => 'nullable|in:✔,✖',
            'lampu_rem' => 'nullable|in:✔,✖',
            'klakson' => 'nullable|in:✔,✖',
            'kebersihan' => 'nullable|in:✔,✖',
            'kunci_roda' => 'nullable|in:✔,✖',
            'dongkrak' => 'nullable|in:✔,✖',
            'kotak_p3k' => 'nullable|in:✔,✖',
            'segitiga_pengaman' => 'nullable|in:✔,✖',
        ]);
        

        // Upload file jika ada
        $image = $request->file('image');
        $image->storeAs('vehicle', $image->hashName(), 'public');
        $vehicle = MasterdataModel::find($request->id_kendaraan, ["no_polisi","merk","tahun","jenis"]);
        //dd($vehicle->no_polisi);

 
        KendaraanModel::create([
            'user_id'=> session('user.id'),
            'image' => $image->hashName(),
            'nama_pelapor' => $request->nama_pelapor,
            'id_kendaraan' => $request->id_kendaraan,
            'no_polisi' => $vehicle->no_polisi,
            'merk' => $vehicle->merk,
            'tahun' => $vehicle->tahun,
            'jenis' => $vehicle->jenis,
            'tanggal' => $request->tanggal,
            'oli_mesin' => $request->oli_mesin,
            'oli_power_steering' => $request->oli_power_steering,
            'oli_rem' => $request->oli_rem,
            'body_kendaraan' => $request->body_kendaraan,
            'otomatis_starter' => $request->otomatis_starter,
            'radiator' => $request->radiator,
            'baterai_aki' => $request->baterai_aki,
            'wipers_depan' => $request->wipers_depan,
            'wipers_belakang' => $request->wipers_belakang,
            'ban_depan' => $request->ban_depan,
            'ban_belakang' => $request->ban_belakang,
            'lampu_depan' => $request->lampu_depan,
            'lampu_belakang' => $request->lampu_belakang,
            'lampu_rem' => $request->lampu_rem,
            'klakson' => $request->klakson,
            'kebersihan' => $request->kebersihan,
            'kunci_roda' => $request->kunci_roda,
            'dongkrak' => $request->dongkrak,
            'kotak_p3k' => $request->kotak_p3k,
            'segitiga_pengaman' => $request->segitiga_pengaman,
        ]);

        return redirect()->route('content.kendaraan')->with('success', 'Vehicle data saved successfully!');
    }
}