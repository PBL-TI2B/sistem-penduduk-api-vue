<x-template-pdf>
    <h2 class="title">Data Penduduk Tahun {{ date('Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIK</th>
                <th>Tempat Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Pendidikan</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penduduk as $row)
            <tr>
                <td>{{ $row->nama_lengkap }}</td>
                <td>{{ $row->nik }}</td>
                <td>{{ $row->tempat_lahir }}, {{ \Carbon\Carbon::parse($row->tanggal_lahir)->format('d-m-Y') }}</td>
                <td>{{ $row->jenis_kelamin }}</td>
                <td>{{ $row->pendidikan?->jenjang ?? '-' }}</td>
                <td>{{ $row->pekerjaan?->nama_pekerjaan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-template-pdf>
