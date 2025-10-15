@extends('content.app')
@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h6 class="text-15">User Management</h6>
                <button id="btn-tambah"
                    class="px-3 py-1 text-md bg-custom-500 hover:bg-custom-600 text-white rounded shadow transition">
                    Add New User
                </button>
            </div>

            <table class="table-auto w-full border-collapse border border-gray-300 text-sm" id="my-table">
                <thead class="bg-custom-200">
                    <tr>
                        <th class="border px-2 py-1 text-center">Username</th>
                        <th class="border px-2 py-1 text-center">Full Name</th>
                        <th class="border px-2 py-1 text-center">Department</th>
                        <th class="border px-2 py-1 text-center">Role</th>
                        <th class="border px-2 py-1 w-[160px] text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr
                            class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition-colors text-center">
                            <td class="border px-2 py-1">{{ $user->username }}</td>
                            <td class="border px-2 py-1">{{ $user->nama }}</td>
                            <td class="border px-2 py-1">{{ $user->department }}</td>
                            <td class="border px-2 py-1">
                                @if($user->role == 1)
                                    <span class="text-green-600 font-semibold">Admin</span>
                                @else
                                    <span class="text-blue-600 font-semibold">User</span>
                                @endif
                            </td>
                            <td class="border px-2 py-1 text-center whitespace-nowrap w-[160px]">
                                <div class="flex justify-center gap-2">
                                    <button type="button" data-id="{{ $user->id }}" data-username="{{ $user->username }}"
                                        data-nama="{{ $user->nama }}" data-department="{{ $user->department }}"
                                        data-role="{{ $user->role }}"
                                        class="btn-edit px-3 py-1 text-md bg-green-500 hover:bg-green-600 text-white rounded shadow transition">
                                        Edit
                                    </button>

                                    <form action="{{ route('user.delete', $user->id) }}" method="POST" class="delete-form">
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
                {{ $users->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div id="modal-tambah" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
            <h6 class="mb-4 text-15">Add New User</h6>
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-3">
                        <label for="username" class="inline-block mb-2 text-base font-medium">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" id="username" class="form-input border border-slate-200 w-full"
                            placeholder="Enter username" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="inline-block mb-2 text-base font-medium">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" class="form-input border border-slate-200 w-full"
                            placeholder="Enter full name" required>
                    </div>

                    <div class="mb-3 md:col-span-2">
                        <label for="password" class="inline-block mb-2 text-base font-medium">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" id="password"
                            class="form-input border border-slate-200 w-full" placeholder="Enter password" required>
                    </div>

                    <div class="mb-3 md:col-span-2">
                        <label class="inline-block mb-2 text-base font-medium">
                            Department <span class="text-red-500">*</span>
                        </label>
                        <ul class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <li>
                                <div class="flex items-center">
                                    <input id="department-mis" type="radio" value="MIS" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                                    <label for="department-mis" class="ml-2 text-sm font-medium">MIS</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="department-ga" type="radio" value="GA" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="department-ga" class="ml-2 text-sm font-medium">GA</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="department-factory" type="radio" value="Factory" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="department-factory" class="ml-2 text-sm font-medium">Factory</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="department-production" type="radio" value="Production" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="department-production" class="ml-2 text-sm font-medium">Production</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="department-warehouse" type="radio" value="Warehouse" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="department-warehouse" class="ml-2 text-sm font-medium">Warehouse</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="department-qc" type="radio" value="QC" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="department-qc" class="ml-2 text-sm font-medium">QC</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="department-hr" type="radio" value="HR" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="department-hr" class="ml-2 text-sm font-medium">HR</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="department-ppic" type="radio" value="PPIC" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="department-ppic" class="ml-2 text-sm font-medium">PPIC</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="department-accounting" type="radio" value="Accounting" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="department-accounting" class="ml-2 text-sm font-medium">Accounting</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>



                <div class="mt-4 flex gap-2">
                    <button type="submit"
                        class="px-3 py-1 text-xs bg-custom-500 hover:bg-custom-600 text-white rounded shadow transition">
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
            <h6 class="mb-4 text-15">Edit User</h6>
            <form id="form-edit" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-3">
                        <label class="inline-block mb-2 text-base font-medium">Username</label>
                        <input type="text" name="username" id="edit_username"
                            class="form-input border border-slate-200 w-full bg-gray-100" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="inline-block mb-2 text-base font-medium">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="edit_nama" class="form-input border border-slate-200 w-full"
                            required>
                    </div>

                    <div class="mb-3 md:col-span-2">
                        <label class="inline-block mb-2 text-base font-medium">
                            Password <span class="text-gray-500 text-sm">(Skip if no changes needed.)</span>
                        </label>
                        <input type="password" name="password" id="edit_password"
                            class="form-input border border-slate-200 w-full" placeholder="Enter new password">
                    </div>

                    <div class="mb-3 md:col-span-2">
                        <label class="inline-block mb-2 text-base font-medium">
                            Department <span class="text-red-500">*</span>
                        </label>
                        <ul class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <li>
                                <div class="flex items-center">
                                    <input id="edit-department-mis" type="radio" value="MIS" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" required>
                                    <label for="edit-department-mis" class="ml-2 text-sm font-medium">MIS</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="edit-department-ga" type="radio" value="GA" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="edit-department-ga" class="ml-2 text-sm font-medium">GA</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="edit-department-factory" type="radio" value="Factory" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="edit-department-factory" class="ml-2 text-sm font-medium">Factory</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="edit-department-production" type="radio" value="Production" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="edit-department-production"
                                        class="ml-2 text-sm font-medium">Production</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="edit-department-warehouse" type="radio" value="Warehouse" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="edit-department-warehouse"
                                        class="ml-2 text-sm font-medium">Warehouse</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="edit-department-qc" type="radio" value="QC" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="edit-department-qc" class="ml-2 text-sm font-medium">QC</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="edit-department-hr" type="radio" value="HR" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="edit-department-hr" class="ml-2 text-sm font-medium">HR</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="edit-department-ppic" type="radio" value="PPIC" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="edit-department-ppic" class="ml-2 text-sm font-medium">PPIC</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <input id="edit-department-accounting" type="radio" value="Accounting" name="department"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="edit-department-accounting"
                                        class="ml-2 text-sm font-medium">Accounting</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <button type="submit"
                        class="px-3 py-1 text-xs bg-green-500 hover:bg-green-600 text-white rounded shadow transition">
                        Update
                    </button>
                    <button type="button" id="btn-batal-edit"
                        class="px-3 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded shadow transition">
                        Cancel
                    </button>
                </div>
            </form>
            <button id="btn-close-edit"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#my-table').DataTable({
            columnDefs: [{ orderable: false, targets: [4] }]
        });

        // Hapus
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                let form = this.closest('form');
                Swal.fire({
                    title: 'Are you sure you want to delete this user?',
                    text: "Deleted data cannot be restored.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // Modal Tambah
        const modalTambah = document.getElementById('modal-tambah');
        document.getElementById('btn-tambah').addEventListener('click', () => modalTambah.classList.remove('hidden'));
        document.getElementById('btn-batal').addEventListener('click', () => modalTambah.classList.add('hidden'));
        document.getElementById('btn-close').addEventListener('click', () => modalTambah.classList.add('hidden'));

        // Modal Edit
        const modalEdit = document.getElementById('modal-edit');
        const formEdit = document.getElementById('form-edit');
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function () {
                let id = this.dataset.id;
                let url = "{{ route('user.update', ':id') }}".replace(':id', id);
                formEdit.action = url;

                // Set values
                document.getElementById('edit_username').value = this.dataset.username;
                document.getElementById('edit_nama').value = this.dataset.nama;

                // Reset password field
                document.getElementById('edit_password').value = '';

                // Set department radio button
                let department = this.dataset.department;
                document.querySelectorAll('input[name="department"]').forEach(radio => {
                    radio.checked = (radio.value === department);
                });

                modalEdit.classList.remove('hidden');
            });
        });

        document.getElementById('btn-batal-edit').addEventListener('click', () => modalEdit.classList.add('hidden'));
        document.getElementById('btn-close-edit').addEventListener('click', () => modalEdit.classList.add('hidden'));

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
@endsection