import {
  mdiMenu,
  mdiClockOutline,
  mdiCloud,
  mdiCrop,
  mdiAccount,
  mdiCogOutline,
  mdiEmail,
  mdiLogout,
  mdiThemeLightDark,
  mdiGithub,
  mdiReact,
} from "@mdi/js";

export default [
  {
    icon: mdiMenu,
    label: "Información",
    menu: [
      {
        icon: mdiClockOutline,
        label: "Calendario",
      },
      {
        icon: mdiCloud,
        label: "Cloud",
      },
      {
        isDivider: true,
      },
      {
        icon: mdiGithub,
        label: "Github",
      },
    ],
  },
  {
    isCurrentUser: true,
    menu: [
      {
        href:"/profile",
        icon: mdiAccount,
        label: "My Profile",
        to: "/profile",
      },
      {
        icon: mdiCogOutline,
        label: "Settings",
      },
      {
        isDivider: true,
      },
      {
        icon: mdiLogout,
        label: "Cerrar Sesion",
        isLogout: true,
      },
    ],
  },
  {
    icon: mdiThemeLightDark,
    label: "Light/Dark",
    isDesktopNoLabel: true,
    isToggleLightDark: true,
  },
  {
    icon: mdiGithub,
    label: "GitHub",
    isDesktopNoLabel: true,
    href: "https://github.com/ErickJosue1/propuestas",
    target: "_blank",
  },
  {
    icon: mdiLogout,
    label: "Log out",
    isDesktopNoLabel: true,
    isLogout: true,
  },
];
