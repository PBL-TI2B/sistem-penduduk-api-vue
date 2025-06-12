import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaPenduduk = toTypedSchema(
    z.object({
        nik: z.string().length(16, "NIK harus 16 digit"),
        nama_lengkap: z.string().min(4, "Nama minimal 4 huruf"),
        foto: z.any().optional(),
        jenis_kelamin: z.enum(["L", "P"]),
        tempat_lahir: z.string().min(1, "Tempat lahir tidak boleh kosong"),
        tanggal_lahir: z.preprocess((val) => {
            return typeof val === "string" ? new Date(val) : val;
        }, z.date({ required_error: "Tanggal lahir wajib diisi" })),
        agama: z.string("Agama harus diisi").min(1, "Agama tidak boleh kosong"),
        gol_darah: z.string().nullable().optional(),
        status_perkawinan: z
            .string("Status perkawinan harus diisi")
            .min(1, "Status perkawinan tidak boleh kosong"),
        tinggi_badan: z.string().nullable().optional(),
        status: z
            .string("Status harus diisi")
            .min(1, "Status tidak boleh kosong"),
        pekerjaan_id: z
            .string("Pekerjaan harus diisi")
            .min(1, "Pekerjaan tidak boleh kosong"),
        pendidikan_id: z
            .string("Pendidikan harus diisi")
            .min(1, "Pendidikan tidak boleh kosong"),
    })
);

export const formSchemaDomisili = toTypedSchema(
    z.object({
        status_tempat_tinggal: z.string(),
        rt_id: z.number(),
    })
);
