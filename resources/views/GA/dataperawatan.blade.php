@extends('content.app')
@section('content')
<div class="card mt-3">
    <div class="card-body container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
                <button id="tab-pending"
                    class="px-6 py-2 border-collapse border bg-red-500 hover:bg-red-600 text-white rounded transition-colors">
                    Unverified
                </button>
                <button id="tab-verified"
                    class="px-6 py-2 border-collapse border bg-custom-500 hover:bg-custom-600 text-white rounded transition-colors">
                    Verified
                </button>
    <!-- Tabel Belum Diverifikasi -->
    <div id="table-pending">
        <div class="card-body">
            <h5 class="mb-4 text-20">Unverified Vehicle List</h5>
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
                        <th class="border px-2 py-1 text-center">Status</th>
                        <th class="border px-2 py-1 text-center">Action</th>
                        <th class="border px-2 py-1 text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $item)
                        @if(empty($item->status) || empty($item->pemeriksa))
                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition-colors text-center">
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
                                <td class="border px-2 py-1 text-center">
                                    <button type="button"
                                        class="verify-btn px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded transition-colors"
                                        data-id="{{ $item->id }}">
                                        Verify
                                    </button>
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
                                    <form action="{{ url('/') }}/{{ $item->id }}/delete" method="POST" class="delete-form">
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
    <div id="table-verified" class=" hidden">
        <div class="card-body">
            <h5 class="mb-4 text-20">Verified Vehicle List</h5>
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
                        <th class="border px-2 py-1 text-center">Reject Reason</th>
                        <th class="border px-2 py-1 text-center">Action</th>
                        <th class="border px-2 py-1 text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $item)
                        @if(!empty($item->status))
                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition-colors text-center">
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
                                    <span class="text-lg font-bold {{ $item->status === '✔' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="border px-2 py-1">{{ $item->pemeriksa }}</td>
                                <td class="border px-2 py-1">
                                    {{ $item->status === '✖' && $item->reject_reason ? $item->reject_reason : '-' }}
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
                                    <form action="{{ url('/') }}/{{ $item->id }}/delete" method="POST" class="delete-form">
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
    </div>
    </div>

    <!-- Modal Verifikasi -->
    <div id="verification-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md mx-4">
            <h3 class="text-lg font-semibold mb-4">Maintenance Data Verification</h3>
            <form id="verification-form">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Verification Status</label>
                    <select name="status" id="status-select" 
                        class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400" required>
                        <option value="" disabled selected>Select Status</option>
                        <option value="✔">✔</option>
                        <option value="✖">✖</option>
                    </select>
                </div>

                <div id="reject-reason-field" class="mb-4 hidden">
                    <label class="block text-sm font-medium mb-2">Rejection Reason</label>
                    <textarea name="reject_reason" id="reject-reason" rows="4"
                        class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400"
                        placeholder="Please enter the reason for rejection..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Inspector Name</label>
                    <input type="text" name="pemeriksa" id="pemeriksa-input"
                        class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-400"
                        value="{{ session('user.nama') ?? auth()->user()->nama ?? '' }}" readonly required>
                </div>

                <div class="flex gap-2 justify-end">
                    <button type="button" id="cancel-verification"
                        class="px-4 py-2 bg-red-500 hover:bg-red-500 text-white rounded transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-custom-500 hover:bg-custom-600 text-white rounded transition-colors">
                        Save
                    </button>
                </div>
            </form>
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
                    class="px-4 py-2 bg-red-500 text-white rounded transition-colors">Close</button>
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
                { orderable: false, targets: [0, 1, 2, 3, 5, 7, 8, 9, 10, 11] }
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

        // Verification Modal
        const verificationModal = document.getElementById('verification-modal');
        const verificationForm = document.getElementById('verification-form');
        const statusSelect = document.getElementById('status-select');
        const rejectReasonField = document.getElementById('reject-reason-field');
        const rejectReasonTextarea = document.getElementById('reject-reason');
        const cancelVerification = document.getElementById('cancel-verification');

        // Show modal when verify button clicked
        document.querySelectorAll('.verify-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                let vehicleId = this.dataset.id;
                verificationForm.action = `{{ url( '${vehicleId}/status') }}`;
                verificationModal.classList.remove('hidden');
            });
        });

        // Toggle reject reason field
        statusSelect.addEventListener('change', function() {
            if (this.value === '✖') {
                rejectReasonField.classList.remove('hidden');
                rejectReasonTextarea.required = true;
            } else {
                rejectReasonField.classList.add('hidden');
                rejectReasonTextarea.required = false;
                rejectReasonTextarea.value = '';
            }
        });

        // Cancel verification
        cancelVerification.addEventListener('click', () => {
            verificationModal.classList.add('hidden');
            verificationForm.reset();
            rejectReasonField.classList.add('hidden');
        });

        // Close modal when clicking outside
        verificationModal.addEventListener('click', (e) => {
            if (e.target === verificationModal) {
                verificationModal.classList.add('hidden');
                verificationForm.reset();
                rejectReasonField.classList.add('hidden');
            }
        });

        // Handle form submission
        verificationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validasi manual sebelum submit
            const statusValue = statusSelect.value;
            const rejectReasonValue = rejectReasonTextarea.value.trim();

            if (!statusValue) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Status is required!',
                    text: 'You need to select a status first!'
                });
                return;
            }

            if (statusValue === '✖' && !rejectReasonValue) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please provide a reason!',
                    text: 'Rejection reason must be provided for rejected status!'
                });
                return;
            }

            Swal.fire({
                title: 'Please wait...',
                text: 'Processing verification...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(this);
            
            // Debug: Log data yang akan dikirim
            console.log('Form Data:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) {
                    console.error('Server Response:', data);
                    throw new Error(data.message || "An error occurred while updating the data.");
                }
                return data;
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data verified successfully!',
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    location.reload();
                });
            })
            .catch(err => {
                console.error('Error:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Failed!',
                    text: err.message || 'An error occurred while updating the data.',
                    footer: 'Silakan cek console browser untuk detail error'
                });
            });
        });

        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
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

        // Detail view
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

        document.addEventListener('click', (e) => {
            if (e.target.closest('.show-detail-btn')) {
                const btn = e.target.closest('.show-detail-btn');
                const vehicles = JSON.parse(btn.dataset.vehicles || '{}');
                const tanggalFormatted = btn.dataset.tanggal || vehicles.tanggal || '';
                const assetUrl = '{{ asset("storage/app/public/damages/") }}';
                
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
                    const imgUrl = imagePath ? `${assetUrl}/${imagePath}` : '';
                    html += `
                        <tr>
                            <td class="border border-gray-400 px-2 py-1 text-center">${idx + 1}</td>
                            <td class="border border-gray-400 px-2 py-1 text-left">${displayName}</td>
                            <td class="border border-gray-400 px-2 py-1">${status}</td>
                            <td class="border border-gray-400 px-2 py-1 text-center">
                                ${status === '✖' && reason ? `<span>${reason}</span>` : '-'}
                            </td>
                            <td class="border border-gray-400 px-2 py-1">
                                ${status === '✖' && imagePath ? `<img src="${imgUrl}" class="w-32 h-24 object-cover rounded border mx-auto">` : '-'}
                            </td>
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