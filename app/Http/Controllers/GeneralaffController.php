<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KendaraanModel;
use App\Models\MasterdataModel;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;


class GeneralaffController extends Controller
{
    public function index()
    {
        $vehicles = KendaraanModel::latest()->paginate(10);
        return view('content.dataperawatan', compact('vehicles'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Log request untuk debugging
            \Log::info('Update Request', [
                'id' => $id,
                'status' => $request->status,
                'pemeriksa' => $request->pemeriksa,
                'reject_reason' => $request->reject_reason,
                'all_data' => $request->all()
            ]);

            $vehicle = KendaraanModel::findOrFail($id);

            // Validasi dengan conditional rule untuk reject_reason
            $rules = [
                'status' => 'required|in:✔,✖',
                'pemeriksa' => 'required|string|max:255',
            ];

            // Jika status ditolak (✖), reject_reason wajib diisi
            if ($request->status === '✖') {
                $rules['reject_reason'] = 'required|string|max:1000';
            }

            $validated = $request->validate($rules);

            // Update data
            $vehicle->status = $validated['status'];
            $vehicle->pemeriksa = $validated['pemeriksa'];
            
            // Set reject_reason jika status ditolak, atau kosongkan jika diterima
            if ($validated['status'] === '✖') {
                $vehicle->reject_reason = $request->reject_reason;
            } else {
                $vehicle->reject_reason = null;
            }

            $vehicle->save();

            \Log::info('Update Success', ['vehicle' => $vehicle]);

            // Return JSON response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data verified successfully!',
                    'data' => $vehicle
                ], 200);
            }

            // Return redirect untuk non-AJAX
            return redirect()->back()->with('success', 'Data updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error', ['errors' => $e->errors()]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            \Log::error('Update Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $vehicle = KendaraanModel::findOrFail($id);
        $vehicle->delete();

        return redirect()->route('content.dataperawatan')->with('success', 'Data deleted successfully!');
    }

    public function detailData($id, Request $request)
    {
        $tanggal = $request->query('tanggal');
        $date = \Carbon\Carbon::parse($tanggal);

        $records = KendaraanModel::where('id_kendaraan', $id)
            ->whereMonth('tanggal', $date->month)
            ->whereYear('tanggal', $date->year)
            ->orderBy('tanggal')
            ->get();

        // ambil kendaraan pertama jd referensi
        $vehicle = $records->first();

        // mapping data per hari
        $daysInMonth = $date->daysInMonth;
        $items = [
            'oli_mesin' => 'Oli Mesin',
            'oli_power_steering' => 'Oli Power Steering',
            'oli_rem' => 'Oli Rem',
            'body_kendaraan' => 'Body Kendaraan',
            'otomatis_starter' => 'Otomatis / Starter',
            'radiator' => 'Radiator',
            'baterai_aki' => 'Baterai / Aki',
            'wipers_depan' => 'Wipers Depan',
            'wipers_belakang' => 'Wipers Belakang',
            'ban_depan' => 'Ban Depan',
            'ban_belakang' => 'Ban Belakang',
            'lampu_depan' => 'Lampu Depan',
            'lampu_belakang' => 'Lampu Belakang',
            'lampu_rem' => 'Lampu Rem',
            'klakson' => 'Klakson',
            'kebersihan' => 'Kebersihan',
            'kunci_roda' => 'Kunci Roda',
            'dongkrak' => 'Dongkrak',
            'kotak_p3k' => 'Kotak P3K',
            'segitiga_pengaman' => 'Segitiga Pengaman'
        ];

        $tableData = [];
        foreach ($items as $key => $label) {
            $row = [
                'label' => $label,
                'days' => []
            ];
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $record = $records->firstWhere('tanggal', $date->copy()->day($d)->toDateString());
                $row['days'][$d] = $record ? ($record->$key ?? '') : '';
            }
            $tableData[] = $row;
        }

        // nambah baris Keterangan
        $statusRow = [
            'label' => 'Status',
            'days' => [],
            'highlight' => true
        ];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $record = $records->firstWhere('tanggal', $date->copy()->day($d)->toDateString());
            $statusRow['days'][$d] = $record ? ($record->status ?? '') : '';
        }
        $tableData[] = $statusRow;

        return response()->json([
            'vehicle' => $vehicle,
            'month' => strtoupper($date->locale('id')->monthName) . " " . $date->year,
            'daysInMonth' => $daysInMonth,
            'tableData' => $tableData
        ]);
    }

    public function print($id)
    {
        // Ambil bulan dan tahun dari query string, default ke bulan & tahun sekarang
        $month = request('month', date('m'));
        $year = request('year', date('Y'));

        // Buat tanggal dari bulan dan tahun
        $tanggal = "{$year}-{$month}-01";
        $date = \Carbon\Carbon::parse($tanggal);

        // Ambil semua record untuk kendaraan ini di bulan dan tahun yang dipilih
        $records = KendaraanModel::where('id_kendaraan', $id)
            ->whereMonth('tanggal', $date->month)
            ->whereYear('tanggal', $date->year)
            ->orderBy('tanggal')
            ->get();

        // Ambil data kendaraan pertama sebagai referensi
        $vehicle = $records->first();

        // Jika tidak ada data, redirect dengan pesan error
        if (!$vehicle) {
            return redirect()->back()->with('error', 'No vehicle data found.');
        }

        // Hitung jumlah hari dalam bulan
        $daysInMonth = $date->daysInMonth;

        // Mapping item kontrol
        $items = [
            'oli_mesin' => 'Oli Mesin',
            'oli_power_steering' => 'Oli Power Steering',
            'oli_rem' => 'Oli Rem',
            'body_kendaraan' => 'Body Kendaraan',
            'otomatis_starter' => 'Otomatis / Starter',
            'radiator' => 'Radiator',
            'baterai_aki' => 'Baterai / Aki',
            'wipers_depan' => 'Wipers Depan',
            'wipers_belakang' => 'Wipers Belakang',
            'ban_depan' => 'Ban Depan',
            'ban_belakang' => 'Ban Belakang',
            'lampu_depan' => 'Lampu Depan',
            'lampu_belakang' => 'Lampu Belakang',
            'lampu_rem' => 'Lampu Rem',
            'klakson' => 'Klakson',
            'kebersihan' => 'Kebersihan',
            'kunci_roda' => 'Kunci Roda',
            'dongkrak' => 'Dongkrak',
            'kotak_p3k' => 'Kotak P3K',
            'segitiga_pengaman' => 'Segitiga Pengaman'
        ];

        // Susun data tabel
        $tableData = [];
        foreach ($items as $key => $label) {
            $row = [
                'label' => $label,
                'days' => []
            ];

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $record = $records->firstWhere('tanggal', $date->copy()->day($d)->toDateString());
                $row['days'][$d] = $record ? ($record->$key ?? '') : '';
            }

            $tableData[] = $row;
        }

        // Tambahkan baris Status
        $statusRow = [
            'label' => 'Status',
            'days' => []
        ];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $record = $records->firstWhere('tanggal', $date->copy()->day($d)->toDateString());
            $statusRow['days'][$d] = $record ? ($record->status ?? '') : '';
        }
        $tableData[] = $statusRow;

        // Nama bulan dalam bahasa Indonesia
        $monthNames = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        $monthName = $monthNames[(int) $month - 1];

        return view('GA.print', compact(
            'vehicle',
            'tableData',
            'daysInMonth',
            'monthName',
            'year'
        ));
    }
}