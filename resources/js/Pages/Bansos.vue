<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Navbar from "@/components/public/Navbar.vue";

defineOptions({
    layout: PublicLayout,
});
</script>

<template>
    <Head title=" - Infografis Bantuan Sosial" />
    <div class="bg-gray-50 min-h-screen px-6 md:px-20 py-8 pt-15">
        <!-- Judul & Navigasi -->
        <div
            class="flex justify-between items-center flex-wrap gap-4 mt-6 mb-8"
        >
            <!-- Judul -->
            <h1 class="text-2xl font-bold text-[#E5A025]">
                INFOGRAFIS<br class="sm:hidden" />
                DESA JABUNG
            </h1>

            <!-- Navigasi Tab -->
            <div class="flex space-x-6">
                <a href="../infografis">
                    <div
                        class="flex items-center space-x-2 text-gray-500 hover:text-gray-800 pb-1 hover:border-b-2 hover:border-[#E5A025] transition"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5s-3 1.34-3 3 1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"
                            />
                        </svg>
                        <span class="font-medium">Penduduk</span>
                    </div>
                </a>

                <a href="../bansos">
                    <div
                        class="flex items-center space-x-2 text-gray-800 border-b-2 border-[#E5A025] pb-1 hover:text-[#E5A025] transition"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M20 6H4c-1.1 0-2 .9-2 2v11h2v-1h16v1h2V8c0-1.1-.9-2-2-2zm0 10H4V8h16v8zM6 10h5v5H6z"
                            />
                        </svg>
                        <span class="font-medium">Bansos</span>
                    </div>
                </a>
            </div>
        </div>
        <!-- section deskripsi -->
        <div class="flex justify-between items-start mt-8">
            <div class="max-w-md">
                <h2 class="text-[#2FB586] font-bold text-xl mb-2">
                    BANTUAN SOSIAL
                </h2>
                <p class="text-sm text-gray-700">
                    Memberikan informasi mengenai jumlah serta jenis bantuan
                    sosial yang diterima oleh masyarakat. Disini juga dapat
                    dilakukan pencarian pemenerima bantuan sosial dengan
                    memasukkan NIK pada kolom pencarian bantuan sosial.
                </p>
            </div>
        </div>

        <!-- Judul Section -->
        <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-8">
            Jumlah Penerima Bansos
        </h2>

        <!-- Grid Cards -->
        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-8">
            <div
                class="bg-white rounded-[20px] shadow px-6 py-4 flex items-center space-x-4"
            >
                <div class="text-center">
                    <p class="text-2xl font-bold text-[#233D34] leading-tight">
                        67
                    </p>
                    <p class="text-sm text-black -mt-1">Penduduk</p>
                </div>
                <p class="text-sm text-black">
                    mendapatkan bantuan <br />
                    <span class="font-bold">BPJS PBI Ketenagakerjaan</span>
                </p>
            </div>
            <div
                class="bg-white rounded-[20px] shadow px-6 py-4 flex items-center space-x-4"
            >
                <div class="text-center">
                    <p class="text-2xl font-bold text-[#233D34] leading-tight">
                        41
                    </p>
                    <p class="text-sm text-black -mt-1">Penduduk</p>
                </div>
                <p class="text-sm text-black">
                    mendapatkan bantuan <br />
                    <span class="font-bold">PKH</span>
                </p>
            </div>
            <div
                class="bg-white rounded-[20px] shadow px-6 py-4 flex items-center space-x-4"
            >
                <div class="text-center">
                    <p class="text-2xl font-bold text-[#233D34] leading-tight">
                        35
                    </p>
                    <p class="text-sm text-black -mt-1">Penduduk</p>
                </div>
                <p class="text-sm text-black">
                    mendapatkan bantuan <br />
                    <span class="font-bold">BPNT</span>
                </p>
            </div>
            <div
                class="bg-white rounded-[20px] shadow px-6 py-4 flex items-center space-x-4"
            >
                <div class="text-center">
                    <p class="text-2xl font-bold text-[#233D34] leading-tight">
                        0
                    </p>
                    <p class="text-sm text-black -mt-1">Penduduk</p>
                </div>
                <p class="text-sm text-black">
                    mendapatkan bantuan <br />
                    <span class="font-bold">PSTN</span>
                </p>
            </div>
            <div
                class="bg-white rounded-[20px] shadow px-6 py-4 flex items-center space-x-4"
            >
                <div class="text-center">
                    <p class="text-2xl font-bold text-[#233D34] leading-tight">
                        0
                    </p>
                    <p class="text-sm text-black -mt-1">Penduduk</p>
                </div>
                <p class="text-sm text-black">
                    mendapatkan bantuan <br />
                    <span class="font-bold">BLT 2024</span>
                </p>
            </div>
        </div>

        <!-- Input Cek Penerima -->
        <h2 class="text-xl font-bold text-[#E5A025] mb-3">
            Cek Penerima Bansos
        </h2>
        <div class="flex items-center w-full max-w">
            <input
                type="text"
                placeholder="Masukkan NIK Penerima Bansos"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#E5A025]"
            />
        </div>

        <!-- Tabel Penerima -->
        <div class="overflow-x-auto mt-6">
            <table
                class="min-w-full divide-y divide-gray-200 bg-white shadow rounded-lg overflow-hidden text-sm"
            >
                <thead
                    class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold"
                >
                    <tr>
                        <th class="px-6 py-3 text-center" rowspan="2">
                            Nama Penerima
                        </th>
                        <th class="px-6 py-3 text-center" rowspan="2">NIK</th>
                        <th class="px-6 py-3 text-center" colspan="2">PKH</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Periode</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-800">
                    <tr>
                        <td class="px-6 py-4 text-center">Supatmo</td>
                        <td class="px-6 py-4 text-center">44332211667788</td>
                        <td class="px-6 py-4 text-center">Sudah Diberikan</td>
                        <td class="px-6 py-4 text-center">Jan - Mar 2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
