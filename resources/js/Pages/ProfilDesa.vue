<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";

defineOptions({
    layout: PublicLayout,
});
</script>
<template>
    <Head title=" - Profil Desa" />
    <div class="bg-gray-50 min-h-screen px-6 md:px-20 py-8 pt-15">
        <!-- Profil Desa -->
        <section class="flex flex-col max-w-6xl mx-auto py-8">
            <h1 class="text-3xl font-bold text-[#E5A025] mt-6 mb-8">
                PROFIL DESA
            </h1>
            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-2 text-[#2FB586] mt-8">
                    DESKRIPSI
                </h2>
                <p class="text-sm md:text-lg text-gray-600 mb-2">
                    Desa Jabung adalah desa yang terletak di kecamatan Jabung,
                    Kabupaten Malang, Provinsi Jawa Timur. Website ini bertujuan
                    untuk menyediakan informasi seputar Desa Jabung.
                </p>
            </div>

            <h2 class="text-2xl font-bold mb-4 text-[#2FB586] mt-8">
                VISI DAN MISI
            </h2>
            <div class="flex flex-col md:flex-row gap-6 mb-8">
                <!-- Visi -->
                <div
                    class="bg-white drop-shadow-md hover:drop-shadow-xl rounded-xl flex-grow flex flex-col md:w-1/2 text-center md:px-16 md:py-10 px-6 py-4"
                >
                    <h2
                        class="text-xl md:text-2xl font-bold text-[#E5A025] mb-4"
                    >
                        Visi
                    </h2>
                    <p class="text-gray-600 text-sm md:text-lg flex-grow">
                        Desa Jabung mampu menjadi desa yang berprestasi dan
                        mewujudkan masyarakat sejahtera.
                    </p>
                </div>

                <!-- Misi -->
                <div
                    class="bg-white drop-shadow-md hover:drop-shadow-xl rounded-xl flex-grow flex flex-col md:w-1/2 md:px-16 md:py-10 px-6 py-4"
                >
                    <h2
                        class="text-xl md:text-2xl font-bold text-[#E5A025] mb-4 text-center"
                    >
                        Misi
                    </h2>
                    <ol
                        class="text-gray-600 text-sm md:text-lg list-decimal list-inside flex-grow text-left"
                    >
                        <li>Meningkatkan kualitas sumber daya manusia</li>
                        <li>Meningkatkan infrastruktur desa</li>
                        <li>Meningkatkan pelayanan publik</li>
                        <li>Melestarikan lingkungan hidup</li>
                        <li>
                            Mengembangkan potensi ekonomi dan budaya masyarakat
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Perangkat Desa -->
            <h2 class="text-2xl font-bold text-[#2FB586] mb-4 mt-10">
                PERANGKAT DESA
            </h2>
            <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"
            >
                <!-- Kartu Perangkat Desa -->
                <div
                    class="bg-green-800 w-64 h-84 rounded-xl shadow-xl hover:drop-shadow-xl text-center overflow-hidden"
                >
                    <img
                        src="@/images/kepala-desa.png"
                        class="w-64 h-64 object-cover"
                        alt="Foto"
                    />
                    <div class="py-4 px-2">
                        <div class="font-semibold text-white text-lg">
                            Wisnu Sadewa
                        </div>
                        <div class="text-sm text-white">Kepala Desa</div>
                    </div>
                </div>

                <!-- Duplikat kartu lainnya -->
                <div
                    class="bg-green-800 w-64 h-84 rounded-xl shadow-xl hover:drop-shadow-xl text-center overflow-hidden"
                >
                    <img
                        src="@/images/kepala-desa.png"
                        class="w-64 h-64 object-cover"
                        alt="Foto"
                    />
                    <div class="py-4 px-2">
                        <div class="font-semibold text-white text-lg">
                            Kamal
                        </div>
                        <div class="text-sm text-white">Staff</div>
                    </div>
                </div>

                <div
                    class="bg-green-800 w-64 h-84 rounded-xl shadow-xl hover:drop-shadow-xl text-center overflow-hidden"
                >
                    <img
                        src="@/images/kepala-desa.png"
                        class="w-64 h-64 object-cover"
                        alt="Foto"
                    />
                    <div class="py-4 px-2">
                        <div class="font-semibold text-white text-lg">
                            Kamal
                        </div>
                        <div class="text-sm text-white">Staff</div>
                    </div>
                </div>

                <div
                    class="bg-green-800 w-64 h-84 rounded-xl shadow-xl hover:drop-shadow-xl text-center overflow-hidden"
                >
                    <img
                        src="@/images/kepala-desa.png"
                        class="w-64 h-64 object-cover"
                        alt="Foto"
                    />
                    <div class="py-4 px-2">
                        <div class="font-semibold text-white text-lg">
                            Kamal
                        </div>
                        <div class="text-sm text-white">Staff</div>
                    </div>
                </div>

                <div
                    class="bg-green-800 w-64 h-84 rounded-xl shadow-xl hover:drop-shadow-xl text-center overflow-hidden"
                >
                    <img
                        src="@/images/kepala-desa.png"
                        class="w-64 h-64 object-cover"
                        alt="Foto"
                    />
                    <div class="py-4 px-2">
                        <div class="font-semibold text-white text-lg">
                            Kamal
                        </div>
                        <div class="text-sm text-white">Staff</div>
                    </div>
                </div>

                <div
                    class="bg-green-800 w-64 h-84 rounded-xl shadow-xl hover:drop-shadow-xl text-center overflow-hidden"
                >
                    <img
                        src="@/images/kepala-desa.png"
                        class="w-64 h-64 object-cover"
                        alt="Foto"
                    />
                    <div class="py-4 px-2">
                        <div class="font-semibold text-white text-lg">
                            Kamal
                        </div>
                        <div class="text-sm text-white">Staff</div>
                    </div>
                </div>

                <div
                    class="bg-green-800 w-64 h-84 rounded-xl shadow-xl hover:drop-shadow-xl text-center overflow-hidden"
                >
                    <img
                        src="@/images/kepala-desa.png"
                        class="w-64 h-64 object-cover"
                        alt="Foto"
                    />
                    <div class="py-4 px-2">
                        <div class="font-semibold text-white text-lg">
                            Kamal
                        </div>
                        <div class="text-sm text-white">Staff</div>
                    </div>
                </div>

                <!-- Tambah kartu lainnya seperti ini -->
            </div>

            <!-- Sejarah -->
            <div class="mb-6 mt-10">
                <h2 class="text-2xl font-bold text-[#2FB586] mb-4">
                    SEJARAH DESA JABUNG
                </h2>
                <p class="text-sm md:text-lg text-gray-600 mb-2">
                    Selamat Datang di Bumi Desa Jabung - Gantiwarno, Klaten.
                </p>
                <p class="text-sm md:text-lg text-gray-600 mb-2">
                    Desa Jabung terletak di Kecamatan Gantiwarno, Klaten, Jawa
                    Tengah. Jabung menjadi salah satu dari 16 desa di Kecamatan
                    Gantiwarno. Wilayahnya kini meliputi 28 RT dan 13 RW dengan
                    total jumlah pendudukan berdasarkan data tahun 2023 sebanyak
                    3.450 jiwa.
                </p>
                <p class="text-sm md:text-lg text-gray-600">
                    Desa Jabung menjadi salah satu pusat kegiatan pertanian di
                    kecamatan, dengan hasil pertanian seperti padi, jagung,
                    tembakau, dan palawija menjadi komoditas utama yang
                    dihasilkan oleh masyarakat setempat. Infrastruktur desa yang
                    baik serta akses jalan yang memadai juga mendukung mobilitas
                    dan distribusi hasil pertanian ke pasar-pasar di sekitar
                    wilayah Kabupaten Klaten.
                </p>
            </div>

            <!-- Batas Wilayah -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[#2FB586] mb-4 mt-8">
                    BATAS WILAYAH
                </h2>
                <p class="text-sm md:text-lg text-gray-600 mb-2">
                    Sebelah Utara: Desa Sukopuro
                </p>
                <p class="text-sm md:text-lg text-gray-600 mb-2">
                    Sebelah Selatan: Desa Kemiri
                </p>
                <p class="text-sm md:text-lg text-gray-600 mb-2">
                    Sebelah Timur: Desa Kemantren
                </p>
                <p class="text-sm md:text-lg text-gray-600 mb-2">
                    Sebelah Barat: Desa Sidomulyo
                </p>
            </div>

            <!-- Peta -->
            <div>
                <h2 class="text-2xl font-bold text-[#2FB586] mb-4 mt-8">
                    PETA DESA JABUNG
                </h2>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.1505088320144!2d110.6952871741805!3d-7.5531200924509175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a4ed723ad4cf3%3A0xb2e7432c2b5b95f8!2sJabung%2C%20Gantiwarno%2C%20Klaten%20Regency%2C%20Central%20Java!5e0!3m2!1sen!2sid!4v1714394585264!5m2!1sen!2sid"
                    width="100%"
                    height="100%"
                    style="border: 0; border-radius: 12px"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="shadow-lg w-full h-150"
                ></iframe>
            </div>
        </section>
    </div>
</template>
