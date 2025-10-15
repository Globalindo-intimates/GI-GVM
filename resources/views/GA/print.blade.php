<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM GI - GENERAL VEHICLE MAINTENANCE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 5mm;
            font-size: 9px;
        }

        .container {
            width: 100%;
            max-width: 297mm;
            margin: 0 auto;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .header-table td {
            border: 2px solid black;
            padding: 5px;
            vertical-align: middle;
        }

        .logo-cell {
            width: 15%;
            text-align: center;
        }

        .logo-cell img {
            height: 55px;
            max-width: 100%;
        }

        .title-cell {
            width: 55%;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }

        .doc-info-cell {
            width: 35%;
            padding: 0 !important;
        }

        .doc-info-table {
            width: 100%;
            border-collapse: collapse;
            height: 100%;
            border: none;
        }

        .doc-info-table td {
            text-align: left;
            border: none;
            border-bottom: 1px solid #000;
            padding: 2px 4px;
            font-size: 9pt;
        }

        .doc-info-table tr:last-child td {
            border-bottom: none;
        }

        .doc-info-cell table td:first-child {
            width: 25%;
            text-align: left;
            padding-right: 2px;
            white-space: nowrap;
        }

        /* Vehicle Info */
        .vehicle-info {
            text-align: left;
            font-size: 9pt;
            white-space: nowrap;
            width: 60%;
        }

        .vehicle-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .vehicle-info table td {
            padding: 1px 0;
        }

        .vehicle-info table td:first-child {
            width: 18%;
            font-weight: normal;
        }

        .month-header {
            text-align: right;
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 10px;
        }

        /* Main Table */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-bottom: 8px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid black;
            padding: 2px;
            text-align: center;
            height: 20px;
        }

        .main-table thead th {
            background-color: #d9d9d9;
            font-weight: bold;
            font-size: 10px;
        }

        .main-table tbody td:first-child {
            width: 25px;
            font-weight: bold;
        }

        .main-table tbody td:nth-child(2) {
            text-align: left;
            padding-left: 5px;
            width: 150px;
            font-size: 10px;
        }

        .main-table tbody td:not(:first-child):not(:nth-child(2)):not(:last-child) {
            width: 20px;
            font-size: 10px;
        }

        .main-table tbody td:last-child {
            width: 90px;
            text-align: left;
            padding-left: 5px;
            font-size: 8px;
        }

        .day-header {
            font-weight: bold;
            font-size: 9px;
        }

        /* Keterangan */
        .keterangan {
            margin-top: 5px;
            margin-bottom: 8px;
            font-size: 10px;
        }

        .keterangan p {
            margin-bottom: 1px;
            line-height: 1.3;
        }

        .keterangan strong {
            font-weight: bold;
        }

        /* Signature */
        .signature-section {
            margin-top: 10px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 20px;
        }

        .signature-title {
            font-weight: normal;
            margin-bottom: 50px;
            font-size: 10px;
        }

        .signature-name {
            border-top: 1px solid black;
            padding-top: 3px;
            display: inline-block;
            min-width: 180px;
            font-size: 10px;
        }

        /* Print Styles */
        @media print {
            body {
                padding: 3mm;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A4 landscape;
                margin: 5mm;
            }

            .container {
                page-break-inside: avoid;
            }
        }

        /* Button Print */
        .print-button {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
            font-weight: bold;
        }

        .print-button:hover {
            background-color: #2563eb;
        }

        /* Red background for X mark */
        .bg-red {
            background-color: #ff0000 !important;
        }
    </style>
</head>

<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ PRINT</button>

    <div class="container">
        <!-- Header -->
        <!-- Header -->
        <!-- Header -->
        <table class="header-table">
            <tr style="height: 30%;">
                <td style="width:15%; text-align:center;">
                    <img src="{{ asset('public/assets/images/logo/logo-gi-transparant.png') }}" alt="Logo"
                        style="height:55px; max-width:100%;">
                </td>
                <td style="width:55%; text-align:center; font-weight:bold; font-size:18px;">
                    FORM PERAWATAN KENDARAAN
                </td>
                <td class="doc-info-cell" style="width:30%;">
                    <table class="doc-info-table">
                        <tr>
                            <td class="label">No. Dok.</td>
                            <td>: FM-GA-023</td>
                        </tr>
                        <tr>
                            <td class="label">Revisi</td>
                            <td>: 01</td>
                        </tr>
                        <tr>
                            <td class="label">Tgl. Efektif</td>
                            <td>: 03-09-2024</td>
                        </tr>
                        <tr>
                            <td class="label">Halaman</td>
                            <td>: 1 dari 1</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Vehicle Info -->
        <div class="vehicle-info">
            <table>
                <tr>
                    <td>JENIS KENDARAAN</td>
                    <td>: {{ strtoupper($vehicle->merk ?? '-') }}</td>
                </tr>
                <tr>
                    <td>NO. KENDARAAN</td>
                    <td>: {{ strtoupper($vehicle->no_polisi ?? '-') }}</td>
                </tr>
            </table>
        </div>

        <div class="month-header">
            BULAN : {{ strtoupper($monthName) }} {{ $year }}
        </div>

        <!-- Main Table -->
        <table class="main-table">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">ITEM KONTROL</th>
                    <th colspan="{{ $daysInMonth }}">TANGGAL</th>
                    <th rowspan="2">KETERANGAN</th>
                </tr>
                <tr class="day-header">
                    @for ($d = 1; $d <= $daysInMonth; $d++)
                        <th>{{ $d }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($tableData as $index => $row)
                    @if($row['label'] !== 'Status')
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ strtoupper($row['label']) }}</td>
                            @for ($d = 1; $d <= $daysInMonth; $d++)
                                @php
                                    $val = $row['days'][$d] ?? '';
                                @endphp
                                <td class="{{ $val === '✖' ? 'bg-red' : '' }}">{{ $val }}</td>
                            @endfor
                            <td></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Keterangan -->
        <div class="keterangan" style="margin-bottom: 10px;">
            <p><strong>KETERANGAN :</strong></p>
            <p>✔ : Baik, Berfungsi, Hidup/ Nyala, Bersih</p>
            <p>✖ : Tidak baik, Rusak, Tidak Berfungsi, Tidak Nyala, Kotor</p>
        </div>

        <div style="font-size: 10px; margin-left: 220px;">
            Mengetahui,
        </div>

        <!-- Signature -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>
                        <div class="signature-title">Manager GA</div>
                        <div class="text">(...................................................)</div>
                    </td>
                    <td>
                        <div class="signature-title">Driver</div>
                        <div class="text">(...................................................)</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        // Auto print ketika halaman dimuat (optional)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>

</html>