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
  mdiSecurity,
  mdiClockCheck,
  mdiBookshelf,
  mdiCalendarAccountOutline,
  mdiClockTimeEleven,
  mdiAccount,
  mdiFileDocument

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
    href: "/announcements",
    label: "Convocatorias",
    icon: mdiClockCheck,
    role: "Admin"
  },
  {
    label: "Revisores",
    icon: mdiSquareEditOutline,
    role: "Admin",
    menu: [
      {
        label: "Documentacion",
        href: "revisorDocs",
        role: "Admin",
      },
      {
        label: "Asignar",
        href: "/proposals",
        role: "Admin",
      },
    ]
  },
  {
    label: "Eventos",
    href: "/events",
    to: "/events",
    icon: mdiClockTimeEleven,
    role: "Admin"
  },
  {
    label: "Seguridad",
    icon: mdiSecurity,
    role: "Admin",
    menu: [
      {
        label: "Permisos",
        href: "/permissions",
        to: "/permissions",
        permission: 'permissions.index',
      },
      {
        label: "Roles",
        href: "/roles",
        to: "/roles",
        role: "Admin",
      },
      {
        href: "/profile",
        to: "/profile",
        label: "Usuarios",
        role: "Admin"
      },
    ]
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
        label: "Tematicas",
        href: "/knowledges",
        to: "/knowledges",
        permission: "thematics.index",
      },
      {
        label: "Formularios",
        href: "/fields",
        to: "/fields",
      },
    ],
  },

  {
    href: "/announcements",
    icon: mdiMonitor,
    label: "Convocatorias",
    role: "Postulante"
  },
  {
    href: "/proposals",
    label: "Laboratorios",
    icon: mdiBookshelf,
    role: "Postulante"
  },
  {
    href: "/RevisorDocs/Documents",
    label: "Documentos",
    icon: mdiFileDocument,
    role: "Evaluador"
  },
  {
    href: "/proposals",
    label: "Laboratorios",
    icon: mdiBookshelf,
    role: "Evaluador",
    permission: "evaluator.approved",
  },
  {
    href: "/revisorDocs",
    label: "Revision",
    icon: mdiFileDocument,
    role: "Revisor"
  },

  /* {
    href:"/announcements",
    label: "Convocatorias",
    icon: mdiClockCheck,
    target: "_blank",
    permission: "announcements.index"
  }, */

];
