import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaPenduduk = toTypedSchema(
    z.object({
        nik: z.string().length(16, "NIK harus 16 digit"),
        nama_lengkap: z.string().min(4, "Nama minimal 4 huruf"),
        foto: z.any().optional(),
        jenis_kelamin: z.enum(["L", "P"]),
        tempat_lahir: z.string().min(1),
        tanggal_lahir: z.string(),
        agama: z.string(),
        gol_darah: z.string().optional(),
        status_perkawinan: z.string(),
        tinggi_badan: z.string().nullable().optional(),
        status: z.string(),
        pekerjaan_id: z.string(),
        pendidikan_id: z.string(),
    })
);
