import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaKurangMampu = toTypedSchema(
    z.object({
        anggota_keluarga_id: z.string(),
        pendapatan_per_hari: z.number().optional().nullable(),
        pendapatan_per_bulan: z.number().optional().nullable(),
        jumlah_tanggungan: z.string(),
        status_validasi: z.string(),
        keterangan: z.string().optional().nullable(),

    })
);

