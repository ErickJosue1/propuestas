<template>

    <div>

        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <nav
                class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
                <div class="px-3 py-3 lg:px-5 lg:pl-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-start">
                            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                                aria-controls="logo-sidebar" type="button"
                                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                                <span class="sr-only">Open sidebar</span>
                                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                    </path>
                                </svg>
                            </button>
                            <a :href="route('dashboard')" class="flex ml-2 md:mr-24">
                                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3"
                                    alt="FlowBite Logo" />
                                <span
                                    class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">Flowbite</span>
                            </a>
                        </div>
                        <div class="flex items-center">
                            <div class="flex items-center ml-3">
                                <div class="ml-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <button v-if="$page.props.jetstream.managesProfilePhotos"
                                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover"
                                                    :src="$page.props.user.profile_photo_url"
                                                    :alt="$page.props.user.name">
                                            </button>

                                            <span v-else class="inline-flex rounded-md">
                                                <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                    {{ $page.props.user.name }}

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Manage Account
                                            </div>

                                            <DropdownLink :href="route('profile.show')">
                                                Profile
                                            </DropdownLink>

                                            <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                                :href="route('api-tokens.index')">
                                                API Tokens
                                            </DropdownLink>

                                            <div class="border-t border-gray-200" />

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <DropdownLink as="button">
                                                    Log Out
                                                </DropdownLink>
                                            </form>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <aside id="logo-sidebar"
                class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
                aria-label="Sidebar">
                <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
                    <ul class="space-y-2">
                        <li>
                            <a :href="route('dashboard')" :active="route().current('dashboard')"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                                <svg aria-hidden="true"
                                    class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <Dropdown align="center" width="48">
                                <template #trigger>
                                    <button type="button"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100"
                                        aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                                        <svg aria-hidden="true"
                                            class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="flex-1 ml-3 text-left whitespace-nowrap"
                                            sidebar-toggle-item>Catalogos</span>
                                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Catalogos
                                    </div>

                                    <DropdownLink v-if="useCan('events.index')" :href="route('events.index')"
                                        :active="route().current('events.index')"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                                        Eventos</DropdownLink>

                                    <DropdownLink v-if="useCan('institutions.index')"
                                        :href="route('institutions.index')"
                                        :active="route().current('institutions.index')"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                                        Instituciones</DropdownLink>

                                    <DropdownLink v-if="useCan('permissions.index')" :href="route('permissions.index')"
                                        :active="route().current('permissions.index')"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                                        Permisos</DropdownLink>

                                    <DropdownLink v-if="useCan('assesstments.index')" :href="route('assesstment.index')"
                                        :active="route().current('assesstment.index')"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                                        Criterios de evaluacion </DropdownLink>
                                    <DropdownLink v-if="useCan('document.index')" :href="route('documents.index')"
                                        :active="route().current('documents.index')"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                                        Soporte a documentos </DropdownLink>
                                </template>
                            </Dropdown>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                                <svg aria-hidden="true"
                                    class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z">
                                    </path>
                                    <path
                                        d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z">
                                    </path>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Propuestas</span>

                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg hover:bg-gray-100">
                                <svg aria-hidden="true"
                                    class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap">Usuarios</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </aside>


            <!-- Page Content -->
            <main>
                <div class="mt-12 sm:ml-64">
                    <div class="border-2 border-gray-200 border-dashed rounded-lg">
                        <slot />

                    </div>
                </div>
            </main>
        </div>
    </div>


</template>

<script>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { useCan } from "@/Hooks/usePermissions";
import postscribe from 'postscribe'
import VueMeta from 'vue-meta'



export default {
    metaInfo: {
        script: [
            { src: '../path/to/flowbite/dist/flowbite.min.js', async: true, defer: true }
        ],
    },

    /*    mounted() {
           let recaptchaScript = document.createElement('script')
           recaptchaScript.setAttribute('src', '../path/to/flowbite/dist/flowbite.min.js')
           document.body.appendChild(recaptchaScript)
       },
    */
    props: {
        title: {
            type: String
        }
    },
    components: {
        ResponsiveNavLink,
        NavLink,
        DropdownLink,
        Dropdown,
        Banner,
        ApplicationMark,
        Head,
        Link
    },

    setup() {
        const showingNavigationDropdown = ref(false);

        const switchToTeam = (team) => {
            router.put(route('current-team.update'), {
                team_id: team.id,
            }, {
                preserveState: false,
            });
        };

        const logout = () => {
            router.post(route('logout'));
        };
        return { useCan, logout, switchToTeam, showingNavigationDropdown }
    },


}




</script>
