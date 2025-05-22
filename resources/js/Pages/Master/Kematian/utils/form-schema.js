import * as z from "zod";

export const formSchemaKematian = z.object({
  penduduk_id: z.string().min(1, "Penduduk wajib dipilih"),
  tanggal_kematian: z.string().min(1, "Tanggal kematian wajib diisi"),
  sebab: z.string().min(1, "Sebab kematian wajib diisi"),
  tempat_kematian: z.string().min(1, "Tempat kematian wajib diisi"),
});
