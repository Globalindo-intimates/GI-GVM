    @extends('content.app')
    @section('content')
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="flex gap-2 mb-4">
                <button id="tab-pending"
                    class="px-6 py-2 border-collapse border bg-red-500 hover:bg-red-600 text-white rounded transition-colors">
                    Unverified
                </button>
                <button id="tab-verified"
                    class="px-6 py-2 border-collapse border bg-custom-500 hover:bg-custom-600 text-white rounded transition-colors">
                    Verified
                </button>
                </div>
            </div>
        </div>
            <!-- Tabel Belum Diverifikasi -->
            <div id="table-pending" class="card mt-3">
                <div class="card-body">
                    <h6 class="mb-4 text-15">Unverified Vehicle List</h6>
                    <table class="table-auto w-full border-collapse border border-custom-300 text-sm" id="table-pending-data">
                        <thead class="bg-custom-200">
                            <tr>
                                <th class="border px-2 py-1 text-center">Photo</th>
                                <th class="border px-2 py-1 text-center">Report By</th>
                                <th class="border px-2 py-1 text-center">License Plate Number</th>
                                <th class="border px-2 py-1 text-center">Vehicle Brand</th>
                                <th class="border px-2 py-1 text-center">Year of Vehicle</th>
                                <th class="border px-2 py-1 text-center">Type of Vehicle</th>
                                <th class="border px-2 py-1 text-center">Repair Date</th>
                                <th class="border px-2 py-1 text-center">Status & Inspector</th>
                                <th class="border px-2 py-1 text-center">Action</th>
                                <th class="border px-2 py-1 text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicles as $item)
                                @if(empty($item->status) || empty($item->pemeriksa))
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
                                        <td class="border px-3 py-2 text-center">
                                            <form action="{{ route('data.update', $item->id) }}" method="POST"
                                                class="flex flex-col items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <select name="status"
                                                    class="border rounded px-2 py-1 text-xs w-28 text-center focus:ring-2 focus:ring-green-400">
                                                    <option value="" disabled selected>Silahkan Pilih</option>
                                                    <option value="✔">✔</option>
                                                    <option value="✖">✖</option>
                                                </select>
                                                <input type="text" name="pemeriksa" id="pemeriksa"
                                                    class="form-input border rounded px-2 py-1 text-xs w-28 text-center dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                                    placeholder="Masukkan Nama Lengkap Anda" value="{{ session('user.nama') }}" readonly
                                                    required>
                                                <button type="submit"
                                                    class="w-28 px-3 py-1 text-xs bg-green-500 hover:bg-green-600 text-white rounded shadow transition">
                                                    Save Change
                                                </button>
                                            </form>
                                        </td>
                                        <td class="border px-2 py-1 text-center">
                                            <button
                                                class="inline-block text-center px-3 py-2 bg-custom-500 hover:bg-custom-600 text-white rounded transition-colors show-detail-btn"
                                                data-vehicles='@json($item)'
                                                data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}">
                                                View Detailed Data
                                            </button>
                                        </td>
                                        <td class="border px-2 py-1 text-center">
                                            <form action="{{ route('data.delete', $item->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="delete-btn w-full inline-block text-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Sudah Diverifikasi -->
            <div id="table-verified" class="card mt-3 hidden">
                <div class="card-body">
                    <h6 class="mb-4 text-15">Verified Vehicle List</h6>
                    <table class="table-auto w-full border-collapse border border-custom-300 text-sm" id="table-verified-data">
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
                                <th class="border px-2 py-1 text-center">Inspector</th>
                                <th class="border px-2 py-1 text-center">Action</th>
                                <th class="border px-2 py-1 text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicles as $item)
                                @if(!empty($item->status))
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
                                        <td class="border px-2 py-1">
                                            <span class="text-lg font-bold">{{ $item->status }}</span>
                                        </td>
                                        <td class="border px-2 py-1">{{ $item->pemeriksa }}</td>
                                        <td class="border px-2 py-1 text-center">
                                            <button
                                                class="inline-block text-center px-3 py-2 bg-custom-500 hover:bg-custom-600 text-white rounded transition-colors show-detail-btn"
                                                data-vehicles='@json($item)'
                                                data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}">
                                                View Detailed Data
                                            </button>
                                        </td>
                                        <td class="border px-2 py-1 text-center">
                                            <form action="{{ route('data.delete', $item->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="delete-btn w-full inline-block text-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Detail Modal -->
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

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Initialize DataTables
            $('#table-pending-data').DataTable({
                columnDefs: [
                    { orderable: false, targets: [0, 1, 2, 3, 5, 7, 8, 9] }
                ]
            });

            $('#table-verified-data').DataTable({
                columnDefs: [
                    { orderable: false, targets: [0, 1, 2, 3, 5, 7, 8, 9, 10] }
                ]
            });

            // Tab Switching
            const tabPending = document.getElementById('tab-pending');
            const tabVerified = document.getElementById('tab-verified');
            const tablePending = document.getElementById('table-pending');
            const tableVerified = document.getElementById('table-verified');

            tabPending.addEventListener('click', () => {
                tablePending.classList.remove('hidden');
                tableVerified.classList.add('hidden');

                tabPending.classList.add('bg-red-500', 'text-white');
                tabPending.classList.remove('bg-gray-300', 'text-gray-700');

                tabVerified.classList.add('bg-gray-300', 'text-gray-700');
                tabVerified.classList.remove('bg-custom-500', 'text-white');
            });

            tabVerified.addEventListener('click', () => {
                tableVerified.classList.remove('hidden');
                tablePending.classList.add('hidden');

                tabVerified.classList.add('bg-custom-500', 'text-white');
                tabVerified.classList.remove('bg-gray-300', 'text-gray-700');

                tabPending.classList.add('bg-gray-300', 'text-gray-700');
                tabPending.classList.remove('bg-red-500', 'text-white');
            });


            // Delete confirmation
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    let form = this.closest('form');

                    Swal.fire({
                        title: 'Are you sure you want to delete this data?',
                        text: "Deleted data cannot be restored.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Form submission with SweetAlert
            document.querySelectorAll('form').forEach(form => {
                if (form.querySelector('button[type="submit"]') && !form.classList.contains('delete-form')) {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        let currentForm = this;

                        Swal.fire({
                            title: 'Please wait...',
                            text: 'Data Update Process',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        fetch(currentForm.action, {
                            method: currentForm.method,
                            body: new FormData(currentForm),
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(res => {
                                if (!res.ok) throw new Error("An error occurred while updating the data.");
                                return res.json().catch(() => ({}));
                            })
                            .then(data => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Done!',
                                    text: 'Data verified successfully!',
                                    confirmButtonColor: '#3085d6'
                                }).then(() => {
                                    location.reload();
                                });
                            })
                            .catch(err => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: err.message || 'An error occurred while updating the data.'
                                });
                            });
                    });
                }
            });

            // Detail view
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
                            <div class="grid grid-cols-2 gap-4 mb-4 text-sm  rounded bg-gray-50 text-center">
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

                    html += `
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex items-center justify-left">
                                <label class="block font-semibold">Pemeriksa : ${vehicles.pemeriksa ?? '-'}</label>
                            </div>
                        `;

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