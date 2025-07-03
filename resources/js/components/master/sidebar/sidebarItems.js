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
        to: "/admin/dashboard",
        roles: ["admin", "superadmin", "rt", "rw"],
    },
    {
        title: "Penduduk",
        icon: UsersRound,
        to: "/admin/penduduk",
        roles: ["rt", "rw"],
    },
    {
        title: "Master Penduduk",
        icon: UsersRound,
        roles: ["admin", "superadmin"],
        children: [
            {
                title: "Penduduk",
                to: "/admin/penduduk",
                roles: ["admin", "superadmin"],
            },
            {
                title: "Kematian",
                to: "/admin/kematian",
                roles: ["admin", "superadmin"],
            },
            {
                title: "Kelahiran",
                to: "/admin/kelahiran",
                roles: ["admin", "superadmin"],
            },
        ],
    },
    {
        title: "Perangkat Desa",
        icon: Network,
        to: "/admin/perangkat-desa",
        roles: ["superadmin"],
    },
    {
        title: "Keluarga",
        icon: IdCard,
        to: "/admin/keluarga",
        roles: ["admin", "superadmin", "rt", "rw"],
    },
    {
        title: "Data Desa",
        icon: MapPinHouse,
        to: "/admin/desa",
        roles: ["admin", "superadmin"],
    },
    {
        title: "Konten Web",
        icon: LayoutTemplate,
        children: [
            {
                title: "Berita",
                to: "/admin/berita",
            },
            {
                title: "Galeri",
                to: "/admin/galeri",
            },
        ],
        roles: ["admin", "superadmin"],
    },
    {
        title: "Pendidikan",
        icon: GraduationCap,
        to: "/admin/pendidikan",
        roles: ["admin", "superadmin", "rt", "rw"],
    },
    {
        title: "Pekerjaan",
        icon: BriefcaseBusiness,
        to: "/admin/pekerjaan",
        roles: ["admin", "superadmin", "rt", "rw"],
    },
    {
        title: "Master Bantuan",
        icon: Boxes,
        children: [
            {
                title: "Bantuan",
                to: "/admin/bantuan",
            },
            {
                title: "Kurang Mampu",
                to: "/admin/kurang-mampu",
            },
            {
                title: "Penerima Bantuan",
                to: "/admin/penerima-bantuan",
            },
        ],
        roles: ["admin", "superadmin", "rt", "rw"],
    },
    {
        title: "User",
        icon: UsersRound,
        to: "/admin/user",
        roles: ["admin", "superadmin"],
    },
];
