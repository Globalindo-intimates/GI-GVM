@extends('content.app')
@section('content')
        <div class="card mt-3">
            <div class="card-body">
                <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                    <div class="grow">
                        <h5 class="text-16">Please fill in the data</h5>
                    </div>
                </div>

                <div class="card-body relative p-6 rounded-lg">
                    <div class="absolute inset-0 flex justify-center items-center pointer-events-none">
                        <img src="{{ asset('public/assets/images/logo/logo-gi-transparant.png') }}" alt="Background"
                            class="max-w-xs max-h-32 opacity-10">
                        <div class="absolute inset-0 bg-gray-100 opacity-80 rounded-lg"></div>
                    </div>
                    <form action="{{ url('/simpan') }}" method="POST" enctype="multipart/form-data" id="mainForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- form kendaraan -->
                            <div>
                                <div class="mb-3">
                                    <label for="nama_pelapor" class="inline-block mb-2 text-base font-medium">Report By
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_pelapor" id="nama_pelapor"
                                        class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                        placeholder="Enter reporter's name" value="{{ session('user.nama') }}" readonly
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="no_polisi" class="inline-block mb-1 text-base font-medium">License Plate
                                        Number <span class="text-red-500">*</span></label>
                                    <select type="text" name="id_kendaraan" id="no_polisi"
                                        class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                        required>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="merk" class="inline-block mb-2 text-base font-medium">Vehicle Brand<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="merk" id="merk"
                                        class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                        placeholder="Enter vehicle brand (e.g., Toyota, Hino)" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="tahun" class="inline-block mb-2 text-base font-medium">Year of Vehicle<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="tahun" id="tahun"
                                        class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                        placeholder="Enter vehicle year (e.g., 2020)" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="jenis" class="inline-block mb-2 text-base font-medium">Type of Vehicle<span
                                            class="text-red-500">*</span></label>
                                    <input name="jenis" id="jenis"
                                        class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                        placeholder="Select vehicle type (e.g., Car, Motorcycle, Truck)" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal" class="inline-block mb-2 text-base font-medium">Repair Date<span
                                            class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal" id="tanggal"
                                        class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                        required>
                                </div>

                                <div class="form-control mb-3">
                                    <label class="font-weight-bold">Photo of Vehicle</label>
                                    <span class="text-red-500">*</span>
                                    <p></p>
                                    <input type="file"
                                        class="form-control border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 @error('image') is-invalid @enderror"
                                        name="image" required>
                                    @error('image')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- inputan perawatan -->
                            <div class="overflow-x-auto">
                                <table class="table-auto border-collapse border border-gray-400 text-xs w-full text-center">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border border-gray-400 px-2 py-2 w-10">No</th>
                                            <th class="border border-gray-400 px-2 py-2">Inspection Item</th>
                                            <th class="border border-gray-400 px-2 py-2 w-28">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $items = ['OLI MESIN', 'OLI POWER STEERING', 'OLI REM', 'BODY KENDARAAN', 'OTOMATIS / STARTER', 'RADIATOR', 'BATERAI / AKI', 'WIPERS DEPAN', 'WIPERS BELAKANG', 'BAN DEPAN', 'BAN BELAKANG', 'LAMPU DEPAN', 'LAMPU BELAKANG', 'LAMPU REM', 'KLAKSON', 'KEBERSIHAN', 'KUNCI RODA', 'DONGKRAK', 'KOTAK P3K', 'SEGITIGA PENGAMAN'];
                                        @endphp
                                        @foreach($items as $index => $item)
                                            @php
                                                $fieldName = Str::slug(strtolower($item), '_');
                                            @endphp
                                            <tr class="{{ $index % 1 == 0 ?: 'bg-gray-50' }} hover:bg-gray-100 transition-colors">
                                                <td class="border border-gray-300 px-3 py-2">{{ $index + 1 }}</td>
                                                <td class="border border-gray-300 px-3 py-2 text-left">{{ $item }}</td>
                                                <td class="border border-gray-300 px-3 py-2">
                                                    <select name="{{ $fieldName }}" 
                                                        class="status-select w-full text-center border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-blue-300 focus:outline-none"
                                                        data-field="{{ $fieldName }}"
                                                        data-item="{{ $item }}">
                                                        <option value="">-</option>
                                                        <option value="✔">✔</option>
                                                        <option value="✖">✖</option>
                                                    </select>
                                                    <!-- Hidden file input for damage image -->
                                                    <input type="file" 
                                                        name="{{ $fieldName }}_image" 
                                                        id="{{ $fieldName }}_image" 
                                                        class="hidden damage-image-input"
                                                        accept="image/*">
                                                    <!-- Hidden input for damage reason -->
                                                    <input type="hidden" 
                                                        name="{{ $fieldName }}_reason" 
                                                        id="{{ $fieldName }}_reason" 
                                                        class="damage-reason-input">
                                                    <span id="{{ $fieldName }}_info" class="text-xs text-green-600 block mt-1"></span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <p></p>
                            <div class="mt-10">
                                <button type="submit" id="simpan"
                                    class="w-full text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600">
                                    Save Data
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for Damage Image Upload -->
        <div id="damageImageModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-md p-6 relative">
                <h6 class="mb-4 text-15 font-semibold" id="modalTitle">Upload Damage Image</h6>
                
                <div class="mb-4">
                    <label class="inline-block mb-2 text-base font-medium">
                        Damage Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="modalReasonInput" 
                        rows="3"
                        placeholder="Describe the damage (e.g., Cracked, Not working, Worn out, etc.)"
                        class="form-input border border-slate-200 w-full resize-none"></textarea>
                </div>

                <div class="mb-4">
                    <label class="inline-block mb-2 text-base font-medium">
                        Damage Photo <span class="text-red-500">*</span>
                    </label>
                    <input type="file" 
                        id="modalImageInput" 
                        accept="image/*"
                        class="form-input border border-slate-200">
                    <p class="mt-2 text-xs text-gray-500">Accepted formats: JPG, PNG, JPEG (Max: 2MB)</p>
                </div>

                <div class="mt-4 flex gap-2">
                    <button type="button" 
                        id="modalSave"
                        class="px-3 py-1 text-md bg-custom-500 hover:bg-custom-600 text-white rounded shadow transition">
                        Upload
                    </button>
                    <button type="button" 
                        id="modalCancel"
                        class="px-3 py-1 text-md bg-red-500 hover:bg-red-600 text-white rounded shadow transition">
                        Cancel
                    </button>
                </div>
                
                <button id="modalClose" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if(session('success'))
            <script>
                Swal.fire({
                    title: 'Done !',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'Return',
                    confirmButtonColor: '#216eb6ff',
                    background: '#fefefe',
                    color: '#333',
                    backdrop: `rgba(130, 130, 130, 0.4) left top no-repeat`
                })
            </script>
        @endif
        
        <script>
            $(document).ready(function () {
                let currentField = null;
                let currentSelect = null;

                // Load vehicle data
                $.ajax({
                    url: '{{url('/getdata')}}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (response) {
                        $('#no_polisi').empty()
                        let $select = $('#no_polisi');
                        $select.empty().append('<option></option>');

                        $.each(response.data, function (i, item) {
                            $select.append($('<option>', {
                                value: item.id,
                                text: item.no_polisi,
                            }))
                        })
                        
                        $select.select2({
                            theme: 'bootstrap-5',
                            text: 'false',
                            placeholder: 'Enter vehicle plate number',
                        })

                        $('#no_polisi').on('change', function () {
                            let id = $(this).val()
                            $.ajax({
                                url: '{{url('/getmasterdata')}}',
                                type: 'GET',
                                dataType: 'JSON',
                                data: { id: id },
                                success: function (response) {
                                    let item = response.data[0];
                                    $('#merk').val(item.merk)
                                    $('#tahun').val(item.tahun)
                                    $('#jenis').val(item.jenis)
                                }
                            })
                        });
                    }
                })

                // Handle status change
                $('.status-select').on('change', function() {
                    const selectedValue = $(this).val();
                    const fieldName = $(this).data('field');
                    const itemName = $(this).data('item');
                    
                    if (selectedValue === '✖') {
                        // Show modal for image upload
                        currentField = fieldName;
                        currentSelect = $(this);
                        $('#modalTitle').text('Damage Report Form - ' + itemName);
                        $('#damageImageModal').removeClass('hidden');
                    } else {
                        // Clear image and reason if status changed from ✖
                        $('#' + fieldName + '_image').val('');
                        $('#' + fieldName + '_reason').val('');
                        $('#' + fieldName + '_info').text('');
                    }
                });

                // Modal cancel button
                $('#modalCancel').on('click', function() {
                    $('#damageImageModal').addClass('hidden');
                    $('#modalImageInput').val('');
                    $('#modalReasonInput').val('');
                    if (currentSelect) {
                        currentSelect.val(''); // Reset select to default
                    }
                    currentField = null;
                    currentSelect = null;
                });

                // Modal close button (X)
                $('#modalClose').on('click', function() {
                    $('#damageImageModal').addClass('hidden');
                    $('#modalImageInput').val('');
                    $('#modalReasonInput').val('');
                    if (currentSelect) {
                        currentSelect.val(''); // Reset select to default
                    }
                    currentField = null;
                    currentSelect = null;
                });

                // Modal save button
                $('#modalSave').on('click', function() {
                    const file = $('#modalImageInput')[0].files[0];
                    const reason = $('#modalReasonInput').val().trim();
                    
                    // Validasi reason
                    if (!reason) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Error!',
                            text: 'Please fill in the damage reason first!',
                        });
                        return;
                    }
                    
                    // Validasi file
                    if (!file) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Error!',
                            text: 'Please select an image first!',
                        });
                        return;
                    }

                    // Validate file size (max 2MB)
                    if (file.size > 2048000) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'File size is too large! Maximum allowed is 2MB.',
                        });
                        return;
                    }

                    // Transfer file to hidden input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    $('#' + currentField + '_image')[0].files = dataTransfer.files;
                    
                    // Save reason to hidden textarea
                    $('#' + currentField + '_reason').val(reason);
                    
                    // Show info
                    $('#' + currentField + '_info').html('✓ <strong>Reason:</strong> ' + reason + '<br>✓ <strong>Photo:</strong> ' + file.name);
                    
                    // Close modal
                    $('#damageImageModal').addClass('hidden');
                    $('#modalImageInput').val('');
                    $('#modalReasonInput').val('');
                    currentField = null;
                    currentSelect = null;

                    Swal.fire({
                        icon: 'success',
                        title: 'Done!',
                        text: 'Reason and image have been added successfully!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });

                // Form validation before submit
                $('#mainForm').on('submit', function(e) {
                    let hasError = false;
                    let errorMessage = '';

                    $('.status-select').each(function() {
                        const selectedValue = $(this).val();
                        const fieldName = $(this).data('field');
                        const itemName = $(this).data('item');
                        
                        if (selectedValue === '✖') {
                            const imageFile = $('#' + fieldName + '_image')[0].files[0];
                            if (!imageFile) {
                                hasError = true;
                                errorMessage += '- ' + itemName + '\n';
                            }
                        }
                    });

                    if (hasError) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Incomplete Data',
                            text: 'Some required fields are missing' + errorMessage,
                        });
                        return false;
                    }
                });
            });
        </script>
@endsection