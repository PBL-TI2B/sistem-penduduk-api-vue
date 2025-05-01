<script setup>
import { Button } from "@/components/ui/button";
import PublicLayout from "@/Layouts/PublicLayout.vue";

defineOptions({
    layout: PublicLayout,
});
</script>

<template>
    <Head title=" | Home" />
    <div class="bg-[#0E462B] text-gray-800">
        <!-- Hero Section -->
        <section
            class="relative bg-cover bg-center h-[500px] bg-[url('../../images/kantor-desa.png')]"
        >
            <div
                class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center items-center text-white text-center"
            >
                <h1 class="text-4xl font-semibold mb-2">Selamat Datang</h1>
                <p class="text-lg">
                    DESA JABUNG KECAMATAN GANTIWARNO KABUPATEN KLATEN
                </p>
                <p class="text-sm mt-2">
                    sumber informasi terbaru tentang pemerintahan Desa Jabung
                </p>
            </div>
        </section>

        <!-- Statistik -->
        <div class="relative z-10 -mt-20">
            <div
                class="bg-[#192019] rounded-[50px] px-8 py-6 max-w-5xl mx-auto flex justify-around items-center text-white shadow-lg"
            >
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-500">1.152</div>
                    <div class="text-sm mt-1">Penduduk</div>
                </div>
                <div class="border-l border-gray-400 h-8 mx-4"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-500">304</div>
                    <div class="text-sm mt-1">Kepala Keluarga</div>
                </div>
                <div class="border-l border-gray-400 h-8 mx-4"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-500">607</div>
                    <div class="text-sm mt-1">Laki-laki</div>
                </div>
                <div class="border-l border-gray-400 h-8 mx-4"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-500">547</div>
                    <div class="text-sm mt-1">Perempuan</div>
                </div>
            </div>
        </div>

        <!-- Sambutan Kepala Desa -->
        <section
            class="bg-green-800 text-white mt-16 mx-4 md:mx-48 mb-8 p-4 rounded-lg"
        >
            <div
                class="container mx-auto grid md:grid-cols-2 gap-2 items-center"
            >
                <!-- Foto Kepala Desa -->
                <div class="flex justify-center md:justify-start ml-16">
                    <img
                        src="../../images/kepala-desa.png"
                        alt="Kepala Desa"
                        class="w-64 h-64 rounded-full object-cover"
                    />
                </div>

                <!-- Teks Sambutan -->
                <div class="pl-4 pr-4">
                    <!-- Menambahkan padding kiri -->
                    <h2 class="text-2xl font-bold mb-4 text-yellow-500">
                        Sambutan Kepala Desa
                    </h2>
                    <p class="font-bold">WISNU SADEWA</p>
                    <p class="mb-4">Kepala Desa Jabung</p>
                    <p class="text-sm font-bold">Assalamualaikum Wr. Wb.</p>
                    <p class="text-sm">
                        Website ini hadir sebagai wujud transformasi desa Jabung
                        menjadi desa yang mampu memanfaatkan teknologi informasi
                        dan komunikasi, terintegrasi kedalam sistem online.
                        Keterbukaan informasi publik, pelayanan publik, dan
                        kegiatan perekonomian di desa guna mewujudkan desa
                        Jabung sebagai desa wisata berkelanjutan, adaptasi dan
                        mitigasi terhadap perubahan iklim serta menjadi desa
                        yang mandiri.
                    </p>
                </div>
            </div>
        </section>

        <!-- Section Visi Misi -->
        <section class="max-w-6xl mx-auto mt-8 px-4">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Visi -->
                <div class="bg-green-800 rounded-lg shadow-lg p-6 flex-1">
                    <h2 class="text-2xl font-bold text-yellow-500 mb-4">
                        Visi
                    </h2>
                    <p class="text-white">
                        Desa Jabung mampu menjadi desa yang berprestasi dan
                        mewujudkan masyarakat sejahtera.
                    </p>
                </div>

                <!-- Misi -->
                <div class="bg-green-800 rounded-lg shadow-lg p-6 flex-1">
                    <h2 class="text-2xl font-bold text-yellow-500 mb-4">
                        Misi
                    </h2>
                    <ul class="list-disc list-inside text-white space-y-2">
                        <li>Mewujudkan tata kelola pemerintahan yang baik</li>
                        <li>Meningkatkan pelayanan publik</li>
                        <li>
                            Meningkatkan kualitas SDM dan sumber daya manusia
                        </li>
                        <li>Meningkatkan ketahanan ekonomi</li>
                        <li>Meningkatkan kualitas lingkungan hidup</li>
                        <li>Meningkatkan fasilitas kesehatan masyarakat</li>
                        <li>
                            Meningkatkan perekonomian dan kesejahteraan
                            masyarakat
                        </li>
                        <li>Memperkuat kerja sama dan sinergi</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Struktur Organisasi -->
        <section class="mx-auto mt-16 px-4">
            <h2 class="text-2xl font-bold text-center mb-6 text-yellow-500">
                Struktur Organisasi Pemerintahan Desa
            </h2>

            <div
                id="scrolling-wrapper"
                class="flex whitespace-nowrap gap-4 pb-4"
            >
                <!-- item -->
                <div
                    class="flex-shrink-0 w-64 bg-green-800 rounded-lg shadow-lg text-center"
                >
                    <img
                        src="../../images/kepala-desa.png"
                        class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                        alt="Foto"
                    />
                    <div class="font-semibold text-white">Wisnu Sadewa</div>
                    <div class="text-sm text-white mb-2">Kepala Desa</div>
                </div>

                <div
                    class="flex-shrink-0 w-64 bg-green-800 rounded-lg shadow-lg text-center"
                >
                    <img
                        src="../../images/kepala-desa.png"
                        class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                        alt="Foto"
                    />
                    <div class="font-semibold text-white">Kamal</div>
                    <div class="text-sm text-white mb-2">Staff</div>
                </div>

                <div
                    class="flex-shrink-0 w-64 bg-green-800 rounded-lg shadow-lg text-center"
                >
                    <img
                        src="../../images/kepala-desa.png"
                        class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                        alt="Foto"
                    />
                    <div class="font-semibold text-white">Kamal</div>
                    <div class="text-sm text-white mb-2">Staff</div>
                </div>

                <div
                    class="flex-shrink-0 w-64 bg-green-800 rounded-lg shadow-lg text-center"
                >
                    <img
                        src="../../images/kepala-desa.png"
                        class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                        alt="Foto"
                    />
                    <div class="font-semibold text-white">Kamal</div>
                    <div class="text-sm text-white mb-2">Staff</div>
                </div>

                <div
                    class="flex-shrink-0 w-64 bg-green-800 rounded-lg shadow-lg text-center"
                >
                    <img
                        src="../../images/kepala-desa.png"
                        class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                        alt="Foto"
                    />
                    <div class="font-semibold text-white">Kamal</div>
                    <div class="text-sm text-white mb-2">Staff</div>
                </div>

                <div
                    class="flex-shrink-0 w-64 bg-green-800 rounded-lg shadow-lg text-center"
                >
                    <img
                        src="../../images/kepala-desa.png"
                        class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                        alt="Foto"
                    />
                    <div class="font-semibold text-white">Kamal</div>
                    <div class="text-sm text-white mb-2">Staff</div>
                </div>

                <div
                    class="flex-shrink-0 w-64 bg-green-800 rounded-lg shadow-lg text-center"
                >
                    <img
                        src="../../images/kepala-desa.png"
                        class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                        alt="Foto"
                    />
                    <div class="font-semibold text-white">Kamal</div>
                    <div class="text-sm text-white mb-2">Staff</div>
                </div>

                <!-- Tambahin sebanyak apapun -->
            </div>
        </section>

        <!-- Berita Desa -->
        <div class="bg-gray-100 mt-8 pt-8 pb-8">
            <div class="mx-auto px-4 pl-16 pr-16">
                <!-- Header judul + tombol -->
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold">Berita Desa</h2>
                    <a
                        href="../../pages/berita"
                        class="inline-block bg-[#0E462B] hover:bg-[#0E462B] text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 text-sm"
                    >
                        Jelajahi Berita Desa
                    </a>
                </div>

                <!-- Konten 2 kolom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Berita besar -->
                    <div
                        class="rounded p-4 flex flex-col items-left text-left pl-24"
                    >
                        <img
                            src="../../images/berita-utama.png"
                            class="mb-4 rounded max-w-md w-full"
                            alt="Berita"
                        />
                        <h3 class="font-semibold text-lg mb-2">
                            Pemerintah Desa Jabung melakukan bagi baksos
                        </h3>
                        <p class="text-sm text-gray-500">2 Februari 2025</p>
                        <p class="text-sm">
                            Pemerintah Desa Jabung baru ini melakukan bagi
                            baksos bagi keluarga terdaftar pada xxxxx xxxxx xxxx
                            xxxxxxx Selain pembagian makanan, acara ini juga
                            menjadi ajang sosialisasi pentingnya perilaku hidup
                            bersih dan sehat.
                        </p>
                    </div>

                    <!-- List berita kecil -->
                    <div class="flex flex-col gap-4">
                        <div class="flex gap-4 p-2 rounded items-left">
                            <img
                                src="../../images/berita-lain.png"
                                class="w-24 h-24 object-cover rounded"
                                alt="Berita kecil"
                            />
                            <div>
                                <h4 class="font-semibold text-sm">
                                    Pemerintah Desa Jabung melakukan bagi baksos
                                </h4>
                                <p class="text-xs text-gray-500">
                                    2 Februari 2025
                                </p>
                                <p class="text-sm">
                                    Pemerintah Desa Jabung baru ini melakukan
                                    bagi baksos bagi keluarga terdaftar pada...
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4 p-2 rounded items-left">
                            <img
                                src="../../images/berita-lain.png"
                                class="w-24 h-24 object-cover rounded"
                                alt="Berita kecil"
                            />
                            <div>
                                <h4 class="font-semibold text-sm">
                                    Pemerintah Desa Jabung melakukan bagi baksos
                                </h4>
                                <p class="text-xs text-gray-500">
                                    2 Februari 2025
                                </p>
                                <p class="text-sm">
                                    Pemerintah Desa Jabung baru ini melakukan
                                    bagi baksos bagi keluarga terdaftar pada...
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4 p-2 rounded items-left">
                            <img
                                src="../../images/berita-lain.png"
                                class="w-24 h-24 object-cover rounded"
                                alt="Berita kecil"
                            />
                            <div>
                                <h4 class="font-semibold text-sm">
                                    Pemerintah Desa Jabung melakukan bagi baksos
                                </h4>
                                <p class="text-xs text-gray-500">
                                    2 Februari 2025
                                </p>
                                <p class="text-sm">
                                    Pemerintah Desa Jabung baru ini melakukan
                                    bagi baksos bagi keluarga terdaftar pada...
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Galeri Desa -->
        <div class="bg-gray-100 pb-20 relative">
            <div class="flex items-center justify-between pr-16 mb-8">
                <h2 class="text-2xl font-bold mb-4 pl-16">Galeri Desa</h2>
                <a
                    href="../../pages/galeri"
                    class="inline-block text-sm bg-[#0E462B] hover:bg-[#0E462B] text-white font-semibold py-2 px-4 rounded-lg transition"
                >
                    Jelajahi Galeri Desa
                </a>
            </div>
        </div>

        <!-- Masonry Grid -->
        <section class="bg-[#0E462B] pt-64 pb-20">
            <div
                class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4 px-4"
            >
                <img
                    src="../../images/kepala-desa.png"
                    alt="Galeri 1"
                    class="w-full rounded-lg object-cover"
                />
                <img
                    src="../../images/kantor-desa.png"
                    alt="Galeri 2"
                    class="w-full rounded-lg object-cover"
                />
                <img
                    src="../../images/berita-utama.png"
                    alt="Galeri 3"
                    class="w-full rounded-lg object-cover"
                />
                <img
                    src="../../images/kepala-desa.png"
                    alt="Galeri 4"
                    class="w-full rounded-lg object-cover"
                />
                <img
                    src="../../images/berita-lain.png"
                    alt="Galeri 5"
                    class="w-full rounded-lg object-cover"
                />
                <img
                    src="../../images/kantor-desa.png"
                    alt="Galeri 6"
                    class="w-full rounded-lg object-cover"
                />
                <img
                    src="../../images/kepala-desa.png"
                    alt="Galeri 5"
                    class="w-full rounded-lg object-cover"
                />
                <img
                    src="../../images/kantor-desa.png"
                    alt="Galeri 6"
                    class="w-full rounded-lg object-cover"
                />
                <!-- Tambahkan lebih banyak gambar -->
            </div>
        </section>

        <!-- Sejarah Desa -->
        <div class="py-12">
            <div class="mx-auto px-4 md:px-24">
                <h2 class="text-2xl font-bold text-yellow-500 mb-6">
                    Sejarah Desa Jabung
                </h2>
                <p class="text-sm text-white">
                    Selamat Datang di Bumi Desa Jabung - Gantiwarno, Klaten.
                </p>
                <p class="text-sm text-white">
                    Desa Jabung terletak di Kecamatan Gantiwarno, Klaten, Jawa
                    Tengah. Jabung menjadi salah satu dari 16 desa di Kecamatan
                    Gantiwarno. Wilayahnya kini meliputi 28 RT dan 13 RW dengan
                    total jumlah pendudukan berdasarkan data tahun 2023 sebanyak
                    3.450 jiwa.
                </p>
                <p class="text-sm text-white">
                    Desa Jabung menjadi salah satu pusat kegiatan pertanian di
                    kecamatan, dengan hasil pertanian seperti padi, jagung,
                    tembakau, dan palawija menjadi komoditas utama yang
                    dihasilkan oleh masyarakat setempat. Infrastruktur desa yang
                    baik serta akses jalan yang memadai juga mendukung mobilitas
                    dan distribusi hasil pertanian ke pasar-pasar di sekitar
                    wilayah Kabupaten Klaten.
                </p>
            </div>
        </div>
    </div>
</template>
