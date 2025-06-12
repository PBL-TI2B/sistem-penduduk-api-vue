import { z } from "zod";

export const formSchemaKematian = z.object({
    penduduk_id: z.string().min(1, "Penduduk wajib dipilih"),
    tanggal_kematian: z.date(1, "Tanggal kematian wajib diisi"),
    sebab_kematian: z.string().min(1, "Sebab kematian wajib diisi"),
});
