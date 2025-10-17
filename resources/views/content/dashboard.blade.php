    @extends('content.app')
    @section('content')
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-2 md:flex-row md:items-center justify-between print:hidden">
        </div>
        {{-- Header --}}
        <div class="card overflow-x-auto rounded">
            <div class="card-body flex flex-col print:hidden">
                <h4 class="font-semibold text-gray-800 dark:text-gray-200">
                    Vehicle Maintenance Report Dashboard
                </h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    From {{ date('F Y') }} records
                </p>
            </div>

            <div class="card-body grid grid-cols-1 md:grid-cols-2">

            {{-- Total Data Kendaraan --}}
            <div class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                <div class="absolute top-0 left-0 w-1.5 bg-custom-500 h-full rounded-l-3xl"></div>
                <div class="flex flex-col items-center text-center space-y-2">
                    <div class="text-4xl font-bold text-custom-600">{{ $vehicles->count() }}</div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Total Records Sent</p>
                </div>
            </div>

            {{-- Total Verified --}}
            <div class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                <div class="absolute top-0 left-0 w-1.5 bg-green-500 h-full rounded-l-3xl"></div>
                <div class="flex flex-col items-center text-center space-y-2">
                    <div class="text-4xl font-bold text-green-600">{{ $vehicles->where('status', '✔' )->count() }}</div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Approved ✔</p>
                </div>
            </div>

            {{-- Total Unverified --}}
            <div class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                <div class="absolute top-0 left-0 w-1.5 bg-orange-300 h-full rounded-l-3xl"></div>
                <div class="flex flex-col items-center text-center space-y-2">
                    <div class="text-4xl font-bold text-orange-400">{{ $vehicles->whereNull('status')->count()}}</div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Unverified</p>
                </div>
            </div>

            <div class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                <div class="absolute top-0 left-0 w-1.5 bg-red-500 h-full rounded-l-3xl"></div>
                <div class="flex flex-col items-center text-center space-y-2">
                    <div class="text-4xl font-bold text-red-600">{{$vehicles->where('status', '✖')->count() }}</div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Rejected ✖</p>
                </div>
            </div>
        </div>
        </div>

        {{-- Tabel Data Kendaraan --}}
        <div class="card bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-2xl shadow-sm p-6 mb-10">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-semibold text-gray-800 dark:text-gray-200">Vehicle Data You’ve Submitted</h4>
            </div>
            <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-zinc-700">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-zinc-700 text-gray-700 dark:text-gray-100 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2 border text-center">No</th>
                            <th class="px-4 py-2 border text-center">Photo</th>
                            <th class="px-4 py-2 border text-center">Report By</th>
                            <th class="px-4 py-2 border text-center">License Plate Number</th>
                            <th class="px-4 py-2 border text-center">Vehicle Brand</th>
                            <th class="px-4 py-2 border text-center">Repair Date</th>
                            <th class="px-4 py-2 border text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">
                        @foreach($vehicles as $index => $v)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700 transition text-center">
                                <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">
                                    @if($v->image)
                                        <img src="{{ asset('storage/app/public/vehicle/' . $v->image) }}" class="w-16 h-12 object-cover rounded mx-auto">
                                    @else
                                        <span class="text-gray-400 italic">No Image</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">{{ $v->nama_pelapor }}</td>
                                <td class="px-4 py-2 border">{{ $v->no_polisi }}</td>
                                <td class="px-4 py-2 border">{{ $v->merk }}</td>
                                <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($v->tanggal)->format('d M Y') }}</td>
                                <td class="px-4 py-2 border">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                        @if($v->status === '✔')
                                            bg-green-100 text-green-700
                                        @elseif($v->status === '✖')
                                            bg-red-100 text-red-700
                                        @else
                                            bg-yellow-100 text-yellow-700
                                        @endif
                                    ">
                                    <span class="w-2 h-2 rounded-full 
                                            @if($v->status === '✔') bg-green-500
                                            @elseif($v->status === '✖') bg-red-500
                                            @else bg-yellow-500
                                            @endif
                                    "></span>   
                                        @if($v->status === '✔')
                                            Verified
                                        @elseif($v->status === '✖')
                                            Rejected
                                        @else
                                            Unverified
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endsection
