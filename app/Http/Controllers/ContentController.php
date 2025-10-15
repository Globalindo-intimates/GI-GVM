<?php

namespace App\Http\Controllers;

use App\Models\KendaraanModel;
use App\Models\MasterdataModel;

use App\Models\PenggunaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function dashboard()
    {
        $data = [
            'title' => 'Data Perawatan Kendaraan | GI-GVM',
            'menu' => 'Content',
            'sub_menu' => 'Dashboard',
            'vehicles' => KendaraanModel::where('user_id', session('user.id'))->paginate(10)
        ];

        return view('content.dashboard', $data);
        // $vehicles = KendaraanModel::where('user_id', session('user.id'))
        //     ->latest()
        //     ->get();
        // $totalData = $vehicles->count();
        // $totalVerified = $vehicles->where('✔')->count();
        // $totalUnverified = $vehicles->whereNull('status')->count();
        // $totalRejected = $vehicles->where('✖')->count();
        // $uniquePlates = $vehicles->groupBy('no_polisi')->count();
        // $data = array_merge($data, [
        //     'vehicles' => $vehicles,
        //     'totalKendaraan' => $totalData,
        //     'verified' => $totalVerified,
        //     'unverified' => $totalUnverified,
        //     'rejected' => $totalRejected,
        //     'uniquePlates' => $uniquePlates,
        // ]);
        // return view('content.dashboard', $data);
    }

    public function dashboardGA()
    {
        $totalPerawatan = KendaraanModel::whereMonth('tanggal', date('m'))
            ->count();
        $verified = KendaraanModel::whereNotNull('status')
            ->whereMonth('tanggal', date('m'))
            ->count();
        $unverified = KendaraanModel::whereNull('status')
            ->whereMonth('tanggal', date('m'))
            ->count();
        $bulanLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataPerawatan = [];
        foreach (range(1, 12) as $bulan) {
            $dataPerawatan[] = KendaraanModel::whereMonth('tanggal', $bulan)->count();
        }
        $latestVehicles = KendaraanModel::orderBy('updated_at', 'desc')->take(5)->get();
        $tahun = KendaraanModel::selectRaw('YEAR(MAX(tanggal)) as tahun')->value('tahun') ?? date('Y');

        $data = [
            'title' => 'Data Perawatan Kendaraan | GI-GVM',
            'menu' => 'Content',
            'sub_menu' => 'Dashboard',
            'kendaraan' => MasterdataModel::latest()->paginate(10),
            'vehicles' => KendaraanModel::latest()->paginate(10),
            'dataPerawatan' => $dataPerawatan,
            'bulanLabel' => $bulanLabel,
            'totalPerawatan' => $totalPerawatan,
            'verified' => $verified,
            'unverified' => $unverified,
            'latestVehicles' => $latestVehicles,
            'tahun' => $tahun, // Tambahkan tahun di sini
        ];

        // $totalKendaraan = MasterdataModel::count();
        // $totalPerawatan = KendaraanModel::whereMonth('tanggal', date('m'))->count();
        // $verified = KendaraanModel::whereNotNull('status')->whereNotNull('pemeriksa')->whereMonth('tanggal', date('m'))->count();
        // $unverified = KendaraanModel::whereNull('status')->orWhereNull('pemeriksa')->whereMonth('tanggal', date('m'))->count();
        // $bulanLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];


        // }

        // $latestVehicles = KendaraanModel::orderBy('updated_at', 'desc')->take(5)->get();

        // $data = [
        //     'title' => 'Dashboard General Affair | GI-GVM',
        //     'menu' => 'Content',
        //     'sub_menu' => 'Dashboard',
        //     'totalKendaraan' => $totalKendaraan,
        //     'totalPerawatan' => $totalPerawatan,
        //     'verified' => $verified,
        //     'unverified' => $unverified,
        //     'bulanLabel' => $bulanLabel,
        //     'dataPerawatan' => $dataPerawatan,
        //     'latestVehicles' => $latestVehicles,
        // ];

        return view('GA.dashboardGA', $data);
    }

    public function dashboardAdmin()
    {
        $totalPerawatan = KendaraanModel::whereMonth('tanggal', date('m'))
            ->count();
        $verified = KendaraanModel::whereNotNull('status')
            ->whereMonth('tanggal', date('m'))
            ->count();
        $unverified = KendaraanModel::whereNull('status')
            ->whereMonth('tanggal', date('m'))
            ->count();
        $bulanLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataPerawatan = [];
        foreach (range(1, 12) as $bulan) {
            $dataPerawatan[] = KendaraanModel::whereMonth('tanggal', $bulan)->count();
        }
        $latestVehicles = KendaraanModel::orderBy('updated_at', 'desc')->take(5)->get();
        $tahun = KendaraanModel::selectRaw('YEAR(MAX(tanggal)) as tahun')->value('tahun') ?? date('Y');

        $data = [
            'title' => 'Admin Dashboard | GI-GVM',
            'menu' => 'Content',
            'sub_menu' => 'Dashboard',
            'kendaraan' => MasterdataModel::latest()->paginate(10),
            'vehicles' => KendaraanModel::latest()->paginate(10),
            'dataPerawatan' => $dataPerawatan,
            'bulanLabel' => $bulanLabel,
            'totalPerawatan' => $totalPerawatan,
            'verified' => $verified,
            'unverified' => $unverified,
            'latestVehicles' => $latestVehicles,
            'tahun' => $tahun, // Tambahkan tahun di sini
        ];
        return view('admin.dashboardAdmin', $data);
    }
    public function dashboardkendaraan()
    {
        $data = [
            'title' => 'Input Data | GI-GVM',
            'menu' => 'Content',
            'sub_menu' => 'Dashboard'
        ];
        return view('content.kendaraan', $data);
    }

    public function dashboarddata($id)
    {
        $vehicles = KendaraanModel::where('user_id', $id)->paginate(10);

        $data = [
            'title' => 'Cek Input Data | GI-GVM',
            'menu' => 'Content',
            'sub_menu' => 'Dashboard',
            'vehicles' => $vehicles
        ];

        return view('content.lihatdata', $data);
    }

    public function dataperawatan(): View
    {
        $data = [
            'title' => 'Data Perawatan Kendaraan | GI-GVM',
            'menu' => 'Content',
            'sub_menu' => 'Dashboard',
            'vehicles' => KendaraanModel::latest()->get()
        ];

        // Pastikan hanya 1 return
        return view('GA.dataperawatan', $data);

    }
    public function infodata(): View
    {
        $data = [
            'title' => 'Data Perawatan Kendaraan | GI-GVM',
            'menu' => 'Content',
            'sub_menu' => 'Dashboard',
            'kendaraan' => MasterdataModel::latest()->paginate(10),
            'vehicles' => KendaraanModel::latest()->paginate(10)
        ];
        return view('GA.infodata', $data);

    }
    public function master(): View
    {
        $data = [
            'title' => 'Master Data | GI-GVM',
            'menu' => 'Content',
            'sub_menu' => 'Dashboard',
            'kendaraan' => MasterdataModel::latest()->paginate(10)
        ];
        return view('admin.masterdata', $data);
    }

    public function getData()
    {
        $data = DB::connection(name: 'mysql')->select("SELECT*FROM masterdata_models");
        return response()->json(['data' => $data]);
    }
    public function getMasterdata(Request $request)
    {
        // $data = MasterdataModel::where('no_polisi', $request->id)->get();
        $id = $request->input('id');
        $data = DB::connection('mysql')->select("SELECT * FROM masterdata_models WHERE id = '$id'");
        return response()->json(['data' => $data]);
    }
    public function user(): View
    {
        $data = [
            'title' => 'User Data | GI-GVM',
            'menu' => 'Content',
            'sub_menu' => 'Dashboard',
            'users' => PenggunaModel::latest()->paginate(10)
        ];
        return view('admin.user', $data);
    }
}


