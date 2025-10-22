@extends('content.app')
@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <h6 class="mb-4 text-15">Vehicle Data You've Submitted</h6>
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
                            <td class="border px-2 py-1">{{ $item->status }}</td>
                            <td class="border px-2 py-1">{{ $item->reject_reason }}</td>
                            <td class="border px-2 py-1 text-center">
                                <div class="flex gap-2 justify-center">
                                    <button
                                        class="inline-block text-center px-2 py-2 bg-custom-500 hover:bg-custom-600 text-white rounded transition-colors show-detail-btn"
                                        data-vehicles='@json($item)'
                                        data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}">
                                        View Detailed Data
                                    </button>
                                    
                                    @if($item->status === '✖')
                                        <button
                                            class="inline-block text-center px-2 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded transition-colors edit-btn"
                                            data-vehicles='@json($item)'
                                            data-id="{{ $item->id }}">
                                            Edit
                                        </button>
                                    @endif
                                </div>
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

    {{-- Detail View --}}
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

    {{-- Edit Form Modal --}}
    <div id="edit-modal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50 p-2">
        <div class="bg-white rounded-lg shadow-lg max-w-2xl p-4 relative max-h-[95vh] overflow-y-auto">
            <h6 class="mb-3 text-sm font-semibold">Edit Vehicle Data</h6>
            
            <form id="edit-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <input type="hidden" id="edit-id" name="id">
                
                {{-- Basic Information --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-1 mb-2">
                    <div>
                        <label class="inline-block mb-1 text-xs font-medium">
                            Repair Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" id="edit-tanggal" 
                            class="form-input border border-slate-200 w-full text-sm py-1" required>
                    </div>

                    <div>
                        <label class="inline-block mb-1 text-xs font-medium">Vehicle Photo</label>
                        <div class="flex items-center gap-1">
                            <img id="current-image" src="" class="w-20 h-16 object-cover rounded border">
                            <div class="flex-1">
                                <input type="file" name="image" id="edit-image" 
                                    class="form-input border border-slate-200 w-full text-xs py-1" 
                                    accept="image/jpeg,image/png,image/jpg">
                                <small class="text-gray-500 text-xs">Optional</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Inspection Items --}}
                <div class="mb-3">
                    <h6 class="mb-2 text-xs font-semibold">Inspection Items</h6>
                    <div id="inspection-items" class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- Items will be populated by JavaScript --}}
                    </div>
                </div>  

                <div class="mt-3 flex gap-2">
                    <button type="submit" 
                        class="px-3 py-1 text-xs bg-custom-500 hover:bg-custom-600 text-white rounded shadow transition">
                        Update Data
                    </button>
                    <button type="button" id="close-edit-modal" 
                        class="px-3 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded shadow transition">
                        Cancel
                    </button>
                </div>
            </form>
            
            <button id="btn-close-edit" 
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg">&times;</button>
        </div>
    </div>

    {{-- Modal for Edit Damage Image Upload --}}
    <div id="editDamageImageModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center" style="z-index: 60;">
        <div class="bg-white rounded-lg shadow-lg max-w-md p-6 relative">
            <h6 class="mb-4 text-15 font-semibold" id="editModalTitle">Upload Damage Image</h6>

            <div class="mb-4">
                <label class="inline-block mb-2 text-base font-medium">
                    Damage Reason <span class="text-red-500">*</span>
                </label>
                <textarea id="editModalReasonInput" rows="3"
                    placeholder="Describe the damage (e.g., Cracked, Not working, Worn out, etc.)"
                    class="form-input border border-slate-200 w-full resize-none"></textarea>
            </div>

            <div class="mb-4">
                <label class="inline-block mb-2 text-base font-medium">
                    Damage Photo
                </label>
                <input type="file" id="editModalImageInput" accept="image/*" class="form-input border border-slate-200">
                <p class="mt-2 text-xs text-gray-500">Accepted formats: JPG, PNG, JPEG (Max: 2MB)</p>
                <div id="editCurrentImagePreview" class="mt-2 hidden">
                    <p class="text-xs text-gray-600 mb-1">Current Image:</p>
                    <img id="editCurrentImageDisplay" src="" class="w-32 h-24 object-cover rounded border">
                </div>
            </div>

            <div class="mt-4 flex gap-2">
                <button type="button" id="editModalSave"
                    class="px-3 py-1 text-md bg-custom-500 hover:bg-custom-600 text-white rounded shadow transition">
                    Upload
                </button>
                <button type="button" id="editModalCancel"
                    class="px-3 py-1 text-md bg-red-500 hover:bg-red-600 text-white rounded shadow transition">
                    Cancel
                </button>
            </div>

            <button id="editModalClose"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        // Show detail
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
                    const imgUrl = imagePath ? `{{ asset('storage/app/public/damages/') }}/${imagePath}` : '';
                    html += `
                        <tr>
                            <td class="border border-gray-400 px-2 py-1 text-center">${idx + 1}</td>
                            <td class="border border-gray-400 px-2 py-1 text-left">${displayName}</td>
                            <td class="border border-gray-400 px-2 py-1">${status}</td>
                            <td class="border border-gray-400 px-2 py-1 text-center">
                                ${status === '✖' && reason ? `<span class="">${reason}</span>` : '-'}
                            </td>
                            <td class="border border-gray-400 px-2 py-1">
                                ${status === '✖' && imagePath ? `<img src="${imgUrl}" class="w-32 h-24 object-cover rounded border mx-auto">` : '-'}
                            </td>
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

        // --- EDIT FUNCTIONALITY ---
        const editModal = document.getElementById('edit-modal');
        const editForm = document.getElementById('edit-form');
        const closeEditModal = document.getElementById('close-edit-modal');
        const btnCloseEdit = document.getElementById('btn-close-edit');
        const inspectionItems = document.getElementById('inspection-items');
        
        // Damage modal elements
        const editDamageModal = document.getElementById('editDamageImageModal');
        const editModalSave = document.getElementById('editModalSave');
        const editModalCancel = document.getElementById('editModalCancel');
        const editModalClose = document.getElementById('editModalClose');
        let editCurrentField = null;
        let editCurrentSelect = null;
        let editCurrentReasonField = null;
        let editCurrentImageField = null;

        document.addEventListener('click', (e) => {
            if (e.target.closest('.edit-btn')) {
                const btn = e.target.closest('.edit-btn');
                const vehicles = JSON.parse(btn.dataset.vehicles || '{}');
                const vehicleId = btn.dataset.id;
                
                // Set form action
                editForm.action = `/kendaraan/update/${vehicleId}`;
                
                // Fill basic data
                document.getElementById('edit-id').value = vehicleId;
                document.getElementById('edit-tanggal').value = vehicles.tanggal;
                document.getElementById('current-image').src = `{{ asset('storage/app/public/vehicle/') }}/${vehicles.image}`;
                
                // Generate inspection items
                let itemsHtml = '';
                Object.entries(keyMapping).forEach(([displayName, map]) => {
                    const status = vehicles[map.key] || '✔';
                    const reason = vehicles[map.reason] || '';
                    const imagePath = vehicles[map.image] || '';
                    
                    itemsHtml += `
                        <div class="border border-slate-200 rounded p-2 bg-white">
                            <label class="inline-block mb-1 text-xs font-medium">${displayName}</label>
                            
                            <div class="mb-1">
                                <select name="${map.key}" class="form-select border border-slate-200 w-full text-xs py-1 status-select-edit" 
                                    data-field="${map.key}" 
                                    data-reason-field="${map.reason}" 
                                    data-image-field="${map.image}" 
                                    data-item="${displayName}" 
                                    data-current-reason="${reason}" 
                                    data-current-image="${imagePath}">
                                    <option value="">-</option>
                                    <option value="✔" ${status === '✔' ? 'selected' : ''}>✔ Good</option>
                                    <option value="✖" ${status === '✖' ? 'selected' : ''}>✖ Damaged</option>
                                </select>
                            </div>
                            
                            <!-- Hidden inputs for reason and image -->
                            <input type="hidden" name="${map.reason}" id="edit_${map.reason}" value="${reason}">
                            <input type="file" name="${map.image}" id="edit_${map.image}" class="hidden">
                            
                            <span id="edit_${map.key}_info" class="text-xs text-green-600 block mt-1">
                                ${status === '✖' && (reason || imagePath) ? 
                                    `✓ <strong>Reason:</strong> ${reason || '-'}<br>✓ <strong>Photo:</strong> ${imagePath ? 'Uploaded' : '-'}` 
                                    : ''}
                            </span>
                        </div>
                    `;
                });
                
                inspectionItems.innerHTML = itemsHtml;
                
                // Show modal
                editModal.classList.remove('hidden');
                
                // Add event listeners for status changes
                setTimeout(() => {
                    document.querySelectorAll('.status-select-edit').forEach(select => {
                        select.addEventListener('change', function(event) {
                            const selectedValue = this.value;
                            const fieldName = this.dataset.field;
                            const reasonField = this.dataset.reasonField;
                            const imageField = this.dataset.imageField;
                            const itemName = this.dataset.item;
                            const currentReason = this.dataset.currentReason;
                            const currentImage = this.dataset.currentImage;
                            
                            console.log('Status changed to:', selectedValue);
                            
                            if (selectedValue === '✖') {
                                // Show damage modal
                                editCurrentField = fieldName;
                                editCurrentSelect = this;
                                editCurrentReasonField = reasonField;
                                editCurrentImageField = imageField;
                                
                                document.getElementById('editModalTitle').textContent = 'Damage Report Form - ' + itemName;
                                
                                // Pre-fill if data exists
                                if (currentReason) {
                                    document.getElementById('editModalReasonInput').value = currentReason;
                                } else {
                                    document.getElementById('editModalReasonInput').value = '';
                                }
                                
                                // Show current image preview if exists
                                if (currentImage) {
                                    document.getElementById('editCurrentImageDisplay').src = `{{ asset('storage/app/public/damages/') }}/${currentImage}`;
                                    document.getElementById('editCurrentImagePreview').classList.remove('hidden');
                                } else {
                                    document.getElementById('editCurrentImagePreview').classList.add('hidden');
                                }
                                
                                document.getElementById('editModalImageInput').value = '';
                                editDamageModal.classList.remove('hidden');
                            } else {
                                // Clear reason and image
                                document.getElementById('edit_' + reasonField).value = '';
                                document.getElementById('edit_' + imageField).value = '';
                                document.getElementById('edit_' + fieldName + '_info').innerHTML = '';
                            }
                        });
                    });
                }, 100);
            }
        });

        // Edit Modal Save button
        editModalSave.addEventListener('click', function() {
            const file = document.getElementById('editModalImageInput').files[0];
            const reason = document.getElementById('editModalReasonInput').value.trim();
            
            // Validate reason
            if (!reason) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Error!',
                    text: 'Please fill in the damage reason first!',
                });
                return;
            }
            
            // If new file selected, validate it
            if (file) {
                if (file.size > 2048000) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'File size is too large! Maximum allowed is 2MB.',
                    });
                    return;
                }
            }
            
            // Save reason
            document.getElementById('edit_' + editCurrentReasonField).value = reason;
            
            // Save image if new file selected
            if (file) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('edit_' + editCurrentImageField).files = dataTransfer.files;
            }
            
            // Update info display
            const imageInfo = file ? file.name : (editCurrentSelect.dataset.currentImage ? 'Current image kept' : '-');
            document.getElementById('edit_' + editCurrentField + '_info').innerHTML = 
                `✓ <strong>Reason:</strong> ${reason}<br>✓ <strong>Photo:</strong> ${imageInfo}`;
            
            // Close modal
            editDamageModal.classList.add('hidden');
            document.getElementById('editModalReasonInput').value = '';
            document.getElementById('editModalImageInput').value = '';
            document.getElementById('editCurrentImagePreview').classList.add('hidden');
            editCurrentField = null;
            editCurrentSelect = null;
            editCurrentReasonField = null;
            editCurrentImageField = null;
            
            Swal.fire({
                icon: 'success',
                title: 'Done!',
                text: 'Reason and image have been updated successfully!',
                timer: 1500,
                showConfirmButton: false
            });
        });

        // Edit Modal Cancel & Close buttons
        const closeEditDamageModal = () => {
            editDamageModal.classList.add('hidden');
            document.getElementById('editModalReasonInput').value = '';
            document.getElementById('editModalImageInput').value = '';
            document.getElementById('editCurrentImagePreview').classList.add('hidden');
            if (editCurrentSelect) {
                const hasExistingData = editCurrentSelect.dataset.currentReason || editCurrentSelect.dataset.currentImage;
                editCurrentSelect.value = hasExistingData ? '✖' : '';
            }
            editCurrentField = null;
            editCurrentSelect = null;
            editCurrentReasonField = null;
            editCurrentImageField = null;
        };

        editModalCancel.addEventListener('click', closeEditDamageModal);
        editModalClose.addEventListener('click', closeEditDamageModal);

        const closeModal = () => {
            editModal.classList.add('hidden');
            editForm.reset();
        };

        closeEditModal.addEventListener('click', closeModal);
        btnCloseEdit.addEventListener('click', closeModal);

        // Close modal when clicking outside
        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) {
                closeModal();
            }
        });
    </script>

@endsection