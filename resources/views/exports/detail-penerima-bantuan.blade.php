<x-template-pdf>
    <h2 class="title">Detail Penerima Bantuan</h2>

    <h3>Informasi Penerima</h3>
    <table class="report-table">
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ optional($penerimaBantuan->kurangMampu->anggotaKeluarga->penduduk)->nama_lengkap ?? 'Data Hilang' }}
            </td>
        </tr>
        <tr>
            <th>NIK</th>
            <td>{{ optional($penerimaBantuan->kurangMampu->anggotaKeluarga->penduduk)->nik ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Tanggungan</th>
            <td>{{ optional($penerimaBantuan->kurangMampu)->jumlah_tanggungan ?? 'N/A' }}</td>
        </tr>
    </table>

    <h3>Informasi Bantuan</h3>
    <table class="report-table">
        <tr>
            <th>Nama Bantuan</th>
            <td>{{ optional($penerimaBantuan->bantuan)->nama_bantuan ?? 'Bantuan Dihapus' }}</td>
        </tr>
        <tr>
            <th>Kategori Bantuan</th>
            <td>{{ optional($penerimaBantuan->bantuan->kategoriBantuan)->kategori ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Periode</th>
            <td>{{ optional($penerimaBantuan->bantuan)->periode ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Lama Periode</th>
            <td>{{ optional($penerimaBantuan->bantuan)->lama_periode ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Status Penerima</th>
            <td>{{ Str::title($penerimaBantuan->status) }}</td>
        </tr>
        <tr>
            <th>Tanggal Pengajuan</th>
            <td>{{ \Carbon\Carbon::parse($penerimaBantuan->tanggal_penerimaan)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td>{{ $penerimaBantuan->keterangan ?? 'Tidak ada keterangan' }}</td>
        </tr>
    </table>

    <h3>Pencairan Bantuan</h3>
    <table class="report-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Status</th>
                <th>Tanggal Pencairan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penerimaBantuan->riwayatBantuan as $i => $riwayat)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ Str::title($riwayat->status) }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($riwayat->tanggal_penerimaan)->format('d-m-Y') }}</td>
                <td>{{ $riwayat->keterangan ?? 'Tidak ada keterangan' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada riwayat bantuan untuk ditampilkan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        <p>Total Pencairan Bantuan: {{ $penerimaBantuan->riwayat_bantuan_count }}</p>
    </div>
</x-template-pdf>
