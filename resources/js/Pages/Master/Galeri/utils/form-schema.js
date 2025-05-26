import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaGaleri = toTypedSchema(
    z.object({
        judul: z.string().min(1, "Judul harus diisi"),
        url_media: z.any().optional(), // URL media bisa kosong
    })
);