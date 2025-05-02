<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import { onMounted, ref } from "vue";

defineOptions({
    layout: PublicLayout,
});

const isScrolled = ref(0);
const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
    if (isScrolled.value) {
        document.querySelector("nav").classList.add("bg-[#1a1a1a]");
    } else {
        document.querySelector("nav").classList.remove("bg-[#1a1a1a]");
    }
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    handleScroll();
});
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Italianno&display=swap");

.italianno-regular {
    font-family: "Italianno", cursive;
    font-weight: 400;
    font-style: normal;
}
</style>

<template>
    <Head title=" - Beranda" />
    <div class="bg-[#0E462B] text-gray-800">
        <!-- Hero Section -->
        <section
            class="relative bg-cover bg-center h-[420px] sm:h-[540px] md:h-[760px] lg:h-[900px]"
            style="background-image: url('/images/kantor-desa.png')"
        >
            <div class="absolute inset-0 bg-black opacity-40"></div>
            <div
                class="absolute inset-0 flex flex-col justify-start items-center text-white text-center"
            >
                <h1
                    class="mx-4 mt-28 sm:mt-52 md:mt-60 lg:mt-72 mb-2 text-6xl md:text-8xl italianno-regular"
                >
                    Selamat Datang
                </h1>
                <p class="mx-4 text-md md:text-3xl font-bold md:mx-2 mt-4">
                    DESA JABUNG KECAMATAN GANTIWARNO
                </p>
                <p class="mx-4 text-md md:text-3xl font-bold md:mx-4 mt-0">
                    KABUPATEN KLATEN
                </p>
                <p class="mx-4 text-sm md:text-2xl mt-2 md:mt-9 font-medium">
                    sumber informasi terbaru tentang pemerintahan Desa Jabung
                </p>
            </div>
        </section>

        <!-- Statistik -->
        <div class="relative z-10 -mt-60 mx-5">
            <div
                class="px-6 py-6 max-w-6xl mx-auto md:px-auto flex justify-center items-center text-white"
                style="
                    background-image: url('/images/ellipseStat.svg');
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center;
                    min-height: 475px;
                "
            >
                <div class="text-center mx-4">
                    <div
                        class="text-md sm:text-3xl lg:text-6xl font-bold text-yellow-500"
                    >
                        1.152
                    </div>
                    <div class="text-xs sm:text-xl lg:text-3xl mt-1">
                        Penduduk
                    </div>
                </div>
                <div
                    class="block border-l border-gray-400 h-16 sm:h-20 lg:h-40 md:mx-4"
                ></div>
                <div class="text-center mx-4">
                    <div
                        class="text-md sm:text-3xl lg:text-6xl font-bold text-yellow-500"
                    >
                        304
                    </div>
                    <div class="text-xs sm:text-xl lg:text-3xl mt-1">
                        Kepala Keluarga
                    </div>
                </div>
                <div
                    class="block border-l border-gray-400 h-16 sm:h-20 lg:h-40 md:mx-4"
                ></div>
                <div class="text-center mx-4">
                    <div
                        class="text-md sm:text-3xl lg:text-6xl font-bold text-yellow-500"
                    >
                        607
                    </div>
                    <div class="text-xs sm:text-xl lg:text-3xl mt-1">
                        Laki-laki
                    </div>
                </div>
                <div
                    class="block border-l border-gray-400 h-16 sm:h-20 lg:h-40 md:mx-4"
                ></div>
                <div class="text-center mx-4">
                    <div
                        class="text-md sm:text-3xl lg:text-6xl font-bold text-yellow-500"
                    >
                        547
                    </div>
                    <div class="text-xs sm:text-xl lg:text-3xl mt-1">
                        Perempuan
                    </div>
                </div>
            </div>
        </div>

        <!-- Sambutan Kepala Desa -->
        <section
            class="bg-green-800 mx-4 max-w-6xl lg:mx-auto -mt-36 sm:-mt-20 md:mt-8 lg:mt-10 text-white mb-3 lg:mb-5 rounded-xl lg:px-16 lg:py-10 px-6 py-4"
        >
            <div
                class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-4"
            >
                <!-- Teks Sambutan -->
                <div class="flex-1">
                    <!-- Menambahkan padding kiri -->
                    <h2
                        class="text-xl md:text-5xl font-semibold mb-4 text-yellow-500"
                    >
                        Sambutan Kepala Desa
                    </h2>
                    <p class="md:text-4xl font-bold">WISNU SADEWA</p>
                    <p class="mb-4 md:text-3xl">Kepala Desa Jabung</p>
                    <p class="text-sm md:text-lg font-bold">
                        Assalamualaikum Wr. Wb.
                    </p>
                    <p class="text-sm md:text-lg">
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

                <!-- Foto Kepala Desa -->
                <div class="flex justify-center md:justify-end">
                    <img
                        src="@/images/kepala-desa.png"
                        alt="Kepala Desa"
                        class="w-60 h-60 rounded-full object-cover"
                    />
                </div>
            </div>
        </section>

        <!-- Section Visi Misi -->
        <section
            class="mx-4 max-w-6xl lg:mx-auto rounded-xl flex flex-col md:flex-row gap-3 lg:gap-5"
        >
            <!-- Visi -->
            <div
                class="bg-green-800 rounded-xl flex-grow flex flex-col md:w-2/5 text-center md:px-16 md:py-10 px-6 py-4"
            >
                <h2 class="text-xl md:text-3xl font-bold text-yellow-500 mb-4">
                    Visi
                </h2>
                <p class="text-white md:text-lg flex-grow">
                    Desa Jabung mampu menjadi desa yang berprestasi dan
                    mewujudkan masyarakat sejahtera.
                </p>
            </div>

            <!-- Misi -->
            <div
                class="bg-green-800 rounded-xl flex-grow flex flex-col md:w-3/4 md:px-24 md:py-10 px-10 py-4"
            >
                <h2
                    class="text-xl md:text-3xl font-bold text-yellow-500 mb-4 text-center"
                >
                    Misi
                </h2>
                <ol
                    class="text-white md:text-lg list-decimal list-outsite flex-grow"
                >
                    <li>Mewujudkan tata kelola pemerintahan yang baik</li>
                    <li>Meningkatkan pelayanan publik</li>
                    <li>Meningkatkan kualitas SDM dan sumber daya manusia</li>
                    <li>Meningkatkan ketahanan ekonomi</li>
                    <li>Meningkatkan kualitas lingkungan hidup</li>
                    <li>Meningkatkan fasilitas kesehatan masyarakat</li>
                    <li>
                        Meningkatkan perekonomian dan kesejahteraan masyarakat
                    </li>
                    <li>Memperkuat kerja sama dan sinergi</li>
                </ol>
            </div>
        </section>

        <!-- Struktur Organisasi -->
        <section class="mx-4 max-w-6xl lg:mx-auto mt-10">
            <h2
                class="text-xl md:text-5xl font-bold text-start mb-6 text-yellow-500"
            >
                Struktur Organisasi Pemerintahan Desa
            </h2>

            <div class="relative overflow-x-auto">
                <div
                    id="scrolling-wrapper"
                    class="flex whitespace-nowrap gap-4 pb-4"
                >
                    <!-- item -->
                    <div
                        class="flex-shrink-0 w-64 bg-green-800 rounded-xl shadow-lg text-center"
                    >
                        <img
                            src="@/images/kepala-desa.png"
                            class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                            alt="Foto"
                        />
                        <div class="font-semibold text-white">Wisnu Sadewa</div>
                        <div class="text-sm text-white mb-2">Kepala Desa</div>
                    </div>

                    <div
                        class="flex-shrink-0 w-64 bg-green-800 rounded-xl shadow-lg text-center"
                    >
                        <img
                            src="@/images/kepala-desa.png"
                            class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                            alt="Foto"
                        />
                        <div class="font-semibold text-white">Kamal</div>
                        <div class="text-sm text-white mb-2">Staff</div>
                    </div>

                    <div
                        class="flex-shrink-0 w-64 bg-green-800 rounded-xl shadow-lg text-center"
                    >
                        <img
                            src="@/images/kepala-desa.png"
                            class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                            alt="Foto"
                        />
                        <div class="font-semibold text-white">Kamal</div>
                        <div class="text-sm text-white mb-2">Staff</div>
                    </div>

                    <div
                        class="flex-shrink-0 w-64 bg-green-800 rounded-xl shadow-lg text-center"
                    >
                        <img
                            src="@/images/kepala-desa.png"
                            class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                            alt="Foto"
                        />
                        <div class="font-semibold text-white">Kamal</div>
                        <div class="text-sm text-white mb-2">Staff</div>
                    </div>

                    <div
                        class="flex-shrink-0 w-64 bg-green-800 rounded-xl shadow-lg text-center"
                    >
                        <img
                            src="@/images/kepala-desa.png"
                            class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                            alt="Foto"
                        />
                        <div class="font-semibold text-white">Kamal</div>
                        <div class="text-sm text-white mb-2">Staff</div>
                    </div>

                    <div
                        class="flex-shrink-0 w-64 bg-green-800 rounded-xl shadow-lg text-center"
                    >
                        <img
                            src="@/images/kepala-desa.png"
                            class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                            alt="Foto"
                        />
                        <div class="font-semibold text-white">Kamal</div>
                        <div class="text-sm text-white mb-2">Staff</div>
                    </div>

                    <div
                        class="flex-shrink-0 w-64 bg-green-800 rounded-xl shadow-lg text-center"
                    >
                        <img
                            src="@/images/kepala-desa.png"
                            class="w-64 h-64 object-cover mr-0 mb-2 rounded-t-lg"
                            alt="Foto"
                        />
                        <div class="font-semibold text-white">Kamal</div>
                        <div class="text-sm text-white mb-2">Staff</div>
                    </div>

                    <!-- Tambahin sebanyak apapun -->
                </div>
            </div>
        </section>

        <!-- Berita Desa -->
        <section class="bg-gray-100 pt-5">
            <div class="mx-4 max-w-6xl lg:mx-auto">
                <!-- Header judul + tombol -->
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl md:text-5xl font-bold">Berita Desa</h2>
                    <a
                        href="../../pages/berita"
                        class="inline-block bg-[#0E462B] hover:bg-[#0E462B] text-white font-semibold py-2 px-4 rounded-xl shadow-md transition duration-300 text-sm"
                    >
                        Jelajahi Berita Desa
                    </a>
                </div>

                <!-- Konten 2 kolom -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <!-- Berita besar -->
                    <div class="rounded flex flex-col items-left text-left">
                        <img
                            src="@/images/berita-utama.png"
                            class="mb-4 rounded-xl w-full"
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
                    <div class="flex flex-col gap-4 justify-between">
                        <div class="flex gap-4 items-left">
                            <img
                                src="@/images/berita-lain.png"
                                class="w-32 h-20 md:w-64 md:h-36 object-cover rounded-sm md:rounded-lg"
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

                        <div class="flex gap-4 items-left">
                            <img
                                src="@/images/berita-lain.png"
                                class="w-32 h-20 md:w-64 md:h-36 object-cover rounded-sm md:rounded-lg"
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

                        <div class="flex gap-4 items-left">
                            <img
                                src="@/images/berita-lain.png"
                                class="w-32 h-20 md:w-64 md:h-36 object-cover rounded-sm md:rounded-lg"
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
        </section>

        <!-- Galeri Desa -->
        <section class="relative bg-gray-100 pb-12 pt-5">
            <div
                class="flex items-center justify-between mt-4 mb-8 mx-4 max-w-6xl lg:mx-auto"
            >
                <h2 class="text-xl md:text-5xl font-bold">Galeri Desa</h2>
                <a
                    href="../../pages/galeri"
                    class="inline-block text-sm bg-[#0E462B] hover:bg-[#0E462B] text-white font-semibold py-2 px-4 rounded-xl transition"
                >
                    Jelajahi Galeri Desa
                </a>
            </div>

            <!-- Video wrapper -->
            <div class="relative max-w-6xl mx-4 lg:mx-auto z-20 -bottom-1/2">
                <div class="relative w-full pb-[56.25%]">
                    <!-- Aspect ratio 16:9 -->
                    <iframe
                        class="absolute top-0 left-0 w-full h-full rounded-xl shadow-lg"
                        src="https://www.youtube.com/embed/dPRB8xE6RWA?si=EVSUnFHOKm1Uu25o"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </section>

        <!-- Masonry Grid -->
        <section
            class="bg-[#0E462B] pt-12 pb-8 md:pb-12 max-w-6xl mx-4 lg:mx-auto"
        >
            <div
                class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4"
            >
                <img
                    src="@/images/kepala-desa.png"
                    alt="Galeri 1"
                    class="w-full rounded-xl object-cover"
                />
                <img
                    src="@/images/kantor-desa.png"
                    alt="Galeri 2"
                    class="w-full rounded-xl object-cover"
                />
                <img
                    src="@/images/berita-utama.png"
                    alt="Galeri 3"
                    class="w-full rounded-xl object-cover"
                />
                <img
                    src="@/images/kepala-desa.png"
                    alt="Galeri 4"
                    class="w-full rounded-xl object-cover"
                />
                <img
                    src="@/images/berita-lain.png"
                    alt="Galeri 5"
                    class="w-full rounded-xl object-cover"
                />
                <img
                    src="@/images/kantor-desa.png"
                    alt="Galeri 6"
                    class="w-full rounded-xl object-cover"
                />
                <img
                    src="@/images/kepala-desa.png"
                    alt="Galeri 5"
                    class="w-full rounded-xl object-cover"
                />
                <img
                    src="@/images/kantor-desa.png"
                    alt="Galeri 6"
                    class="w-full rounded-xl object-cover"
                />
                <!-- Tambahkan lebih banyak gambar -->
            </div>
        </section>

        <!-- Sejarah Desa -->
        <section class="pb-6 md:pb-12 mx-4 max-w-6xl lg:mx-auto">
            <div class="container">
                <h2 class="text-xl md:text-5xl font-bold text-yellow-500 mb-6">
                    Sejarah Desa Jabung
                </h2>
                <p class="text-sm md:text-lg text-white mb-2">
                    Selamat Datang di Bumi Desa Jabung - Gantiwarno, Klaten.
                </p>
                <p class="text-sm md:text-lg text-white mb-2">
                    Desa Jabung terletak di Kecamatan Gantiwarno, Klaten, Jawa
                    Tengah. Jabung menjadi salah satu dari 16 desa di Kecamatan
                    Gantiwarno. Wilayahnya kini meliputi 28 RT dan 13 RW dengan
                    total jumlah pendudukan berdasarkan data tahun 2023 sebanyak
                    3.450 jiwa.
                </p>
                <p class="text-sm md:text-lg text-white">
                    Desa Jabung menjadi salah satu pusat kegiatan pertanian di
                    kecamatan, dengan hasil pertanian seperti padi, jagung,
                    tembakau, dan palawija menjadi komoditas utama yang
                    dihasilkan oleh masyarakat setempat. Infrastruktur desa yang
                    baik serta akses jalan yang memadai juga mendukung mobilitas
                    dan distribusi hasil pertanian ke pasar-pasar di sekitar
                    wilayah Kabupaten Klaten.
                </p>
            </div>
        </section>
    </div>
</template>
