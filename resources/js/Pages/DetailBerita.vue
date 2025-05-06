<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import Navbar from "@/components/public/Navbar.vue";

defineOptions({
    layout: PublicLayout,
});
</script>

<template>
    <Head title=" - Detail Berita" />
    <div class="bg-gray-50 min-h-screen px-6 md:px-20 py-8 pt-15">
        <section class="container mx-auto py-8">
            <!-- Main content -->
            <main
                class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6 max-w-7xl mx-auto mt-4"
            >
                <!-- Artikel -->
                <article class="lg:col-span-2 space-y-4">
                    <h2 class="text-2xl font-semibold">
                        Pemerintah Desa Jabung Melakukan Bagi Sembako
                    </h2>
                    <p class="text-sm text-gray-500">Minggu, 7 Februari 2025</p>
                    <img
                        src="@/images/berita-lain.png"
                        class="w-full rounded-lg shadow"
                        alt="Berita"
                    />
                    <div class="space-y-3 text-justify text-sm md:text-lg">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Doloribus ea corporis quam tempore et. Odio
                            commodi et distinctio autem. Alias ut numquam. Esse
                            ex officiis vel excepturi!
                        </p>
                        <p>
                            Elit voluptates sed est exercitationem iusto
                            temporibus. Et molestiae repudiandae aut velit.
                            Dignissimos modi excepturi nobis architecto odio
                            explicabo.
                        </p>
                        <p>
                            Temporibus et deleniti laudantium ea ex. Molestiae
                            dolore alias et magni consequatur. Non architecto ea
                            explicabo aut ex error vero.
                        </p>
                        <p>
                            Maxime provident inventore soluta ut nam nam magni
                            occaecati. Ducimus ea corporis quam tempora et. Odit
                            omnis et iure facilis esse ullam. Aut sunt magni
                            eos. Esse qui officiis vel consequatur. Odio est qui
                            sunt blanditiis distinctio. Dolorem dolores et
                            numquam sed. Repellat placeat ea repellat.
                        </p>
                        <p>
                            Et voluptas eos aut exercitationem iusto temporibus
                            et. Molestiae repudiandae aut et vel. Dignissimos
                            modi necessitatibus temporibus doloremque sequi. Sed
                            quaerat ipsa vel fuga. Quia provident est
                            consequatur voluptatem sunt et eum. Dignissimos
                            dolores est ratione omnis. Ut sit vitae facere ad
                            voluptates.
                        </p>
                        <p>
                            Perferendis et harum esse a. Molestiae dolore alias
                            ut magni cumque. Non architecto eius explicabo ab
                            eum error vero ea. Voluptatem eligendi error
                            inventore qui sapiente consequatur ipsum enim.
                        </p>
                    </div>
                </article>

                <!-- Sidebar -->
                <aside class="space-y-4">
                    <h3
                        class="text-lg font-semibold border-b pb-2 text-[#E5A025]"
                    >
                        Berita Lainnya
                    </h3>
                    <div class="space-y-4">
                        <!-- Card -->
                        <div class="flex gap-4">
                            <img
                                src="@/images/berita-lain.png"
                                class="w-24 h-24 object-cover rounded"
                                alt=""
                            />
                            <div class="text-sm md:text-lg">
                                <p class="font-regular leading-snug">
                                    Pemerintah Desa Jabung melakukan bagi baksos
                                </p>
                                <p class="text-gray-500 text-xs">
                                    7 Februari 2025
                                </p>
                                <p class="text-gray-800 text-xs">
                                    Pemerintah Desa Jabung baru ini melakukan
                                    bagi baksos bagi keluarga terdaftar pada...
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <img
                                src="@/images/berita-lain.png"
                                class="w-24 h-24 object-cover rounded"
                                alt=""
                            />
                            <div class="text-sm md:text-lg">
                                <p class="font-regular leading-snug">
                                    Pemerintah Desa Jabung melakukan bagi baksos
                                </p>
                                <p class="text-gray-500 text-xs">
                                    7 Februari 2025
                                </p>
                                <p class="text-gray-800 text-xs">
                                    Pemerintah Desa Jabung baru ini melakukan
                                    bagi baksos bagi keluarga terdaftar pada...
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <img
                                src="@/images/berita-lain.png"
                                class="w-24 h-24 object-cover rounded"
                                alt=""
                            />
                            <div class="text-sm md:text-lg">
                                <p class="font-regular leading-snug">
                                    Pemerintah Desa Jabung melakukan bagi baksos
                                </p>
                                <p class="text-gray-500 text-xs">
                                    7 Februari 2025
                                </p>
                                <p class="text-gray-800 text-xs">
                                    Pemerintah Desa Jabung baru ini melakukan
                                    bagi baksos bagi keluarga terdaftar pada...
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </main>
        </section>
    </div>
</template>
