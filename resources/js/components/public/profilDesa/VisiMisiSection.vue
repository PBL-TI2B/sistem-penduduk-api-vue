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
                <span>Visi & Misi</span>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Visi -->
            <div
                class="bg-white drop-shadow-md hover:drop-shadow-xl rounded-xl flex-grow flex flex-col md:w-1/2 text-center md:px-16 md:py-10 px-6 py-4"
            >
                <h2 class="text-xl md:text-2xl font-bold text-[#E5A025] mb-4">
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
                    <li>Mengembangkan potensi ekonomi dan budaya masyarakat</li>
                </ol>
            </div>
        </div>
    </section>
</template>
