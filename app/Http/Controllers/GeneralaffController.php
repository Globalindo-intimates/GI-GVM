<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KendaraanModel;
use App\Models\MasterdataModel;
use Illuminate\View\View;
//import return type redirectResponse
use Illuminate\Http\RedirectResponse;


class GeneralaffController extends Controller
{
    public function index()
    {
        $vehicles = KendaraanModel::latest()->paginate(10);
        return view('content.dataperawatan', compact('vehicles'));
    }
    public function update(Request $request, $id)
    {
        $vehicle = KendaraanModel::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'pemeriksa' => 'required',
        ]);

        $vehicle->update($request->all());


        return redirect()->route('content.dataperawatan')->with('success', 'Data updated successfully!');
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