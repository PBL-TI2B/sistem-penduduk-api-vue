import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaPekerjaan = toTypedSchema(
    z.object({
        nama_pekerjaan: z.string(),
    })
);
