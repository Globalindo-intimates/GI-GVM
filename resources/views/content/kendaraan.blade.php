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

                    <form action="{{ url('/simpan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- form kendaraan -->
                            <div>
                                <div class="mb-3">
                                    <label for="nama_pelapor" class="inline-block mb-2 text-base font-medium">Report By
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_pelapor" id="nama_pelapor"
                                        class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                        placeholder="Enter reporter’s name" value="{{ session('user.nama') }}" readonly
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

                                    </input>
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
                                            <th class="border border-gray-400 px-2 py-2">Item Kontrol</th>
                                            <th class="border border-gray-400 px-2 py-2 w-28">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $items = ['OLI MESIN', 'OLI POWER STEERING', 'OLI REM', 'BODY KENDARAAN', 'OTOMATIS / STARTER', 'RADIATOR', 'BATERAI / AKI', 'WIPERS DEPAN', 'WIPERS BELAKANG', 'BAN DEPAN', 'BAN BELAKANG', 'LAMPU DEPAN', 'LAMPU BELAKANG', 'LAMPU REM', 'KLAKSON', 'KEBERSIHAN', 'KUNCI RODA', 'DONGKRAK', 'KOTAK P3K', 'SEGITIGA PENGAMAN'];
                                        @endphp
                                        @foreach($items as $index => $item)
                                            <tr
                                                class="{{ $index % 1 == 0 ?: 'bg-gray-50' }} hover:bg-gray-100 transition-colors">
                                                <td class="border border-gray-300 px-3 py-2">{{ $index + 1 }}</td>
                                                <td class="border border-gray-300 px-3 py-2 text-left">{{ $item }}</td>
                                                <td class="border border-gray-300 px-3 py-2">
                                                    <select name="{{ Str::slug(strtolower($item), '_') }}"
                                                        class="w-full text-center border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-blue-300 focus:outline-none">
                                                        <option value="">-</option>
                                                        <option value="✔">✔</option>
                                                        <option value="✖">✖</option>
                                                    </select>
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

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if(session('success'))
            <script>

                Swal.fire({
                    title: 'Berhasil !',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'Kembali',
                    confirmButtonColor: '#216eb6ff',
                    background: '#fefefe',
                    color: '#333',
                    backdrop: `
                                    rgba(130, 130, 130, 0.4)
                                    left top
                                    no-repeat
                                `
                })
            </script>
        @endif
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: '{{url('/getdata')  }}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (response) {
                        $('#no_polisi').empty()
                        let $select = $('#no_polisi');
                        let no_polisi = [];
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
                            placeholder: 'Enter vehicle’s plate number',
                        })

                        $('#no_polisi').on('change', function () {
                            let id = $(this).val()
                            $.ajax({
                                url: '{{url('/getmasterdata')  }}',
                                type: 'GET',
                                dataType: 'JSON',
                                data: {
                                    id: id,
                                },
                                success: function (response) {
                                    let item = response.data[0];
                                    console.log(response);
                                    $('#merk').val(item.merk)
                                    $('#tahun').val(item.tahun)
                                    $('#jenis').val(item.jenis)
                                }
                            })
                        });

                    }

                })
            })



        </script>
@endsection