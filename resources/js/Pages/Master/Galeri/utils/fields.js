export function getFields(userOptions = []) {
    return [
        {
            name: "judul",
            label: "Judul",
            placeholder: "Masukkan judul galeri",
            type: "text",
        },
        {
            name: "url_media",
            label: "URL Media",
            placeholder: "Masukkan URL media",
            type: "text",
        }
    ];
}