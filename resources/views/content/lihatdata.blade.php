@extends('content.app')
@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <h6 class="mb-4 text-15">Vehicle Data You’ve Submitted</h6>
            <table class="table-auto w-full border-collapse border border-custom-300 text-sm" id="my-table">
                <thead class="bg-custom-200">
                    <tr>
                        <th class="border px-2 py-1 text-center">Photo</th>
                        <th class="border px-2 py-1 text-center">Report By</th>
                        <th class="border px-2 py-1 text-center">License Plate Number</th>
                        <th class="border px-2 py-1 text-center">Vehicle Brand</th>
                        <th class="border px-2 py-1 text-center">Year of Vehicle</th>
                        <th class="border px-2 py-1 text-center">Type of Vehicle</th>
                        <th class="border px-2 py-1 text-center">Repair Date</th>
                        <th class="border px-2 py-1 text-center">Status</th>
                        <th class="border px-2 py-1 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $item)
                        <tr
                            class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition-colors text-center">
                            <td class="border px-2 py-1 text-center">
                                @if($item->image)
                                    <img src="{{ asset('storage/app/public/vehicle/' . $item->image) }}"
                                        class="w-16 h-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400 italic">No Image</span>
                                @endif
                            </td>
                            <td class="border px-2 py-1">{{ $item->nama_pelapor }}</td>
                            <td class="border px-2 py-1">{{ $item->no_polisi }}</td>
                            <td class="border px-2 py-1">{{ $item->merk }}</td>
                            <td class="border px-2 py-1">{{ $item->tahun }}</td>
                            <td class="border px-2 py-1">{{ $item->jenis }}</td>
                            <td class="border px-2 py-1">{{ $item->tanggal }}</td>
                            <td class="border px-2 py-1">{{ $item->status }}</td>
                            <td class="border px-2 py-1 text-center">
                                <button
                                    class="inline-block text-center px-2 py-2 bg-custom-500 hover:bg-custom-600 text-white rounded transition-colors show-detail-btn"
                                    data-vehicles='@json($item)'
                                    data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}">
                                    View Detailed Data
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>

    {{-- keterangan --}}
    <div id="vehicles-detail" class="mt-6 hidden p-4 rounded card">
        <div class="card-body">
            <div id="vehicles-content" class="prose"></div>
            <div class="mt-4 text-sm text-gray-700">
                <p>✔ : Baik, Berfungsi, Hidup/Nyala, Bersih</p>
                <p>✖ : Tidak Baik, Rusak, Tidak Berfungsi, Tidak Nyala, Kotor</p>
            </div>
            <div class="mt-3 flex gap-2">
                <button id="close-detail"
                    class="px-4 py-2 bg-custom-600 text-white rounded transition-colors">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        $('#my-table').DataTable({
            columnDefs: [
                { orderable: false, targets: [0, 1, 2, 3, 5, 7, 8] }
            ]
        });
        // --- DETAIL DATA ---
        const detailDiv = document.getElementById('vehicles-detail');
        const contentDiv = document.getElementById('vehicles-content');
        const closeBtn = document.getElementById('close-detail');

        const keyMapping = {
            'Oli Mesin': 'oli_mesin',
            'Oli Power Steering': 'oli_power_steering',
            'Oli Rem': 'oli_rem',
            'Body Kendaraan': 'body_kendaraan',
            'Otomatis / Starter': 'otomatis_starter',
            'Radiator': 'radiator',
            'Baterai / Aki': 'baterai_aki',
            'Wipers Depan': 'wipers_depan',
            'Wipers Belakang': 'wipers_belakang',
            'Ban Depan': 'ban_depan',
            'Ban Belakang': 'ban_belakang',
            'Lampu Depan': 'lampu_depan',
            'Lampu Belakang': 'lampu_belakang',
            'Lampu Rem': 'lampu_rem',
            'Klakson': 'klakson',
            'Kebersihan': 'kebersihan',
            'Kunci Roda': 'kunci_roda',
            'Dongkrak': 'dongkrak',
            'Kotak P3K': 'kotak_p3k',
            'Segitiga Pengaman': 'segitiga_pengaman'
        };

        const itemsDisplay = Object.keys(keyMapping);

        document.addEventListener('click', (e) => {
            if (e.target.closest('.show-detail-btn')) {
                const btn = e.target.closest('.show-detail-btn');
                const vehicles = JSON.parse(btn.dataset.vehicles || '{}');
                const tanggalFormatted = btn.dataset.tanggal || vehicles.tanggal || '';

                let html = `
                            <div class="grid grid-cols-2 gap-4 mb-4 text-sm rounded bg-gray-50 text-center">
                                <div class="flex items-center justify-center">
                                    <label class="block font-semibold">Form ID : ${vehicles.id ?? '-'}</label>
                                </div>
                                <div class="flex items-center justify-center">
                                    <label class="block font-semibold">Tanggal Perbaikan : ${tanggalFormatted}</label>
                                </div>
                                <div class="flex items-center justify-center">
                                    <label class="block font-semibold">Jenis Kendaraan : ${vehicles.jenis ?? '-'}</label>
                                </div>
                                <div class="flex items-center justify-center">
                                    <label class="block font-semibold">Nomor Polisi : ${vehicles.no_polisi ?? '-'}</label>
                                </div>
                                <div class="flex items-center justify-center">
                                    <label class="block font-semibold">Nama Pelapor : ${vehicles.nama_pelapor ?? '-'}</label>
                                </div>
                                <div class="flex items-center justify-center">
                                    <label class="block font-semibold">Status : ${vehicles.status ?? '-'}</label>
                                </div>

                            </div>
                            <div class="overflow-x-auto mb-6">
                                <table class="table-auto border-collapse border border-gray-400 text-xs w-full text-center">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border border-gray-400 px-2 py-1">No</th>
                                            <th class="border border-gray-400 px-2 py-1">Item Kontrol</th>
                                            <th class="border border-gray-400 px-2 py-1">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;

                itemsDisplay.forEach((displayName, idx) => {
                    const key = keyMapping[displayName];
                    let value = (vehicles[key] !== undefined && vehicles[key] !== null && vehicles[key] !== '') ? vehicles[key] : '-';
                    html += `
                                <tr>
                                    <td class="border border-gray-400 px-2 py-1 text-center">${idx + 1}</td>
                                    <td class="border border-gray-400 px-2 py-1 text-left">${displayName}</td>
                                    <td class="border border-gray-400 px-2 py-1">${value}</td>
                                </tr>
                            `;
                });

                html += `</tbody></table></div>
                                <div class="flex items-center justify-left">
                                    <label class="block font-semibold">Pemeriksa : ${vehicles.pemeriksa ?? '-'}</label>
                                </div>`;

                contentDiv.innerHTML = html;
                detailDiv.classList.remove('hidden');
                detailDiv.scrollIntoView({ behavior: 'smooth' });

            }
        });

        closeBtn.addEventListener('click', () => {
            detailDiv.classList.add('hidden');
            contentDiv.innerHTML = '';
        });
    </script>

@endsection