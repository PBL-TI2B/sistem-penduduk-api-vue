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
        roles: ["admin", "superadmin", "rt", "rw"],
    },
    {
        title: "Master Penduduk",
        icon: UsersRound,
        roles: ["admin", "superadmin"],
        children: [
            {
                title: "Penduduk",
                to: "/penduduk",
                roles: ["admin", "superadmin"],
            },
            {
                title: "Kematian",
                to: "/kematian",
                roles: ["admin", "superadmin"],
            },
            {
                title: "Kelahiran",
                to: "/kelahiran",
                roles: ["admin", "superadmin"],
            },
        ],
    },
    {
        title: "Perangkat Desa",
        icon: Network,
        to: "/perangkat-desa",
        roles: ["superadmin"],
    },
    {
        title: "Keluarga",
        icon: IdCard,
        to: "/keluarga",
        roles: ["admin", "superadmin", "rt", "rw"],
    },
    {
        title: "Data Desa",
        icon: MapPinHouse,
        to: "/desa",
        roles: ["admin", "superadmin"],
    },
    {
        title: "Konten Web",
        icon: LayoutTemplate,
        children: [
            {
                title: "Berita",
                to: "/berita-admin",
                roles: ["admin", "superadmin"],
            },
            {
                title: "Galeri",
                to: "/galeri-admin",
                roles: ["admin", "superadmin"],
            },
        ],
    },
    {
        title: "Pendidikan",
        icon: GraduationCap,
        to: "/pendidikan",
        roles: ["admin", "superadmin", "rt", "rw"],
    },
    {
        title: "Pekerjaan",
        icon: BriefcaseBusiness,
        to: "/pekerjaan",
        roles: ["admin", "superadmin", "rt", "rw"],
    },
    {
        title: "Master Bantuan",
        icon: Boxes,
        children: [
            {
                title: "Bantuan",
                to: "/bantuan",
            },
            {
                title: "Kurang Mampu",
                to: "/kurang-mampu",
            },
            {
                title: "Penerima Bantuan",
                to: "/penerima-bantuan",
            },
            // {
            //     title: "Kategori Bantuan",
            //     to: "/kategori-bantuan",
            // },
        ],
        roles: ["admin", "superadmin", "rt", "rw"],
    },
];
