<x-template-pdf>
    <style>
        .bantuan-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            font-family: Arial, sans-serif;
        }

        .bantuan-table th,
        .bantuan-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .bantuan-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            color: #000;
            /* Set font color to black */
        }

        .bantuan-table td.text-center {
            text-align: center;
        }

        .bantuan-table td.text-right {
            text-align: right;
        }

        /* Optional: alternate row background */
        .bantuan-table tbody tr:nth-child(odd) {
            background-color: #fafafa;
        }

    </style>

    <!-- Judul Laporan -->
    <div style="text-align: center; margin-bottom: 18px;">
        <h2 class="report-title">LAPORAN DATA KURANG MAMPU</h2>
        <p class="report-year">Tahun {{ date('Y') }}</p>
    </div>
    <div class="header-info">
        <span>Tanggal Export: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</span> <br>
        <span>Waktu Export: {{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
    </div>

    <!-- Tabel Data Kurang Mampu -->
    <table class="bantuan-table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                {{-- <th>Jenis Kelamin</th> --}}
                {{-- <th>Tempat, Tanggal Lahir</th> --}}
                {{-- <th>Agama</th> --}}
                {{-- <th>Pekerjaan</th> --}}
                {{-- <th>Pendidikan</th> --}}
                <th>Status Validasi</th>
                <th>Pendapatan per Hari</th>
                <th>Pendapatan per Bulan</th>
                <th>Jumlah Tanggungan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kurangMampu as $i => $data)
            @php
            $penduduk = $data->anggotaKeluarga->penduduk ?? null;
            @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $penduduk->nik ?? '-' }}</td>
                <td>{{ $penduduk->nama_lengkap ?? '-' }}</td>
                {{-- <td>{{ $penduduk->jenis_kelamin ?? '-' }}</td>
                <td>{{ $penduduk->tempat_lahir ?? '-' }}, {{ $penduduk->tanggal_lahir ?? '-' }}</td>
                <td>{{ $penduduk->agama ?? '-' }}</td>
                <td>{{ $penduduk->pekerjaan->nama_pekerjaan ?? '-' }}</td>
                <td>{{ $penduduk->pendidikan->jenjang ?? '-' }}</td> --}}
                <td>{{ $data->status_validasi ?? '-' }}</td>
                <td class="text-right">{{ number_format($data->pendapatan_per_hari ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($data->pendapatan_per_bulan ?? 0, 0, ',', '.') }}</td>
                <td class="text-center">{{ $data->jumlah_tanggungan ?? 0 }}</td>
                <td>{{ $data->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ... (keep your existing footer or signature section) ... -->
</x-template-pdf>
