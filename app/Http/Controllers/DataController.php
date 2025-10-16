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
        // Validasi input
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'nama_pelapor' => 'required|string|max:255',
            'id_kendaraan' => 'required|int',
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
            // Validasi untuk gambar kerusakan
            'oli_mesin_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'oli_power_steering_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'oli_rem_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'body_kendaraan_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'otomatis_starter_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'radiator_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'baterai_aki_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'wipers_depan_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'wipers_belakang_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ban_depan_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ban_belakang_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lampu_depan_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lampu_belakang_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lampu_rem_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'klakson_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kebersihan_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kunci_roda_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'dongkrak_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kotak_p3k_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'segitiga_pengaman_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // Validasi untuk alasan kerusakan
            'oli_mesin_reason' => 'nullable|string',
            'oli_power_steering_reason' => 'nullable|string',
            'oli_rem_reason' => 'nullable|string',
            'body_kendaraan_reason' => 'nullable|string',
            'otomatis_starter_reason' => 'nullable|string',
            'radiator_reason' => 'nullable|string',
            'baterai_aki_reason' => 'nullable|string',
            'wipers_depan_reason' => 'nullable|string',
            'wipers_belakang_reason' => 'nullable|string',
            'ban_depan_reason' => 'nullable|string',
            'ban_belakang_reason' => 'nullable|string',
            'lampu_depan_reason' => 'nullable|string',
            'lampu_belakang_reason' => 'nullable|string',
            'lampu_rem_reason' => 'nullable|string',
            'klakson_reason' => 'nullable|string',
            'kebersihan_reason' => 'nullable|string',
            'kunci_roda_reason' => 'nullable|string',
            'dongkrak_reason' => 'nullable|string',
            'kotak_p3k_reason' => 'nullable|string',
            'segitiga_pengaman_reason' => 'nullable|string',
        ]);

        // Upload gambar kendaraan utama
        $image = $request->file('image');
        $image->storeAs('vehicle', $image->hashName(), 'public');
        
        // Get data kendaraan dari master data
        $vehicle = MasterdataModel::find($request->id_kendaraan, ["no_polisi", "merk", "tahun", "jenis"]);

        // Prepare data untuk disimpan
        $data = [
            'user_id' => session('user.id'),
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
        ];

        // Array field yang mungkin memiliki gambar kerusakan
        $damageImageFields = [
            'oli_mesin', 'oli_power_steering', 'oli_rem', 'body_kendaraan', 
            'otomatis_starter', 'radiator', 'baterai_aki', 'wipers_depan', 
            'wipers_belakang', 'ban_depan', 'ban_belakang', 'lampu_depan', 
            'lampu_belakang', 'lampu_rem', 'klakson', 'kebersihan', 
            'kunci_roda', 'dongkrak', 'kotak_p3k', 'segitiga_pengaman'
        ];

        // Upload gambar kerusakan jika ada
        foreach ($damageImageFields as $field) {
            $imageFieldName = $field . '_image';
            $reasonFieldName = $field . '_reason';
            
            if ($request->hasFile($imageFieldName)) {
                $damageImage = $request->file($imageFieldName);
                $damageImage->storeAs('damages', $damageImage->hashName(), 'public');
                $data[$imageFieldName] = $damageImage->hashName();
            }
            
            // Simpan alasan kerusakan jika ada
            if ($request->has($reasonFieldName)) {
                $data[$reasonFieldName] = $request->input($reasonFieldName);
            }
        }

        // Simpan ke database
        KendaraanModel::create($data);

        return redirect()->route('content.kendaraan')->with('success', 'Vehicle data saved successfully!');
    }
}