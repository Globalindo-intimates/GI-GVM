@extends('content.app')
@section('content')
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
        <div class="flex flex-col gap-2 py-2 md:flex-row md:items-center justify-between print:hidden">
        </div>
        {{-- Statistik Ringkas --}}
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
                <div
                    class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-1.5 bg-custom-500 h-full rounded-l-3xl"></div>
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="text-4xl font-bold text-custom-600">{{ $totalPerawatan }}</div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Total Maintenance This Month</p>
                    </div>
                </div>

                {{-- Total Verified --}}
                <div
                    class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-1.5 bg-green-500 h-full rounded-l-3xl"></div>
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="text-4xl font-bold text-green-600">{{ $verified }}</div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Verified</p>
                    </div>
                </div>

                {{-- Total Unverified --}}
                <div
                    class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-1.5 bg-red-500 h-full rounded-l-3xl"></div>
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="text-4xl font-bold text-red-600">{{ $unverified }}</div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Unverified</p>
                    </div>
                </div>

                <div
                    class="card relative rounded-3xl bg-white dark:bg-zinc-800 p-5 shadow-sm hover:shadow-md border border-gray-100 dark:border-zinc-700 transition-all hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-1.5 bg-orange-500 h-full rounded-l-3xl"></div>
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="text-4xl font-bold text-orange-500">{{ $kendaraan->count() }}</div>
                        <p class="text-sm text-gray-500 dark:text-gray-300">Total Registered Vehicles</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik ApexCharts --}}
        <div
            class="card bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-2xl shadow-sm p-6 mb-10">
            <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                Monthly Maintenance Count Chart
            </h4>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-4">{{ $tahun }}</p>
            <div class="w-full">
                <div id="chartPerawatan" class="w-full"></div>
            </div>
        </div>


        {{-- Data Kendaraan Terbaru --}}
        <div
            class="card bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-2xl shadow-sm p-6 mb-10">
            <h4 class="font-semibold text-gray-800 dark:text-gray-200">Newest Vehicles</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Last 5 Reported Vehicles</p>

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
                                <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($v->tanggal)->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ApexCharts Library --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari Laravel
            const bulanLabel = {!! json_encode($bulanLabel) !!};
            const dataPerawatan = {!! json_encode($dataPerawatan) !!};

            // Konfigurasi ApexCharts
            const options = {
            series: [{
                name: 'Jumlah Perawatan',
                data: dataPerawatan
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                },
                fontFamily: 'inherit',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    columnWidth: '60%',
                    distributed: false,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val;
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"],
                    fontWeight: 600
                }
            },
            colors: ['#2077e2'],
            xaxis: {
                categories: bulanLabel,
                labels: {
                    style: {
                        colors: '#6b7280',
                        fontSize: '12px',
                        fontWeight: 500
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#6b7280',
                        fontSize: '12px'
                    },
                    formatter: function (val) {
                        return Math.floor(val);
                    }
                },
                axisBorder: {
                    show: false
                }
            },
            grid: {
                borderColor: '#e5e7eb',
                strokeDashArray: 4,
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 10
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#60a5fa'],
                    inverseColors: false,
                    opacityFrom: 0.95,
                    opacityTo: 0.85,
                    stops: [0, 100]
                }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return val + " perawatan";
                    }
                },
                style: {
                    fontSize: '12px',
                    fontFamily: 'inherit'
                }
            }
        };

            // Render chart
            const chart = new ApexCharts(document.querySelector("#chartPerawatan"), options);
            chart.render();
        });
    </script>
@endsection