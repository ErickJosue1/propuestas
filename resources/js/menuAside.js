import {
  mdiAccountCircle,
  mdiMonitor,
  mdiGithub,
  mdiLock,
  mdiAlertCircle,
  mdiSquareEditOutline,
  mdiTable,
  mdiViewList,
  mdiTelevisionGuide,
  mdiResponsive,
  mdiPalette,
  mdiReact,
} from "@mdi/js";


export default [
  {
    href: "/dashboard",
    to: "/dashboard",
    icon: mdiMonitor,
    label: "Dashboard",
  },
 /*  {
    href: "/tables",
    to: "/tables",
    label: "Tables",
    icon: mdiTable,
  },
  {
    href: '/forms',
    to: "/forms",
    label: "Forms",
    icon: mdiSquareEditOutline,
  },
  {
    href: "/ui",
    to: "/ui",
    label: "UI",
    icon: mdiTelevisionGuide,
  },
  {
    href: "/responsive",
    to: "/responsive",
    label: "Responsive",
    icon: mdiResponsive,
  },
  {
    to: "/",
    href: "/",
    label: "Styles",
    icon: mdiPalette,
  },
  {
    href: "/profile",
    to: "/profile",
    label: "Profile",
    icon: mdiAccountCircle,
  },
  {
    to: "/login",
    label: "Login",
    icon: mdiLock,
  },
  {
    href: "/error",
    to: "/error",
    label: "Error",
    icon: mdiAlertCircle,
  }, */
  {
    label: "Admin",
    icon: mdiViewList,
    menu: [
      {
        label: "Instituciones",
        href: "/institutions",
        to: "/institutions",
      },
      {
        label: "Eventos",
        href: "/events",
        to: "/events",
      },
      {
        label: "Convocatorias",
        href: "/assesstment",
        to: "/assesstment",
      },
      {
        label: "Soporte a documentos",
        href: "/documents",
        to: "/documents",
      },
      {
        label: "Permisos",
        href: "/permissions",
        to: "/permissions",
      },
    ],
  },
  {
    href: "https://github.com/justboil/admin-one-vue-tailwind",
    label: "GitHub",
    icon: mdiGithub,
    target: "_blank",
  },
  {
    href: "https://github.com/justboil/admin-one-react-tailwind",
    label: "React version",
    icon: mdiReact,
    target: "_blank",
  },
];
