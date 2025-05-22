import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaBantuan = toTypedSchema(
    z.object({
        nama_bantuan: z.string(),
        kategori_bantuan_id: z.string(),
        nominal: z.number().optional().nullable(),
        periode: z.string(),
        lama_periode: z.string(),
        instansi: z.string(),
        keterangan: z.string().optional().nullable(),
    })
);

export const formSchmemaKategori = toTypedSchema(
    z.object({
        kategori: z.string(),
        keterangan: z.string().optional(),
    })
);
