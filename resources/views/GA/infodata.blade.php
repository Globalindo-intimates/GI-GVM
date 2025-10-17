@extends('content.app')
@section('content')
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="mb-4 text-20">Vehicle Records</h5>
                <table class="table-auto w-full border-collapse border border-custom-300 text-sm" id="my-table">
                    <thead class="bg-custom-200">
                        <tr>
                            <th class="border px-2 py-1 text-center">License Plate Number</th>
                            <th class="border px-2 py-1 text-center">Vehicle Brand</th>
                            <th class="border px-2 py-1 text-center">Year of Vehicle</th>
                            <th class="border px-2 py-1 text-center">Type of Vehicle</th>
                            <th class="border px-2 py-1 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kendaraan as $item)
                            <tr
                                class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition-colors text-center">
                                <td class="border px-2 py-1">{{ $item->no_polisi }}</td>
                                <td class="border px-2 py-1">{{ $item->merk }}</td>
                                <td class="border px-2 py-1">{{ $item->tahun }}</td>
                                <td class="border px-2 py-1">{{ $item->jenis }}</td>
                                <td class="border px-2 py-1 text-center">
                                    <button
                                        class=" px-5 py-2 bg-custom-500 hover:bg-custom-600 text-white rounded show-detail-btn"
                                        data-id="{{ $item->id }}" data-tanggal="{{ $item->tanggal }}">
                                        View Detailed Data
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $kendaraan->links() }}
                </div>
            </div>
        </div>

        {{-- Detail Section (Muncul di Bawah) --}}
        <div id="vehicles-detail" class="mt-6 hidden p-4 rounded card">
            <div class="card-body">
                {{-- Filter Bulan & Tahun --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-2">
                    <div class="flex gap-2">
                        <select id="selectMonth" class="border px-3 py-2 rounded focus:ring-2 focus:ring-custom-500">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $m == date('m') ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                        <select id="selectYear" class="border px-3 py-2 rounded focus:ring-2 focus:ring-custom-500">
                            @foreach(range(date('Y') - 3, date('Y')) as $y)
                                <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Loading Indicator --}}
                <div id="loadingIndicator" class="hidden text-center py-4">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-custom-500"></div>
                    <p class="text-gray-600 mt-2">Loading data...</p>
                </div>

                {{-- Isi Detail --}}
                <div id="vehicles-content" class="prose"></div>

                {{-- Tombol Tutup --}}
                <div class="mt-3 flex gap-2">
                    <button id="close-detail"
                        class="px-4 py-2 bg-red-500 hover:bg-red-500 text-white rounded transition-colors">
                        Close
                    </button>
                    <button id="print" class="px-4 py-2 bg-custom-600 hover:bg-custom-700 text-white rounded transition-colors">
                        Print
                    </button>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $('#my-table').DataTable({
            columnDefs: [
                { orderable: false, targets: [0, 1, 3, 4] }
            ]
        });
        document.addEventListener('DOMContentLoaded', () => {
            const detailDiv = document.getElementById('vehicles-detail');
            const contentDiv = document.getElementById('vehicles-content');
            const loadingDiv = document.getElementById('loadingIndicator');
            const closeBtn = document.getElementById('close-detail');
            const printBtn = document.getElementById('print');
            const monthSelect = document.getElementById('selectMonth');
            const yearSelect = document.getElementById('selectYear');
            let currentId = null;
            let vehicleInfo = null;

            // Klik Lihat Data

            document.querySelectorAll('.show-detail-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    currentId = btn.dataset.id;
                    loadData(currentId);
                    detailDiv.classList.remove('hidden');
                    detailDiv.scrollIntoView({ behavior: 'smooth' });
                });
            });

            // Event ubah bulan & tahun
            monthSelect.addEventListener('change', () => {
                if (currentId) loadData(currentId);
            });
            yearSelect.addEventListener('change', () => {
                if (currentId) loadData(currentId);
            });

            // Tutup detail
            closeBtn.addEventListener('click', () => {
                detailDiv.classList.add('hidden');
                contentDiv.innerHTML = '';
                currentId = null;
                vehicleInfo = null;
            });

            printBtn.addEventListener('click', () => {
                if (!currentId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please select data first.',
                        text: 'Please select the vehicle you want to print.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                const month = monthSelect.value;
                const year = yearSelect.value;

                window.open(`{{ url('print') }}/${currentId}?month=${month}&year=${year}`, '_blank');
            });

            // Fungsi load data
            function loadData(id) {
                const month = monthSelect.value;
                const year = yearSelect.value;

                console.log('Memuat data - ID:', id, 'Bulan:', month, 'Tahun:', year);

                const tanggal = `${year}-${month.toString().padStart(2, '0')}-01`;

                loadingDiv.classList.remove('hidden');
                contentDiv.innerHTML = '';

                const url = `{{ url('ga/detail') }}/${id}?tanggal=${tanggal}`;

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Connection error. Please try again.');
                        }
                        return res.json();
                    })
                    .then(res => {
                        console.log('Data Response:', res);
                        loadingDiv.classList.add('hidden');

                        // Simpan info kendaraan jika ada
                        if (res.vehicle) {
                            vehicleInfo = res.vehicle;
                        }

                        // Jika tidak ada data, tetap lanjut tapi tampilkan tabel kosong
                        if (!res.vehicle || !res.tableData || res.tableData.length === 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to load data.',
                                text: 'No data available.',
                                confirmButtonColor: '#3085d6'
                            });
                        }

                        const daysInMonth = res.daysInMonth || new Date(year, month, 0).getDate();
                        const monthNames = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        const monthName = monthNames[parseInt(month) - 1];
                        let html = `
                    <!-- Header Form -->
                    <div class="grid grid-cols-3 gap-4 border border-black p-2 mb-2 text-xs">
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('public/assets/images/logo/logo-gi-transparant.png') }}" class="h-16">
                        </div>
                        <div class="flex items-center justify-center">
                            <h1 class="text-lg font-bold uppercase text-center">Form Perawatan Kendaraan</h1>
                        </div>
                        <div class="text-[10px] border border-black p-1">
                            <p class="block font-semibold">No. Dok. : FM-GA-023</p>
                            <p class="block font-semibold">Revisi : 01</p>
                            <p class="block font-semibold">Tgl. Efektif : 03-09-2024</p>
                            <p class="block font-semibold">Halaman : 1 dari 1</p>
                        </div>
                    </div>

                    <!-- Data Kendaraan -->
                    <div class="grid gap-4 mb-4 text-sm border p-3 rounded bg-gray-50">
                        <div><label class="block font-semibold">Jenis Kendaraan  : ${vehicleInfo?.jenis ?? '-'}</label></div>
                        <div><label class="block font-semibold">Nomor Polisi : ${vehicleInfo?.no_polisi ?? '-'}</label></div>
                    </div>
                    <div><label class="block font-semibold text-right">Bulan : ${monthName} ${year}</label></div>

                    <!-- Tabel Perawatan -->
                    <div class="overflow-x-auto">
                        <table class="border border-black text-xs w-full">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border border-black px-1">No</th>
                                    <th class="border border-black px-2">Item Kontrol</th>`;

                        for (let d = 1; d <= daysInMonth; d++) {
                            html += `<th class="border border-black px-1">${d}</th>`;
                        }

                        html += `</tr></thead><tbody>`;

                        if (res.tableData && res.tableData.length > 0) {
                            res.tableData.forEach((row, idx) => {
                                const rowClass = (row.label === 'Status') ? 'bg-custom-200 font-semibold' : '';
                                html += `<tr class="${rowClass}">
                            <td class="border border-black px-1">${idx + 1}</td>
                            <td class="border border-black px-2 text-left">${row.label ?? '-'}</td>`;
                                for (let d = 1; d <= daysInMonth; d++) {
                                    let val = (row.days && row.days[d]) ? row.days[d] : '';
                                    html += `<td class="border border-black text-center ${val === '✖' ? 'bg-red-500 text-white' : ''}">${val}</td>`;
                                }
                                html += `</tr>`;
                            });
                        }

                        html += `</tbody></table></div>`;
                        html += `         
                    <!-- Keterangan -->
                    <div class="mt-6 flex justify-between text-sm text-gray-700">
                        <div>
                            <p><strong>KETERANGAN :</strong></p>
                            <p>✔ : Baik, Berfungsi, Hidup/Nyala, Bersih</p>
                            <p>✖ : Tidak Baik, Rusak, Tidak Berfungsi, Tidak Nyala, Kotor</p>
                        </div>

                        <!-- Kolom Status (kanan) -->
                        <div class="justify-right">
                            <p><strong>STATUS :</strong></p>
                            <p>✔ : Disetujui / Diverifikasi</p>
                            <p>✖ : Ditolak</p>
                        </div>
                    </div>
                    
                `;
                        contentDiv.innerHTML = html;
                    })
                    .catch(err => {
                        console.error('Error fetch:', err);
                        loadingDiv.classList.add('hidden');
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to load data.',
                            text: 'An error occurred while retrieving the data! Please try again.',
                            confirmButtonColor: '#3085d6'
                        });
                    });
            }
        });
    </script>

@endsection