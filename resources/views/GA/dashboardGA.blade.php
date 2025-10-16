@extends('content.app')
@section('content')
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-6 md:flex-row md:items-center justify-between print:hidden">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Welcome To GI-GVM General Affair!</h3>
            </div>
            <ul class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-300 space-x-2">
                <li><a href="{{ url('dashboardGA') }}" class="hover:text-green-600">GI-GVM</a></li>
                <li>||</li>
                <li class="text-gray-700 dark:text-white">Dashboard</li>
            </ul>
        </div>
            {{-- Statistik Ringkas --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 ">
                {{-- Total Perawatan --}}
                <div
                    class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-1.5 bg-custom-500 h-full rounded-l-3xl"></div>
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="absolute top-0 left-0 w-1.5 bg-green-500 h-full rounded-l-3xl"></div>
                        <div class="text-4xl font-bold text-green-600 group-hover:scale-105 transition-transform">
                            {{ $totalPerawatan }}
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Total Maintenance This Month</p>
                    </div>
                </div>

                {{-- Verified / Unverified --}}
                <div
                    class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-1.5 bg-custom-500 h-full rounded-l-3xl"></div>
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="absolute top-0 left-0 w-1.5 bg-custom-500 h-full rounded-l-3xl"></div>
                        <div class="text-4xl font-bold text-custom-500 group-hover:scale-105 transition-transform">
                            {{ $verified }}
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Verified</p>
                    </div>
                </div>

                <div
                    class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-1.5 bg-custom-500 h-full rounded-l-3xl"></div>
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="absolute top-0 left-0 w-1.5 bg-red-500 h-full rounded-l-3xl"></div>
                        <div class="text-4xl font-bold text-red-500 group-hover:scale-105 transition-transform">
                            {{ $unverified }}
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Unverified</p>
                    </div>
                </div>

                <div
                    class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-1.5 bg-orange-500 h-full rounded-l-3xl"></div>
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="text-4xl font-bold text-orange-600 group-hover:scale-105 transition-transform">
                            {{ $kendaraan->count() }}
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Total Registered Vehicles</p>
                    </div>
                </div>
            </div>

            {{-- Grafik --}}
            <div
                class="card bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-2xl shadow-sm p-6 mb-10">
                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    Monthly Maintenance Count Chart
                </h4>
                <p class="text-lg">{{ $tahun }}</p>
                <div class="-mx-6 mt-2">
                    <div class="w-full h-64">
                        <canvas id="chartPerawatan" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>


            {{-- Data Kendaraan Terbaru --}}
            <div
                class="card bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-2xl shadow-sm p-6 mb-10">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-200">Newest Vehicles</h4>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 text">Last 5 Reported Vehicles</p>
                <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-zinc-700">
                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-zinc-700 text-gray-700 dark:text-gray-100 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Vehicle Brand</th>
                                <th class="px-4 py-2 border">License Plate Number</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Repair Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">
                            @foreach($latestVehicles as $index => $v)
                                <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700 transition">
                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border font-medium">{{ strtoupper($v->merk ?? '-') }}</td>
                                    <td class="px-4 py-2 border">{{ $v->no_polisi ?? '-' }}</td>
                                    <td class="px-4 py-2 border">
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold {{ !empty($v->status) && !empty($v->pemeriksa) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            <span
                                                class="w-2 h-2 rounded-full {{ !empty($v->status) && !empty($v->pemeriksa) ? 'bg-green-500' : 'bg-red-500' }}">
                                            </span>
                                            {{ !empty($v->status) && !empty($v->pemeriksa) ? 'Verified' : 'Unverified' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 border text-gray-500">
                                        {{ $v->updated_at ? $v->updated_at->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- ChartJS --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('chartPerawatan');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($bulanLabel) !!},
                    datasets: [{
                        label: 'Jumlah Perawatan',
                        data: {!! json_encode($dataPerawatan) !!},
                        borderWidth: 1,
                        borderRadius: 6,
                        backgroundColor: 'rgba(32, 119, 226, 0.7)',
                        hoverBackgroundColor: 'rgba(32, 119, 226, 0.7)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#6b7280',
                                stepSize: 1,     
                                precision: 0,         
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : null;
                                }
                            },
                            grid: { color: '#e5e7eb' }
                        },
                        x: {
                            ticks: { color: '#6b7280' },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        </script>
@endsection