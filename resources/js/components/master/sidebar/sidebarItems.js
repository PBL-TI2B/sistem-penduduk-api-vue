import {
    LayoutDashboard,
    UsersRound,
    IdCard,
    Network,
    MapPinHouse,
    LayoutTemplate,
    GraduationCap,
    BriefcaseBusiness,
    Boxes,
} from "lucide-vue-next";

export const items = [
    {
        title: "Dashboard",
        icon: LayoutDashboard,
        to: "/dashboard",
    },
    {
        title: "Master Penduduk",
        icon: UsersRound,
        children: [
            {
                title: "Penduduk",
                to: "/penduduk",
            },
            {
                title: "Kematian",
                to: "/kematian",
            },
            {
                title: "Kelahiran",
                to: "/kelahiran",
            },
        ],
    },
    {
        title: "Perangkat Desa",
        icon: Network,
        to: "/perangkat-desa",
    },
    {
        title: "Keluarga",
        icon: IdCard,
        to: "/keluarga",
    },
    {
        title: "Data Desa",
        icon: MapPinHouse,
        to: "/desa",
    },
    {
        title: "Konten Web",
        icon: LayoutTemplate,
        children: [
            {
                title: "Berita",
                to: "/berita",
            },
            {
                title: "Galeri",
                to: "/galeri",
            },
        ],
    },
    {
        title: "Pendidikan",
        icon: GraduationCap,
        to: "/pendidikan",
    },
    {
        title: "Pekerjaan",
        icon: BriefcaseBusiness,
        to: "/pekerjaan",
    },
    {
        title: "Bantuan",
        icon: Boxes,
        to: "/bantuan",
    },
];
