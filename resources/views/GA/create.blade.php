@extends('content.app')
@section('content')
<div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
    <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
        <div class="grow">
            <h5 class="text-16">Pengisian Data Kendaraan</h5>
        </div>
    </div>

    <!-- CARD -->
    <div class="card-body relative p-6 rounded-lg">
        <div class="absolute inset-0 flex justify-center items-center pointer-events-none">
            <img src="{{ asset('public/assets/images/logo/logo-gi-transparant.png') }}" 
                 alt="Background"
                 class="max-w-xs max-h-32 opacity-10">
            <div class="absolute inset-0 bg-gray-100 opacity-80 rounded-lg"></div>
        </div>
        <h6 class="mb-4 text-15">Silahkan Masukkan Data</h6>

        <!-- Mulai Form -->
        <form action="{{ url('/simpan') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Grid: Form kiri + Tabel kanan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- FORM INPUT KENDARAAN -->
                <div>
                    <div class="mb-3">
                        <label for="nama_pelapor" class="inline-block mb-2 text-base font-medium">
                            Nama Pelapor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_pelapor" id="nama_pelapor"
                               class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                               placeholder="Masukkan Nama Lengkap Anda" required>
                    </div>

                    <div class="mb-3">
                        <label for="no_polisi" class="inline-block mb-2 text-base font-medium">
                            Nomor Polisi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="no_polisi" id="no_polisi"
                               class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                               placeholder="B 1234 XYZ" required>
                    </div>

                    <div class="mb-3">
                        <label for="merk" class="inline-block mb-2 text-base font-medium">
                            Merk Kendaraan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="merk" id="merk"
                               class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                               placeholder="Mitsubishi" required>
                    </div>

                    <div class="mb-3">
                        <label for="tahun" class="inline-block mb-2 text-base font-medium">
                            Tahun Kendaraan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tahun" id="tahun"
                               class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                               placeholder="2012" required>
                    </div>

                    <div class="mb-3">
                        <label for="jenis" class="inline-block mb-2 text-base font-medium">
                            Jenis Kendaraan <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis" id="jenis"
                                class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                required>
                            <option value="" disabled selected>Pilih Jenis Kendaraan</option>
                            <option value="Motor">Motor</option>
                            <option value="Mobil">Mobil</option>
                            <option value="Truck">Truck</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="inline-block mb-2 text-base font-medium">
                            Tanggal Perbaikan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggal"
                               class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                               required>
                    </div>

                    <div class="form-control mb-3">
                        <label class="font-weight-bold">Foto Kendaraan</label>
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
                </div>
            </div> <!-- end grid -->

            <!-- FOOTER SUBMIT BUTTON -->
            <div class="mt-10">
                <button type="submit"
                        class="w-full text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
