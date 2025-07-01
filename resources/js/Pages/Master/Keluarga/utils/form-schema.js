import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";
import { useErrorHandler } from "@/composables/useErrorHandler";
import { apiGet } from "@/utils/api";

// [DIUBAH] Bukan lagi 'const', tapi sebuah fungsi 'createFormSchema'
export const createFormSchema = (uuidToIgnore = null) => {
    return toTypedSchema(
        z.object({
            nomor_kk: z
                .string()
                .min(16, "Nomor KK harus 16 digit")
                .max(16, "Nomor KK harus 16 digit"),
                // .refine(
                //     async (nomor_kk) => {
                //         if (nomor_kk.length !== 16) return true;

                //         try {
                //             // [FIX] Bangun URL secara dinamis
                //             let url = `/kartu-keluarga/check-kk?nomor_kk=${nomor_kk}`;

                //             // Jika kita sedang mengedit (uuidToIgnore ada isinya), tambahkan parameter ignore
                //             if (uuidToIgnore) {
                //                 url += `&ignore_uuid=${uuidToIgnore}`;
                //             }

                //             const response = await apiGet(url);
                //             // [FIX] Akses langsung ke response, bukan response.data
                //             // Sesuaikan ini jika struktur response Anda berbeda
                //             return response.isAvailable;
                //         } catch (error) {
                //             useErrorHandler(error);
                //             return false;
                //         }
                //     },
                //     {
                //         message: "Nomor KK sudah terdaftar",
                //     }
                // ),

            // ... sisa field tidak berubah ...
            rt_id: z.string().min(1, "RT harus dipilih."),
            kode_pos: z.string().min(1, "Kode Pos wajib diisi."),
            kelurahan: z.string().min(1, "Kelurahan wajib diisi."),
            kecamatan: z.string().min(1, "Kecamatan wajib diisi."),
            kabupaten: z.string().min(1, "Kabupaten wajib diisi."),
            provinsi: z.string().min(1, "Provinsi wajib diisi."),
        })
    );
};
