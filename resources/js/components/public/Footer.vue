<template>
    <footer class="bg-[#0B391D] text-white px-6 py-12 justify-between">
        <div class="max-w-7xl mx-auto flex flex-wrap gap-8 justify-center lg:justify-between">

            <!-- Logo & Alamat -->
            <div class="flex flex-col sm:flex-row sm:space-x-4 items-center sm:items-start text-center sm:text-left flex-none">
                <img src="@/images/logo.svg" alt="Logo Desa" class="h-32 mb-4 sm:mb-0" />
                <div>
                    <h2 class="font-semibold text-lg mb-2">Pemerintah Desa Jabung</h2>
                    <p class="text-sm leading-relaxed">
                        Desa Jabung, 57455<br />
                        Kecamatan Gantiwarno,<br />
                        Kabupaten Klaten, Jawa Tengah.
                    </p>
                </div>
            </div>

            <!-- Kontak -->
            <div class="flex flex-col space-y-4 text-sm items-center sm:items-start text-center sm:text-left flex-none">
                <div class="flex items-center space-x-2">
                    <span>📍</span>
                    <span>Jabung, Gantiwarno, Klaten</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span>✉️</span>
                    <span>jabung@desa.com</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span>📱</span>
                    <span>085866637740</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span>📷</span>
                    <span>desajabungklaten</span>
                </div>
            </div>

            <!-- Jelajahi -->
            <div class="flex flex-col items-center sm:items-start text-center sm:text-left flex-none">
                <h3 class="font-semibold mb-3 text-base">Jelajahi Juga</h3>
                <ul class="space-y-4 text-sm">
                    <li>
                        <a href="https://gantiwarno.klaten.go.id/" class="hover:underline">Website Kecamatan Gantiwarno</a>
                    </li>
                    <li>
                        <a href="https://klaten.go.id/" class="hover:underline">Website Kabupaten Klaten</a>
                    </li>
                </ul>
            </div>

  <!-- Peta Desa -->
  <div class="flex flex-col items-center sm:items-start text-center sm:text-left flex-none">
      <h3 class="font-semibold mb-3 text-base">Lokasi Desa</h3>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.1505088320144!2d110.6952871741805!3d-7.5531200924509175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a4ed723ad4cf3%3A0xb2e7432c2b5b95f8!2sJabung%2C%20Gantiwarno%2C%20Klaten%20Regency%2C%20Central%20Java!5e0!3m2!1sen!2sid!4v1714394585264!5m2!1sen!2sid"
        width="100%"
        height="150"
        style="border:0; border-radius: 12px;"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        class="shadow-lg w-full max-w-xs"
      ></iframe>
    </div>

  </div>

  <!-- Copyright -->
  <!-- <div class="mt-8 border-t border-gray-400 pt-4 text-center text-xs"> -->
  <div class="mt-8  pt-4 text-center text-xs">
    <p>&copy; Team-1 PBL 2025</p>
  </div>
</footer>
</template>
