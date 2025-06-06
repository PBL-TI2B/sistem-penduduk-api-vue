export function getFields() {
    return [
        {
            name: "judul",
            label: "Judul",
            placeholder: "Masukkan judul berita",
            type: "text",
        },
        {
            name: "thumbnail",
            label: "Thumbnail",
            placeholder: "Upload thumbnail (opsional)",
            type: "file",
        },
        {
            name: "konten",
            label: "Konten",
            placeholder: "Tulis isi berita",
            type: "textarea",
        },
        {
            name: "status",
            label: "Status",
            placeholder: "Pilih status",
            type: "select",
            options: [
                { label: "Draft", value: "draft" },
                { label: "Publish", value: "publish" },
            ],
        },
    ];
}