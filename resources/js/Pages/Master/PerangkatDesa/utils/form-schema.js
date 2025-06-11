import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaPerangkatDesa = toTypedSchema(
    z.object({
        penduduk_id: z.string(),
        jabatan_id: z.string(),
        periode_jabatan_id: z
            .string()
            .min(1, "Wajib diisi")
            .refine(
                (val) => {
                    // Validasi: boleh berupa angka (id dari select) atau format "2024 - 2029"
                    return /^\d+$/.test(val) || /^\d{4}\s*-\s*\d{4}$/.test(val);
                },
                {
                    message: "Harus ID atau format tahun seperti 2024 - 2029",
                }
            ),
        dusun_id: z.string(),
        desa_id: z.string(),
        status_keaktifan: z.string(),
        rt_id: z.string(),
        rw_id: z.string(),
    })
);

export const formSchmemaJabatan = toTypedSchema(
    z.object({
        jabatan: z.string(),
        keterangan: z.string().optional(),
    })
);
