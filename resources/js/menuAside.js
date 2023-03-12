import {
  mdiAccountCircle,
  mdiMonitor,
  mdiGithub,
  mdiLock,
  mdiAlertCircle,
  mdiSquareEditOutline,
  mdiTable,
  mdiViewListOutline,
  mdiTelevisionGuide,
  mdiResponsive,
  mdiPalette,
  mdiClockCheck,
  mdiBookshelf,
  mdiCalendarAccountOutline,
  mdiClockTimeEleven

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
    href:"/announcements",
    label: "Convocatorias",
    icon: mdiClockCheck,
    role: "Admin"
  },
  {
    label: "Calendario",
    href: "/calendar",
    icon: mdiCalendarAccountOutline,
    role: "Admin"
  },
  {
    label: "Eventos",
    href: "/events",
    to: "/events",
    icon: mdiClockTimeEleven,
    role: "Admin"
  },
  {
    label: "Catalogos",
    icon: mdiViewListOutline,
    role: "Admin",
    menu: [
      {
        permission: 'institutions.index',
        label: "Instituciones",
        href: "/institutions",  
        to: "/institutions",
      },
      {
        label: "Documentos",
        href: "/documents",
        to: "/documents",
        permission: 'document.index',
      },
      {
        label: "Criterios",
        href: "/assesstment",
        to: "/assesstment",
        permission: 'assesstments.index',
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
    href:"/announcements",
    icon: mdiMonitor,
    label: "Convocatorias",
    role: "Postulante"
  },
  {
    href: "/proposals",
    label: "Tus propuestas",
    icon: mdiBookshelf,
    role: "Postulante"
  },
  
  /* {
    href:"/announcements",
    label: "Convocatorias",
    icon: mdiClockCheck,
    target: "_blank",
    permission: "announcements.index"
  }, */

];
