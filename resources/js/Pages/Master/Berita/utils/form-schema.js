import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaBerita = toTypedSchema(
    z.object({
        judul: z.string().min(1, "Judul harus diisi"),
        thumbnail: z.any().optional(), 
        konten: z.string().min(1, "Konten harus diisi"),
        tanggal_post: z.string().min(1, "Tanggal posting harus diisi"),
        status: z.enum(["draft", "publish"], { required_error: "Status harus dipilih" }),
    })
);