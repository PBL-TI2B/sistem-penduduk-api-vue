import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaGaleri = toTypedSchema(
    z.object({
        judul: z.string().min(3, "Judul minimal 3 karakter"),
        // slug: z.string().min(3, "Slug minimal 3 karakter"),
        thumbnail: z.any().optional(), // Thumbnail opsional
        deskripsi: z.string().optional(), // Deskripsi opsional
        tanggal_post: z.string().refine(
            (val) => !isNaN(Date.parse(val)),
            "Tanggal post tidak valid"
        ),
        url_media: z.string().url("URL media harus berupa URL yang valid"),
        user_id: z.string().nonempty("User harus dipilih"),
    })
);