<?php

namespace App\Http\Controllers;

use App\Models\KendaraanModel;
use App\Models\MasterdataModel;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    public function index(): View
    {
        $vehicle = KendaraanModel::latest()->paginate(10);
        return view('content.lihatdata', compact('vehicle'));
    }

    public function create(): View
    {
        return view('content.dashboard');
    }

    public function checkExistingData(Request $request)
    {
        $tanggal = $request->tanggal;
        $id_kendaraan = $request->id_kendaraan;
        
        $exists = KendaraanModel::where('tanggal', $tanggal)
                               ->where('id_kendaraan', $id_kendaraan)
                               ->exists();
        
        return response()->json([
            'exists' => $exists
        ]);
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
        ]);

        // Cek duplikasi data
        $existingData = KendaraanModel::where('tanggal', $request->tanggal)
                                      ->where('id_kendaraan', $request->id_kendaraan)
                                      ->first();
        
        if ($existingData) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Data for this vehicle on the selected date already exists!');
        }

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

            if ($request->has($reasonFieldName)) {
                $data[$reasonFieldName] = $request->input($reasonFieldName);
            }
        }

        // Simpan ke database
        KendaraanModel::create($data);

        return redirect()->route('content.kendaraan')->with('success', 'Vehicle data saved successfully!');
    }
//     public function update(Request $request, $id)
// {
//     $kendaraan = KendaraanModel::findOrFail($id);

//     // Update basic info
//     $kendaraan->tanggal = $request->tanggal;

//     // Update image kendaraan (jika ada upload baru)
//     if ($request->hasFile('image')) {
//         $file = $request->file('image');
//         $filename = time().'_'.$file->getClientOriginalName();
//         $file->storeAs('public/vehicle', $filename);
//         $kendaraan->image = $filename;
//     }

//     // Loop semua item kontrol
//     $keyMapping = [
//         'oli_mesin', 'oli_power_steering', 'oli_rem', 'body_kendaraan', 'otomatis_starter',
//         'radiator', 'baterai_aki', 'wipers_depan', 'wipers_belakang', 'ban_depan', 'ban_belakang',
//         'lampu_depan', 'lampu_belakang', 'lampu_rem', 'klakson', 'kebersihan', 'kunci_roda',
//         'dongkrak', 'kotak_p3k', 'segitiga_pengaman'
//     ];

//     foreach ($keyMapping as $key) {
//         $status = $request->$key;
//         $reasonField = $key . '_reason';
//         $imageField = $key . '_image';

//         $kendaraan->$key = $status;
//         $kendaraan->$reasonField = $request->$reasonField;

//         if ($request->hasFile($imageField)) {
//             $file = $request->file($imageField);
//             $filename = time().'_'.$file->getClientOriginalName();
//             $file->storeAs('public/damages', $filename);
//             $kendaraan->$imageField = $filename;
//         }
//     }

//     // Jika semua item ✔, ubah status utama jadi ✔
//     $hasDamage = false;
//     foreach ($keyMapping as $key) {
//         if ($request->$key === '✖') {
//             $hasDamage = true;
//             break;
//         }
//     }

//     $kendaraan->status = $hasDamage ? '✖' : '✔';
//     $kendaraan->save();

//     return redirect()->back()->with('success', 'Vehicle data has been successfully updated!');
// }

}