<script>
import { Link, useForm } from '@inertiajs/vue3';
import Swal from "sweetalert2";
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import {
    mdiMonitorCellphone,
    mdiTableBorder,
    mdiTableOff,
    mdiGithub,
    mdiEye, mdiTrashCan
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import { reactive, toRefs, ref } from 'vue';
import NotificationBar from "@/components/NotificationBar.vue";


export default {
    props: {
        titulo: { type: String, required: true },
        records: {
            type: Object,
            default: {},
            required: true,
        },
        routeName: { type: String, required: true },
        loadingResults: { type: Boolean, required: true, default: true },
        search: { type: String, required: true },
    },
    components: {
        Link,
        LayoutMain,
        CardBox,
        TableSampleClients,
        SectionTitleLineWithButton,
        BaseLevel,
        BaseButtons,
        BaseButton,
        CardBoxComponentEmpty,
        Pagination,
        NotificationBar
    },

    setup(props) {
        const form = useForm({
            name: '',
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
                    form.delete(route("profile.destroy", id));
                }
            });
        };

        const isLoading = ref(false);

        const state = reactive({
            filters: {
                page: props.records.current_page,
                search: props.search,
                status: props.status ?? 1,
            },
        });

        const search = () => {
            props.loadingResults = true;
            Inertia.replace(route(`${props.routeName}index`, state.filters));
        };

        return {
            ...toRefs(state),
            search,
            eliminar,
            mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiEye, mdiTrashCan,
            isLoading
        };
    }
}
</script>

<template>
    <LayoutMain>

        <SectionTitleLineWithButton :icon="mdiTableBorder" :title="titulo" main>

        </SectionTitleLineWithButton>


        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="records.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <table>
                <thead>
                    <tr>
                        <th />
                        <th>Curp</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in records.data" :key="item.id">
                        <td class="align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-book-half" viewBox="0 0 16 16">
                                <path
                                    d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                            </svg>
                        </td>
                        <td data-label="Curp">
                            {{ item.curp }}
                        </td>
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Apellido Paterno">
                            {{ item.paternal_surname }}
                        </td>
                        <td data-label="Apellido Materno">
                            {{ item.maternal_surname }}
                        </td>

                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <!--  <BaseButton color="info" :icon="mdiEye" small
                                    :href="route(`${routeName}edit`, item.id)" /> -->
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminar(item.id)" />
                                <a :href="route('users.assign-roles-and-permissions.view', item.id)"> <button
                                        class="bg-transparent hover:bgeve-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                        Asignar Rol
                                    </button>
                                </a>
                            </BaseButtons>
                        </td>

                    </tr>
                </tbody>
            </table>



            <Pagination :currentPage="records.current_page" :links="records.links" :total="records.links.length - 2">
            </Pagination>
        </CardBox>

    </LayoutMain>
</template>
