<x-template-pdf>
    <style>
        .header-info {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            margin-bottom: 18px;
            padding: 0 20px;
        }
        .report-title {
            margin: 0;
            font-size: 19px;
            text-decoration: underline;
        }
        .report-year {
            font-size: 15px;
            margin: 0;
        }
        /* Table styling */
        .bantuan-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .bantuan-table th {
            border: 1px solid #000;
            padding: 6px;
            background: #eaeaea;
            color: #000;
        }
        .bantuan-table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .bantuan-table td.text-center {
            text-align: center;
        }
        .bantuan-table td.text-right {
            text-align: right;
        }
    </style>

    <!-- Judul Laporan -->
    <div style="text-align: center; margin-bottom: 18px;">
        <h2 class="report-title">LAPORAN DATA BANTUAN</h2>
        <p class="report-year">Tahun {{ date('Y') }}</p>
    </div>
    <div class="header-info">
        <span>Tanggal Export: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</span> <br>
        <span>Waktu Export: {{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
    </div>

    <!-- Tabel Data Bantuan -->
    <table class="bantuan-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bantuan</th>
                <th>Kategori</th>
                <th>Nominal (Rp.)</th>
                <th>Periode</th>
                <th>Lama Periode</th>
                <th>Instansi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bantuan as $i => $row)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ $row->nama_bantuan }}</td>
                <td>{{ $row->kategoriBantuan->kategori }}</td>
                <td class="text-right">{{ number_format($row->nominal, 0, ',', '.') }}</td>
                <td>{{ $row->periode }}</td>
                <td class="text-center">{{ $row->lama_periode }}</td>
                <td>{{ $row->instansi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    {{-- <div style="width:100%; margin-top:40px;">
        <div style="width:40%; float:right; text-align:center;">
            <p style="margin-bottom:60px;">[Nama Desa], {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
            <p style="margin-bottom:60px;">Kepala Desa</p>
            <br><br>
            <p style="margin:0; font-weight:bold; text-decoration:underline;">[NAMA KEPALA DESA]</p>
        </div>
        <div style="clear:both;"></div>
    </div> --}}
</x-template-pdf>
