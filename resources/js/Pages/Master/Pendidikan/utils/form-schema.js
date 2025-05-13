import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

export const formSchemaJenjang = toTypedSchema(
  z.object({
    jenjang: z
      .string()
      .min(2, "Jenjang pendidikan minimal 2 huruf")
      .max(255, "Jenjang pendidikan maksimal 255 huruf"),
  })
);
