import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaPerangkatDesa = toTypedSchema(
    z.object({
        penduduk_id: z.string(),
        jabatan_id: z.string(),
        periode_jabatan_id: z.string(),
        dusun_id: z.string(),
        desa_id: z.string(),
        status_keaktifan: z
            .string()
            .oneOf(["aktif", "nonaktif"], "Status keaktifan tidak valid")
            .required("Status keaktifan harus diisi"),
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
