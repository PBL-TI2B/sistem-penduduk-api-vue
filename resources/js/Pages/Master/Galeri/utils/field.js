export function getFields(userOptions = []) {
    return [
        {
            name: "judul",
            label: "Judul",
            placeholder: "Masukkan judul galeri",
            type: "text",
        },
        // {
        //     name: "slug",
        //     label: "Slug",
        //     placeholder: "Masukkan slug galeri",
        //     type: "text",
        // },
        {
            name: "thumbnail",
            label: "Thumbnail",
            placeholder: "Unggah thumbnail",
            type: "file",
            optional: true,
        },
        {
            name: "deskripsi",
            label: "Deskripsi",
            placeholder: "Masukkan deskripsi galeri",
            type: "textarea",
            optional: true,
        },
        {
            name: "tanggal_post",
            label: "Tanggal Post",
            type: "datetime",
        },
        {
            name: "url_media",
            label: "URL Media",
            placeholder: "Masukkan URL media",
            type: "text",
        },
        {
            name: "user_id",
            label: "User",
            type: "select",
            options: userOptions, // 👈 Isi dengan daftar user dari API
        },
    ];
}