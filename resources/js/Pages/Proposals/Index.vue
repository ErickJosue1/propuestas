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
    mdiApplicationEdit, mdiTrashCan,
    mdiInformation, mdiCloudDownload
} from "@mdi/js";
import PillTag from "@/components/PillTag.vue";
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
import NotificationBar from "@/components/NotificationBar.vue";
import { usePage } from "@inertiajs/vue3";
import axios from 'axios';


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
    methods: {
        getPdf(proposal) {
            axios({
                url: route('downloadRecognitionPDF', proposal.id),
                method: 'GET',
                responseType: 'blob', // This is important
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                console.log(url)
                link.href = url;
                link.setAttribute('download', proposal.id + usePage().props.auth.user.name + '.pdf');
                document.body.appendChild(link);
                link.click();
            });
        },
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
        SectionTitle,
        PillTag,
        NotificationBar
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
            mdiApplicationEdit, mdiTrashCan,
            useRole,
            mdiInformation, mdiCloudDownload, usePage
        }
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
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Fecha Captura</th>
                        <th v-if="useRole('Postulante')">Descargar Constancia</th>
                        <th v-if="useRole('Evaluador')">Habilitar Constancia</th>
                        <th v-if="records.data.state_id != 3">Fecha Aprobado / Rechazado</th>
                        <th v-else>Fecha Rechazado</th>
                        <th v-if="!useRole('Admin')">Acciones</th>
                        <th v-else>Revisores</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in records.data" :key="item.id">

                        <td data-label="Nombre">
                            {{ item.title }}
                        </td>
                        <td v-if="item.state_id == 2" data-label="Status">
                            {{ state[item.state_id - 1].state }}
                        </td>
                        <td v-if="item.state_id == 1" data-label="Status">
                            <PillTag color="success" label="Aprobado" :small="pillsSmall" :outline="pillsOutline"
                                :icon="pillsIcon" />
                        </td>
                        <td v-if="item.state_id == 3" data-label="Status">
                            <PillTag color="danger" label="Rechazado" :small="pillsSmall" :outline="pillsOutline"
                                :icon="pillsIcon" />
                        </td>
                        <td data-label="Fecha Captura">
                            {{ item.created_at }}
                        </td>

                        <td data-label="Descargar Constancia" v-if="item.state_id == 1 && useRole('Postulante')"
                            class=" lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-center" no-wrap>
                                <BaseButton @click="getPdf(item)" color="info" :icon="mdiCloudDownload" small />
                            </BaseButtons>
                        </td>

                        <td data-label="Descargar Constancia"
                            v-if="(item.state_id == 2 || item.state_id == 3) && useRole('Postulante')"
                            class=" lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-center" no-wrap>
                                -
                            </BaseButtons>
                        </td>

                        <td data-label="Habilitar Constancia" v-if="item.state_id == 1 && useRole('Evaluador')"
                            class=" lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-center" no-wrap>
                                <a :href="route('recognitionPDF', item.id)"> <button
                                        class="bg-transparent hover:bgeve-blue-500 text-blue-700 font-semibold dark:hover:text-white hover:text-black py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                        Habilitar
                                    </button>
                                </a>
                            </BaseButtons>
                        </td>

                        <td data-label="Descargar Constancia"
                            v-if="(item.state_id == 2 || item.state_id == 3) && useRole('Evaluador')"
                            class=" lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-center" no-wrap>
                                -
                            </BaseButtons>
                        </td>

                        <td v-if="item.state_id == 2" data-label="Fecha Aprobado">
                            {{ state[item.state_id - 1].state }}
                        </td>
                        <td v-if="item.state_id == 1" data-label="Fecha Aprobado">
                            {{ item.updated_at }}
                        </td>
                        <td v-if="item.state_id == 3" data-label="Fecha Rechazado">
                            {{ item.updated_at }}
                        </td>



                        <td class=" lg:w-1 whitespace-nowrap">
                            <BaseButtons v-if="useRole('Postulante')" type="justify-start lg:justify-center" no-wrap>
                                <div v-if="item.state_id == 2 || item.state_id == 3">
                                    <BaseButton color="info" :icon="mdiApplicationEdit" small
                                        :href="route(`${routeName}edit`, item.id)" />
                                    <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminar(item.id)" />
                                </div>
                                <div v-else>-</div>
                            </BaseButtons>
                            <BaseButtons v-else-if="useRole('Evaluador')" type="justify-center lg:justify-end" no-wrap>
                                <a v-if="!(item.state_id != 2)" :href="route(`${routeName}review`, item.id)"> <button
                                        class="bg-transparent hover:bgeve-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                        Revisar
                                    </button>
                                </a>
                                <span v-else>
                                    Ya ha revisado esta propuestas
                                </span>
                            </BaseButtons>
                            <BaseButtons v-else-if="useRole('Admin')" type="justify-center lg:justify-end" no-wrap>
                                <a v-if="item.users == null" :href="route(`${routeName}assignment`, item.id)"> <button
                                        class="bg-transparent hover:bgeve-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                        Asignar Revisor
                                    </button>
                                </a>
                                <div v-else>
                                    <ul class="text-center list-inside list-disc">
                                        <a :href="route('profile.index')">
                                            <li class="hover:underline" v-for="user in item.users" :key="user.id">{{
                                                user.name
                                            }}</li>
                                        </a>
                                    </ul>
                                </div>
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
