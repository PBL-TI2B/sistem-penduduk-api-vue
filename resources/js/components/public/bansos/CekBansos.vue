<template>
    <section>
        <!-- Input Cek Bansos-->
        <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-10">
            Cari Informasi Bansos
        </h2>
        <div
            class="flex items-center w-full max-w shadow-sm hover:drop-shadow-lg"
        >
            <input
                type="text"
                placeholder="Masukkan Nama Bansos"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#E5A025]"
            />
        </div>
    </section>

    <section>
        <!-- Tabel Informasi Bansos -->
        <div class="overflow-x-auto mt-10 shadow-sm hover:drop-shadow-lg">
            <table
                class="min-w-full divide-y divide-gray-200 bg-white shadow rounded-lg overflow-hidden text-sm border border-gray-500"
            >
                <thead
                    class="bg-gray-100 text-gray-700 uppercase text-sm font-semibold"
                >
                    <tr>
                        <th class="px-6 py-3 text-center" rowspan="2">
                            Nama Bansos
                        </th>
                        <th class="px-6 py-3 text-center" rowspan="2">
                            Jenis Bantuan
                        </th>
                        <th class="px-6 py-3 text-center" colspan="3">
                            Periode
                        </th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Periode</th>
                        <th class="px-6 py-3 text-center">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-800 text-sm">
                    <tr>
                        <td class="px-6 py-4 text-center">PKH</td>
                        <td class="px-6 py-4 text-center">Uang Rp. 750.000</td>
                        <td class="px-6 py-4 text-center">Aktif</td>
                        <td class="px-6 py-4 text-center">Jan - Mar 2025</td>
                        <td class="px-6 py-4 text-center">3 bulan sekali</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>
