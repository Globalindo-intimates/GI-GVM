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
            'oli_mesin',
            'oli_power_steering',
            'oli_rem',
            'body_kendaraan',
            'otomatis_starter',
            'radiator',
            'baterai_aki',
            'wipers_depan',
            'wipers_belakang',
            'ban_depan',
            'ban_belakang',
            'lampu_depan',
            'lampu_belakang',
            'lampu_rem',
            'klakson',
            'kebersihan',
            'kunci_roda',
            'dongkrak',
            'kotak_p3k',
            'segitiga_pengaman'
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
    // CONTROLLER FIX - DataController.php update method

public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

    // Find vehicle data
    $vehicle = KendaraanModel::findOrFail($id);

    // Prepare data untuk update
    $data = [
        'tanggal' => $request->tanggal,
        'oli_mesin' => $request->oli_mesin ?? '✔',
        'oli_power_steering' => $request->oli_power_steering ?? '✔',
        'oli_rem' => $request->oli_rem ?? '✔',
        'body_kendaraan' => $request->body_kendaraan ?? '✔',
        'otomatis_starter' => $request->otomatis_starter ?? '✔',
        'radiator' => $request->radiator ?? '✔',
        'baterai_aki' => $request->baterai_aki ?? '✔',
        'wipers_depan' => $request->wipers_depan ?? '✔',
        'wipers_belakang' => $request->wipers_belakang ?? '✔',
        'ban_depan' => $request->ban_depan ?? '✔',
        'ban_belakang' => $request->ban_belakang ?? '✔',
        'lampu_depan' => $request->lampu_depan ?? '✔',
        'lampu_belakang' => $request->lampu_belakang ?? '✔',
        'lampu_rem' => $request->lampu_rem ?? '✔',
        'klakson' => $request->klakson ?? '✔',
        'kebersihan' => $request->kebersihan ?? '✔',
        'kunci_roda' => $request->kunci_roda ?? '✔',
        'dongkrak' => $request->dongkrak ?? '✔',
        'kotak_p3k' => $request->kotak_p3k ?? '✔',
        'segitiga_pengaman' => $request->segitiga_pengaman ?? '✔',
        'is_updated' => true, // Menandai bahwa data ini sudah di-update
        'status' => null, // Reset status untuk verifikasi ulang
        'pemeriksa' => null, // Reset pemeriksa
        'reject_reason' => null, // Clear reject reason
    ];

    // Update vehicle image if new image uploaded
    if ($request->hasFile('image')) {
        // Delete old image
        if ($vehicle->image && Storage::disk('public')->exists('vehicle/' . $vehicle->image)) {
            Storage::disk('public')->delete('vehicle/' . $vehicle->image);
        }
        
        // Upload new image
        $image = $request->file('image');
        $image->storeAs('vehicle', $image->hashName(), 'public');
        $data['image'] = $image->hashName();
    }

    // Array field yang mungkin memiliki gambar kerusakan
    $damageImageFields = [
        'oli_mesin', 'oli_power_steering', 'oli_rem', 'body_kendaraan',
        'otomatis_starter', 'radiator', 'baterai_aki', 'wipers_depan',
        'wipers_belakang', 'ban_depan', 'ban_belakang', 'lampu_depan',
        'lampu_belakang', 'lampu_rem', 'klakson', 'kebersihan',
        'kunci_roda', 'dongkrak', 'kotak_p3k', 'segitiga_pengaman'
    ];

    // Process damage images and reasons
    foreach ($damageImageFields as $field) {
        $imageFieldName = $field . '_image';
        $reasonFieldName = $field . '_reason';
        $statusValue = $request->input($field);

        // If status is ✖ (damaged)
        if ($statusValue === '✖') {
            // Handle reason
            if ($request->has($reasonFieldName)) {
                $data[$reasonFieldName] = $request->input($reasonFieldName);
            }

            // Handle image upload
            if ($request->hasFile($imageFieldName)) {
                // Delete old damage image if exists
                if ($vehicle->$imageFieldName && Storage::disk('public')->exists('damages/' . $vehicle->$imageFieldName)) {
                    Storage::disk('public')->delete('damages/' . $vehicle->$imageFieldName);
                }
                // Upload new damage image
                $damageImage = $request->file($imageFieldName);
                $damageImage->storeAs('damages', $damageImage->hashName(), 'public');
                $data[$imageFieldName] = $damageImage->hashName();
            }
        } else {
            $data[$reasonFieldName] = null;
            
            // Delete damage image if exists
            if ($vehicle->$imageFieldName && Storage::disk('public')->exists('damages/' . $vehicle->$imageFieldName)) {
                Storage::disk('public')->delete('damages/' . $vehicle->$imageFieldName);
            }
            $data[$imageFieldName] = null;
        }
    }

    // Update the vehicle data
    $vehicle->update($data);

    return redirect()->back()->with('success', 'Vehicle data updated successfully and resubmitted for review!');
}
// Tambahkan method ini ke DataController.php atau Controller verifikasi Anda

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:✔,✖',
        'pemeriksa' => 'required|string',
        'reject_reason' => 'nullable|string'
    ]);

    $vehicle = KendaraanModel::findOrFail($id);

    $data = [
        'status' => $request->status,
        'pemeriksa' => $request->pemeriksa,
        'is_updated' => false, // Reset flag is_updated setelah verifikasi
    ];

    // Jika status reject, simpan alasan
    if ($request->status === '✖') {
        $data['reject_reason'] = $request->reject_reason;
    } else {
        $data['reject_reason'] = null;
    }

    $vehicle->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Vehicle data verified successfully!'
    ]);
}
public function verification(): View
{
    $vehicles = KendaraanModel::latest()->get();
    return view('content.verification', compact('vehicles'));
}

public function status(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:✔,✖',
        'pemeriksa' => 'required|string',
        'reject_reason' => 'nullable|string'
    ]);

    $vehicle = KendaraanModel::findOrFail($id);

    $data = [
        'status' => $request->status,
        'pemeriksa' => $request->pemeriksa,
        'is_updated' => false, // Reset flag is_updated setelah verifikasi
    ];

    // Jika status reject, simpan alasan
    if ($request->status === '✖') {
        $data['reject_reason'] = $request->reject_reason;
    } else {
        $data['reject_reason'] = null;
    }

    $vehicle->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Vehicle data verified successfully!'
    ]);
}
}