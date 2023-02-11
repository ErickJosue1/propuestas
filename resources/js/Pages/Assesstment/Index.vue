<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { computed, onMounted, reactive, toRefs, watch } from "vue";
import { Head, useForm } from '@inertiajs/vue3';
import Swal from "sweetalert2";

export default {
    props: {
        titulo: { type: String, required: true },
        assesstments: {
            type: Object,
            default: {},
            required: true,
        },
        routeName: { type: String, required: true },
        loadingResults: { type: Boolean, required: true, default: true },
        search: { type: String, required: true },
        status: { type: Boolean, required: true, default: true },
    },
    components: {
        AppLayout,
        Link
    },

    setup(props) {
        const form = useForm({
            name: '',
            value: ''
        });

        const eliminar = (id) => {
            Swal.fire({
                title: "¿Esta seguro?",
                text: "Esta acción no se puede revertir",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Si!, eliminar registro!",
            }).then((res) => {
                if (res.isConfirmed) {
                    form.delete(route("assesstment.destroy", id));
                }
            });
        };

        const state = reactive({
            filters: {
                page: props.assesstments.current_page,
                search: props.search,
                status: props.status ?? 1,
            },
        });
        const thereAreResults = computed(() => props.assesstments.total > 0);
        const search = () => {
            props.loadingResults = true;
            Inertia.replace(route(`${props.routeName}index`, state.filters));
        };

        return {
            ...toRefs(state),
            search,
            thereAreResults,
            eliminar
        };
    }
}
</script>

<template>
    <AppLayout title="Instituciones">

        <!--         {{ $page.props }}
 -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
                <div class="bg-white pb-4 px-4 rounded-md w-full">
                    <div class="flex justify-between w-full pt-6 pr-4">
                        <p class="ml-3"> {{ titulo }}
                        </p>
                        <a :href="route(`${routeName}create`)"> <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                <path
                                    d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>
                        </a>
                    </div>
                    <div class="w-full flex justify-end px-2 mt-2">
                        <div class="w-full sm:w-64 inline-block relative ">
                            <input type="" name=""
                                class="leading-snug border border-gray-300 block w-full appearance-none bg-gray-100 text-sm text-gray-600 py-1 px-4 pl-8 rounded-lg"
                                placeholder="Buscar" />
                            <div
                                class="pointer-events-none absolute pl-3 inset-y-0 left-0 flex items-center px-2 text-gray-300">

                                <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 511.999 511.999">
                                    <path
                                        d="M508.874 478.708L360.142 329.976c28.21-34.827 45.191-79.103 45.191-127.309C405.333 90.917 314.416 0 202.666 0S0 90.917 0 202.667s90.917 202.667 202.667 202.667c48.206 0 92.482-16.982 127.309-45.191l148.732 148.732c4.167 4.165 10.919 4.165 15.086 0l15.081-15.082c4.165-4.166 4.165-10.92-.001-15.085zM202.667 362.667c-88.229 0-160-71.771-160-160s71.771-160 160-160 160 71.771 160 160-71.771 160-160 160z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto mt-6">

                        <table class="table-auto border-collapse w-full">
                            <thead>
                                <tr class="rounded-lg text-sm font-medium text-gray-700 text-left"
                                    style="font-size: 0.9674rem">
                                    <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Nombre</th>
                                    <th class="px-4 py-2 " style="background-color:#f8f8f8">Peso</th>
                                    <th class="px-12 py-2 " style="background-color:#f8f8f8">Acciones</th>



                                </tr>
                            </thead>
                            <tbody class="text-sm font-normal text-gray-700">
                                <tr v-for="item in assesstments" :key="item"
                                    class="hover:bg-gray-100 border-b border-gray-200 py-10">
                                    <td class="px-4 py-4">{{ item.name }}</td>
                                    <td class="px-8 py-4">{{ item.value }}</td>
                                    <td class="px-4 py-4">
                                        <div class="inline-flex items-center rounded-md shadow-sm">
                                            <Link :href="route('assesstment.edit', item.id)"
                                                class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </span>
                                            <span>Edit</span>
                                            </Link>
                                            <button @click="eliminar(item.id)"
                                                class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-r-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </span>
                                                <span>Delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination" class="w-full flex justify-center border-t border-gray-100 pt-4 items-center">

                        <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.4">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9 12C9 12.2652 9.10536 12.5196 9.29289 12.7071L13.2929 16.7072C13.6834 17.0977 14.3166 17.0977 14.7071 16.7072C15.0977 16.3167 15.0977 15.6835 14.7071 15.293L11.4142 12L14.7071 8.70712C15.0977 8.31659 15.0977 7.68343 14.7071 7.29289C14.3166 6.90237 13.6834 6.90237 13.2929 7.29289L9.29289 11.2929C9.10536 11.4804 9 11.7348 9 12Z"
                                    fill="#2C2C2C" />
                            </g>
                        </svg>

                        <p class="leading-relaxed cursor-pointer mx-2 text-blue-600 hover:text-blue-600 text-sm">1</p>
                        <p class="leading-relaxed cursor-pointer mx-2 text-sm hover:text-blue-600">2</p>
                        <p class="leading-relaxed cursor-pointer mx-2 text-sm hover:text-blue-600"> 3 </p>
                        <p class="leading-relaxed cursor-pointer mx-2 text-sm hover:text-blue-600"> 4 </p>
                        <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15 12C15 11.7348 14.8946 11.4804 14.7071 11.2929L10.7071 7.2929C10.3166 6.9024 9.6834 6.9024 9.2929 7.2929C8.9024 7.6834 8.9024 8.3166 9.2929 8.7071L12.5858 12L9.2929 15.2929C8.9024 15.6834 8.9024 16.3166 9.2929 16.7071C9.6834 17.0976 10.3166 17.0976 10.7071 16.7071L14.7071 12.7071C14.8946 12.5196 15 12.2652 15 12Z"
                                fill="#18A0FB" />
                        </svg>

                    </div>
                    <!-- component -->
                    <!-- This is an example component -->
                </div>

            </div>
        </div>
    </AppLayout>
</template>
