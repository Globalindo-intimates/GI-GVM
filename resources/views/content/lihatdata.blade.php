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
                        <th class="border px-2 py-1 text-center">Reason</th>
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
                            <td class="border px-2 py-1">{{ $item->reject_reason }}</td>
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
                    class="px-4 py-2 bg-red-500 text-white rounded transition-colors">Tutup</button>
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
            'Oli Mesin': { key: 'oli_mesin', reason: 'oli_mesin_reason', image: 'oli_mesin_image' },
            'Oli Power Steering': { key: 'oli_power_steering', reason: 'oli_power_steering_reason', image: 'oli_power_steering_image' },
            'Oli Rem': { key: 'oli_rem', reason: 'oli_rem_reason', image: 'oli_rem_image' },
            'Body Kendaraan': { key: 'body_kendaraan', reason: 'body_kendaraan_reason', image: 'body_kendaraan_image' },
            'Otomatis / Starter': { key: 'otomatis_starter', reason: 'otomatis_starter_reason', image: 'otomatis_starter_image' },
            'Radiator': { key: 'radiator', reason: 'radiator_reason', image: 'radiator_image' },
            'Baterai / Aki': { key: 'baterai_aki', reason: 'baterai_aki_reason', image: 'baterai_aki_image' },
            'Wipers Depan': { key: 'wipers_depan', reason: 'wipers_depan_reason', image: 'wipers_depan_image' },
            'Wipers Belakang': { key: 'wipers_belakang', reason: 'wipers_belakang_reason', image: 'wipers_belakang_image' },
            'Ban Depan': { key: 'ban_depan', reason: 'ban_depan_reason', image: 'ban_depan_image' },
            'Ban Belakang': { key: 'ban_belakang', reason: 'ban_belakang_reason', image: 'ban_belakang_image' },
            'Lampu Depan': { key: 'lampu_depan', reason: 'lampu_depan_reason', image: 'lampu_depan_image' },
            'Lampu Belakang': { key: 'lampu_belakang', reason: 'lampu_belakang_reason', image: 'lampu_belakang_image' },
            'Lampu Rem': { key: 'lampu_rem', reason: 'lampu_rem_reason', image: 'lampu_rem_image' },
            'Klakson': { key: 'klakson', reason: 'klakson_reason', image: 'klakson_image' },
            'Kebersihan': { key: 'kebersihan', reason: 'kebersihan_reason', image: 'kebersihan_image' },
            'Kunci Roda': { key: 'kunci_roda', reason: 'kunci_roda_reason', image: 'kunci_roda_image' },
            'Dongkrak': { key: 'dongkrak', reason: 'dongkrak_reason', image: 'dongkrak_image' },
            'Kotak P3K': { key: 'kotak_p3k', reason: 'kotak_p3k_reason', image: 'kotak_p3k_image' },
            'Segitiga Pengaman': { key: 'segitiga_pengaman', reason: 'segitiga_pengaman_reason', image: 'segitiga_pengaman_image' }
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
                    <div class="overflow-x-auto mb-6" >
                        <table class="table-auto border-collapse border border-gray-400 text-xs w-full text-center">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-400 px-2 py-1">No</th>
                                    <th class="border border-gray-400 px-2 py-1">Item Kontrol</th>
                                    <th class="border border-gray-400 px-2 py-1">Status</th>
                                    <th class="border border-gray-400 px-2 py-1">Reason</th>
                                    <th class="border border-gray-400 px-2 py-1">Foto Kerusakan</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                Object.entries(keyMapping).forEach(([displayName, map], idx) => {
                    const status = vehicles[map.key] ?? '-';
                    const reason = vehicles[map.reason] ?? '';
                    const imagePath = vehicles[map.image] ?? '';
                    const imgUrl = imagePath? `{{ asset('storage/app/public/damages/') }}/${imagePath}`: '';
                    html += `
                        <tr>
                            <td class="border border-gray-400 px-2 py-1 text-center">${idx + 1}</td>
                            <td class="border border-gray-400 px-2 py-1 text-left">${displayName}</td>
                            <td class="border border-gray-400 px-2 py-1">${status}</td>
                            <td class="border border-gray-400 px-2 py-1 text-center">
                                ${status === '✖' && reason ? `<span class="">${reason}</span>` : '-'}
                            </td>
                            <td class="border border-gray-400 px-2 py-1">
                                ${status === '✖' && imagePath? `<img src="${imgUrl}" class="w-32 h-24 object-cover rounded border mx-auto">`: '-'}
                            </td>
                        </tr>
                    `;
                });
                                html += `</tbody></table></div >
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