import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaPenerimaBantuan = toTypedSchema(
    z.object({
        nama_penduduk: z.string(),
        nama_bantuan: z.string(),
        tanggal_penerimaan: z.date(),
        keterangan: z.string().optional().nullable(),
    })
);

