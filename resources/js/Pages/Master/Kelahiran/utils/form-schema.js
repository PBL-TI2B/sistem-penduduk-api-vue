import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaPenduduk = toTypedSchema(
    z.object({
        nik: z.string().length(16, "NIK harus 16 digit"),
        nama_lengkap: z.string().min(4, "Nama minimal 4 huruf"),
        foto: z.any().optional(),
        jenis_kelamin: z.enum(["L", "P"]),
        tempat_lahir: z.string().min(1, "Tempat lahir tidak boleh kosong"),
        tanggal_lahir: z.date("Tanggal lahir harus berupa tanggal valid"),
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

export const formSchemaKelahiran = toTypedSchema(
    z.object({
        anak_ke: z.number("Anak ke harus berupa angka"),
        berat: z.number().optional(),
        panjang: z.number().optional(),
        waktu_kelahiran: z.date().optional(),
        lokasi: z.string().optional(),
        keterangan: z.string().nullable().optional(),
    })
);
