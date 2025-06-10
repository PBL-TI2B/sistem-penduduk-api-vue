import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaKartuKeluarga = toTypedSchema(
    z.object({
        no_kk: z.string(),
        rt_id: z.string(),
        kode_pos: z.string(),
        kecamatan: z.string(),
        kabupaten: z.string(),
        provinsi: z.string(),
    })
);
