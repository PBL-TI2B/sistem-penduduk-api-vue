import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaDusun = toTypedSchema(
    z.object({
        nama: z.string(),
        deskripsi: z.string(),
        lokasi: z.string(),
    })
);
