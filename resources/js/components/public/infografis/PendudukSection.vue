<template>
    <!-- Demografi Penduduk -->
    <h2 class="text-xl font-bold text-[#233D34] mb-4 mt-8">
        Jumlah Penduduk dan Kepala Keluarga
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-2 gap-4 text-white text-center">
        <div
            class="bg-[#40798C] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
        >
            <img
                src="@/images/ttlpenduduk.png"
                alt="Total Penduduk"
                class="w-12 h-12"
            />
            <div>
                <p class="text-sm md:text-lg">TOTAL PENDUDUK</p>
                <p class="text-xl font-bold">1.150 Jiwa</p>
            </div>
        </div>
        <div
            class="bg-[#70A9A1] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
        >
            <img
                src="@/images/kepalakeluarga.png"
                alt="Kepala Keluarga"
                class="w-12 h-12"
            />
            <div>
                <p class="text-sm md:text-lg">KEPALA KELUARGA</p>
                <p class="text-xl font-bold">304 Jiwa</p>
            </div>
        </div>
        <div
            class="bg-[#CD8B76] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
        >
            <img src="@/images/laki.png" alt="Laki-Laki" class="w-12 h-12" />
            <div>
                <p class="text-sm md:text-lg">LAKI-LAKI</p>
                <p class="text-xl font-bold">607 Jiwa</p>
            </div>
        </div>
        <div
            class="bg-[#734B5E] p-4 rounded-[20px] flex items-center gap-3 shadow-lg hover:drop-shadow-xl"
        >
            <img
                src="@/images/perempuan.png"
                alt="Perempuan"
                class="w-12 h-12"
            />
            <div>
                <p class="text-sm md:text-lg">PEREMPUAN</p>
                <p class="text-xl font-bold">543 Jiwa</p>
            </div>
        </div>
    </div>
</template>
