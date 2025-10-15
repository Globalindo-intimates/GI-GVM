@extends('content.app')
@section('content')
        <div class="card mt-3">
            <div class="card-body">
                <div class="flex items-center justify-between mb-4">
                    <h6 class="text-15">Master Data Vehicle</h6>
                    <button id="btn-tambah"
                        class="px-3 py-1 text-md bg-custom-500 hover:bg-custom-600 text-white rounded shadow transition">
                        Add New Data
                    </button>
                </div>

                <table class="table-auto w-full border-collapse border border-gray-300 text-sm" id="my-table">
                    <thead class="bg-custom-200">
                        <tr>
                            <th class="border px-2 py-1 text-center">License Plate Number</th>
                            <th class="border px-2 py-1 text-center">Vehicle Brand</th>
                            <th class="border px-2 py-1 text-center">Year of Vehicle</th>
                            <th class="border px-2 py-1 text-center">Type of Vehicle</th>
                            <th class="border px-2 py-1 w-[160px] text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kendaraan as $item)
                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition-colors text-center">
                                <td class="border px-2 py-1">{{ $item->no_polisi }}</td>
                                <td class="border px-2 py-1">{{ $item->merk }}</td>
                                <td class="border px-2 py-1">{{ $item->tahun }}</td>
                                <td class="border px-2 py-1">{{ $item->jenis }}</td>
                                <td class="border px-2 py-1 text-center whitespace-nowrap w-[160px]">
                                    <div class="flex justify-center gap-2">

                                        {{-- Tombol Edit, tidak submit langsung --}}
                                        <button type="button"
                                            data-id="{{ $item->id }}"
                                            data-no_polisi="{{ $item->no_polisi }}"
                                            data-merk="{{ $item->merk }}"
                                            data-tahun="{{ $item->tahun }}"
                                            data-jenis="{{ $item->jenis }}"
                                            class="btn-edit px-3 py-1 text-md bg-green-500 hover:bg-green-600 text-white rounded shadow transition">
                                            Edit
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('master.delete', $item->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="px-3 py-1 text-md bg-red-500 hover:bg-red-600 text-white rounded shadow transition delete-btn">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
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
    </div>

    {{-- MODAL TAMBAH --}}
    <div id="modal-tambah" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
            <h6 class="mb-4 text-15">Add New Vehicle Data</h6>
            <form action="{{ route('master.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-3">
                        <label for="no_polisi" class="inline-block mb-2 text-base font-medium">
                            License Plate Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="no_polisi" id="no_polisi"
                            class="form-input border border-slate-200 w-full"
                            placeholder="Enter vehicle’s plate number (AD 1234 CC)"
                             required>
                    </div>

                    <div class="mb-3">
                        <label for="merk" class="inline-block mb-2 text-base font-medium">
                            Vehicle Brand <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="merk" id="merk"
                            class="form-input border border-slate-200 w-full"
                            placeholder="Enter vehicle brand (e.g., Toyota, Hino)"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="tahun" class="inline-block mb-2 text-base font-medium">
                            Year of Vehicle <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tahun" id="tahun"
                            class="form-input border border-slate-200 w-full"
                            placeholder="Enter vehicle year (e.g., 2020)"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="jenis" class="inline-block mb-2 text-base font-medium">
                            Type of Vehicle <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis" id="jenis"
                            class="form-select border border-slate-200 w-full" required>
                            <option value="" disabled selected>Choose Vehicle Type</option>
                            <option value="Motor">Motorcycle</option>
                            <option value="Mobil">Car</option>
                            <option value="Truck">Truck</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <button type="submit" class="px-3 py-1 text-xs bg-custom-500 hover:bg-custom-600 text-white rounded shadow transition">
                        Save
                    </button>
                    <button type="button" id="btn-batal"
                        class="px-3 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded shadow transition">
                        Cancel
                    </button>
                </div>
            </form>
            <button id="btn-close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="modal-edit" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
            <h6 class="mb-4 text-15">Edit Vehicle Data</h6>
            <form id="form-edit" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-3">
                        <label class="inline-block mb-2 text-base font-medium">License Plate Number</label>
                        <input type="text" name="no_polisi" id="edit_no_polisi"
                            class="form-input border border-slate-200 w-full"
                            placeholder="Enter vehicle’s plate number (AD 1234 CC)"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="inline-block mb-2 text-base font-medium">Vehicle Brand</label>
                        <input type="text" name="merk" id="edit_merk"
                            class="form-input border border-slate-200 w-full"
                            placeholder="Enter vehicle brand (e.g., Toyota, Hino)"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="inline-block mb-2 text-base font-medium">Year of Vehicle</label>
                        <input type="text" name="tahun" id="edit_tahun"
                            class="form-input border border-slate-200 w-full"
                            placeholder="Enter vehicle year (e.g., 2020)"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="inline-block mb-2 text-base font-medium">Type of Vehicle</label>
                        <select name="jenis" id="edit_jenis"
                            class="form-select border border-slate-200 w-full" required>
                            <option value="" disabled selected>Choose Vehicle Type</option>
                            <option value="Motor">Motorcycle</option>
                            <option value="Mobil">Car</option>
                            <option value="Truck">Truck</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <button type="submit" class="px-3 py-1 text-xs bg-green-500 hover:bg-green-600 text-white rounded shadow transition">
                        Update
                    </button>
                    <button type="button" id="btn-batal-edit"
                        class="px-3 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded shadow transition">
                        Cancel
                    </button>
                </div>
            </form>
            <button id="btn-close-edit" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#my-table').DataTable({
            columnDefs: [
                { orderable: false, targets: [0, 1, 3, 4] }
            ]
        });

        // Hapus
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function () {
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

        // Tambah
        const btnTambah = document.getElementById('btn-tambah');
        const modalTambah = document.getElementById('modal-tambah');
        const btnBatal = document.getElementById('btn-batal');
        const btnClose = document.getElementById('btn-close');

        btnTambah.addEventListener('click', () => modalTambah.classList.remove('hidden'));
        btnBatal.addEventListener('click', () => modalTambah.classList.add('hidden'));
        btnClose.addEventListener('click', () => modalTambah.classList.add('hidden'));

        // Edit
        const modalEdit = document.getElementById('modal-edit');
        const btnBatalEdit = document.getElementById('btn-batal-edit');
        const btnCloseEdit = document.getElementById('btn-close-edit');
        const formEdit = document.getElementById('form-edit');
         document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function () {
                let id = this.dataset.id;

                let url = "{{ route('master.update', ':id') }}";
                url = url.replace(':id', id);
                formEdit.action = url;

                document.getElementById('edit_no_polisi').value = this.dataset.no_polisi;
                document.getElementById('edit_merk').value = this.dataset.merk;
                document.getElementById('edit_tahun').value = this.dataset.tahun;
                document.getElementById('edit_jenis').value = this.dataset.jenis;

                modalEdit.classList.remove('hidden');
            });
        });

        btnBatalEdit.addEventListener('click', () => modalEdit.classList.add('hidden'));
        btnCloseEdit.addEventListener('click', () => modalEdit.classList.add('hidden'));
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Done!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
@endsection
