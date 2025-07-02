<x-template-pdf>
    <h2 class="title">Data Penerima Bantuan Tahun {{ date('Y') }}</h2>
    <table class="report-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>NIK</th>
                <th>Nama Bantuan</th>
                <th>Status</th>
                <th>Tanggal Pengajuan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penerimaBantuan as $i => $row)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ optional(optional($row->kurangMampu)->anggotaKeluarga)->penduduk->nama_lengkap ?? 'Data Hilang' }}
                </td>
                <td class="text-center">
                    {{ optional(optional($row->kurangMampu)->anggotaKeluarga)->penduduk->nik ?? 'N/A' }}</td>
                <td>{{ optional($row->bantuan)->nama_bantuan ?? 'Bantuan Dihapus' }}</td>
                <td class="text-center">{{ Str::title($row->status) }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</x-template-pdf>