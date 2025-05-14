<x-template-pdf>
    <h2 class="title">Data Pendidikan Penduduk Tahun {{ date('Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>Jenjang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendidikan as $row)
            <tr>
                <td>{{ $row->jenjang }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-template-pdf>
