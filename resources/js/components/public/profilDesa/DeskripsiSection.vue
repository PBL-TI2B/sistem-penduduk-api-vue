<template>
    <section>
        <!-- Judul Halaman -->
        <div
            class="flex items-center gap-2 bg-[#e7fcee] text-green-700 font-semibold px-4 py-2 rounded-full w-fit mt-8 mb-4"
        >
            <div class="w-1 h-6 bg-green-500 rounded"></div>
            <div
                class="flex items-center gap-2 md:text-xl font-bold text-[#233D34]"
            >
                <span>Tentang Desa</span>
            </div>
        </div>

        <!-- Informasi & Kontak -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informasi Desa -->
            <div
                class="bg-white drop-shadow-md hover:drop-shadow-xl rounded-xl px-10 py-6"
            >
                <h3
                    class="text-xl md:text-2xl font-bold text-[#E5A025] mb-4 text-center"
                >
                    Informasi Desa
                </h3>
                <div
                    class="grid grid-cols-2 gap-6 text-sm md:text-base text-gray-600"
                >
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-gray-500">
                            <!-- Icon lokasi -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 20l-7-7-7 7"
                                />
                            </svg>
                            <p>Nama Desa</p>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">
                            Desa Jabung
                        </p>
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-gray-500">
                            <!-- Icon map -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 20l-5.447-2.724A2 2 0 013 15.382V5.618a2 2 0 011.553-1.894L9 1l6 3 6-3v10l-6 3-6-3"
                                />
                            </svg>
                            <p>Kecamatan</p>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">
                            Kecamatan Gantiwarno
                        </p>
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-gray-500">
                            <!-- Icon office -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 21v-8a2 2 0 012-2h2a2 2 0 012 2v8m4 0v-6a2 2 0 012-2h2a2 2 0 012 2v6m4 0v-10a2 2 0 00-2-2h-3.586a1 1 0 01-.707-.293l-1.414-1.414A2 2 0 0012.586 6H9a2 2 0 00-2 2v13"
                                />
                            </svg>
                            <p>Kabupaten</p>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">
                            Kabupaten Klaten
                        </p>
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-gray-500">
                            <!-- Icon globe -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 10l9-7 9 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10z"
                                />
                            </svg>
                            <p>Provinsi</p>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">
                            Jawa Tengah
                        </p>
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-gray-500">
                            <!-- Icon postal -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"
                                />
                            </svg>
                            <p>Kode Pos</p>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">57455</p>
                    </div>
                </div>
            </div>

            <!-- Kontak & Alamat -->
            <div
                class="bg-white drop-shadow-md hover:drop-shadow-xl rounded-xl px-10 py-6"
            >
                <h3
                    class="text-xl md:text-2xl font-bold text-[#E5A025] mb-4 text-center"
                >
                    Kontak & Alamat
                </h3>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm md:text-base text-gray-600"
                >
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-gray-500">
                            <!-- Phone Icon -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    stroke-width="2"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"
                                />
                            </svg>
                            <p>Telepon</p>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">
                            0xxxxxxxxxx0
                        </p>
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-gray-500">
                            <!-- Email icon -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"
                                />
                            </svg>
                            <p>Email</p>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">
                            desajabung@desa.com
                        </p>
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 text-gray-500">
                            <!-- Globe icon -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"
                                />
                            </svg>
                            <p>Website</p>
                        </div>
                        <a
                            href="https://desajabung"
                            target="_blank"
                            class="font-semibold text-gray-800 text-sm hover:underline"
                        >
                            https://desajabung
                        </a>
                    </div>

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <div class="flex items-center gap-2 text-gray-500">
                            <!-- Home icon -->
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 10l9-7 9 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10z"
                                />
                            </svg>
                            <p>Alamat Kantor Desa</p>
                        </div>
                        <p class="font-semibold text-gray-800 text-sm">
                            Jl. Ganti Warno, Gedongan, Gesikan, Kec. Gantiwarno,
                            Kabupaten Klaten, Jawa Tengah
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
