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
  mdiClockCheck,
  mdiBookshelf

} from "@mdi/js";



export default [
  {
    href: "/dashboard",
    to: "/dashboard",
    icon: mdiMonitor,
    label: "Dashboard",
    role: "Admin"
  },

  /*  {
     href: "/tables",
     to: "/tables",
     label: "Tables",
     icon: mdiTable,
   },
     {
    to: "/",
    href: "/",
    label: "Styles",
    icon: mdiPalette,
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
    role: "Admin",
    menu: [
      {
        permission: 'institutions.index',
        label: "Instituciones",
        href: "/institutions",
        to: "/institutions",
      },
      {
        label: "Eventos",
        href: "/events",
        to: "/events",
        permission: 'events.index',

      },
      {
        label: "Soporte a \ndocumentos",
        href: "/documents",
        to: "/documents",
        permission: 'document.index',
      },
      {
        label: "Permisos",
        href: "/permissions",
        to: "/permissions",
        permission: 'permissions.index',
      },
    ],
  },

  {
    label: "Propuestas",
    icon: mdiBookshelf,
    target: "_blank",
    role: "Postulante"
  },
  {
    label: "Convocatorias",
    icon: mdiClockCheck,
    target: "_blank",
    permission: "announcements.index"
  },

];
