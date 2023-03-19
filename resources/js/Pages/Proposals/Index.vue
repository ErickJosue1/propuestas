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
import { useNFmt } from '@/Hooks/useFormato.js';
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import SectionTitle from "@/components/SectionTitle.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import { useRole } from '@/Hooks/usePermissions';
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";


export default {
    props: {
        titulo: { type: String, required: true },
        records: {
            type: Object,
            required: true
        },
        state: {
            type: Object,
            required: true
        },
        routeName: { type: String, required: true },
        loadingResults: { type: Boolean, required: true, default: true }
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
        SectionTitle
    },
    setup() {
        const form = useForm({
            name: ''
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
                    form.delete(route("proposals.destroy", id));
                }
            });
        };

        return {
            form, eliminar, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiEye, mdiTrashCan,
            useRole
        }
    }

}
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiTableBorder" :title="titulo" main>

        </SectionTitleLineWithButton>



        <CardBox v-if="records.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>


        <CardBox v-else class="mb-6" has-table>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Fecha Captura</th>
                        <th>Fecha Aprobado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in records.data" :key="item.id">

                        <td data-label="Nombre">
                            {{ item.title }}
                        </td>
                        <td data-label="Status">
                            {{ state[item.state_id - 1].state }}
                        </td>
                        <td data-label="Fecha Captura">
                            {{ item.created_at }}
                        </td>
                        <td v-if="item.state_id == 2" data-label="Fecha Aprobado">
                            {{ state[item.state_id - 1].state }}
                        </td>
                        <td v-if="item.state_id == 1" data-label="Fecha Aprobado">
                            Date Approve
                        </td>
                        <td v-if="item.state_id == 3" data-label="Fecha Aprobado">
                            Date Refused
                        </td>



                        <td class=" lg:w-1 whitespace-nowrap">
                            <BaseButtons v-if="useRole('Postulante')" type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="info" :icon="mdiEye" small :href="route(`${routeName}edit`, item.id)" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminar(item.id)" />
                            </BaseButtons>
                            <BaseButtons v-else type="justify-center lg:justify-end" no-wrap>
                                <button :href="route(`${routeName}review`, item.id)"
                                    class="bg-transparent hover:bgeve-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                    Revisar
                                </button>
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
