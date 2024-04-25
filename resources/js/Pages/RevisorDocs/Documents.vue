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
    mdiApplicationEdit, mdiTrashCan, mdiCloudUpload
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import { ref, computed, reactive } from 'vue';
import TableCheckboxCell from "@/components/TableCheckboxCell.vue";
import PillTag from "@/components/PillTag.vue";
import axios from 'axios';
import { forEach } from 'lodash';



export default {
    props: {
        titulo: { type: String, required: true },
        records: {
            type: Object,
            required: true
        },
        routeName: { type: String, required: true },
        documents: {
            type: Object,
            required: true
        },
        status: {
            type: Object,
            required: true
        },
    },
    components: {
        Link,
        TableCheckboxCell,
        LayoutMain,
        CardBox,
        TableSampleClients,
        SectionTitleLineWithButton,
        BaseLevel,
        BaseButtons,
        BaseButton,
        CardBoxComponentEmpty,
        Pagination,
        NotificationBar,
        PillTag
    },
    methods: {
        onchange(e) {

            console.log(e.target)

            Swal.fire({
                title: "Va a subir el documento -" + e.target.name + "-",
                text: "Asegurese de que es el documento correcto",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Si!, subir documento!",
            }).then((res) => {
                if (res.isConfirmed) {
                    const name = e.target.name
                    const fileA = e.target.files[0]

                    const formData = new FormData();
                    const config = {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }

                    formData.append('myFiles[' + 0 + ']', fileA, name + ".pdf")

                    axios.post(route('revisorDocs.storeDocument'), formData, config).then((response) => {
                        window.location = route('revisorDocs.updateStatus')
                    })
                        .catch(function (error) {
                            if (error.response) {

                                console.log(error.response.data);
                                console.log(error.response.status);
                                console.log(error.response.headers);


                            } else if (error.request) {
                                // The request was made but no response was received
                                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                                // http.ClientRequest in node.js
                                console.log(error.request);
                            } else {
                                // Something happened in setting up the request that triggered an Error
                                console.log('Error', error.message);
                            }
                            console.log(error.config);
                        });
                }
            });


        },
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
                    form.delete(route("revisorDocs.destroy", id));
                }
            });
        };

        const file = []

        const submit = (id) => {

            const form = useForm({
                status: 3,
            });


            Swal.fire({
                title: "¿Esta seguro?",
                text: "Se enviaran tus documentos a revision",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Si!, enviar documentos!",
            }).then((res) => {
                if (res.isConfirmed) {
                    form.post(route('revisorStatus.assign', id))
                }
            });

        }

        return {
            form, eliminar, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit, mdiTrashCan, mdiCloudUpload, file, submit
        }
    }

}
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiTableBorder" :title="titulo" main>
            <a :href="route(`${routeName}create`)"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                    <path
                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
            </a>
        </SectionTitleLineWithButton>


        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="status[0].state_id == 3">
            <NotificationBar color="info" :icon="mdiInformation" :outline="false">
                Tus documentos fue enviada a revision
            </NotificationBar>

            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else-if="status[0].state_id == 1">
            <NotificationBar color="success" :icon="mdiInformation" :outline="false">
                Tu documentos fueron aprovados
            </NotificationBar>
        </CardBox>

        <CardBox v-else-if="status[0].state_id == 4">
            <NotificationBar color="danger" :icon="mdiInformation" :outline="false">
                Tu documentos fueron rechazados
            </NotificationBar>
        </CardBox>

        <CardBox v-else-if="records.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Nombre</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in records" :key="index">
                        <TableCheckboxCell v-if="true" :value="documents[item.id] == 1" :disabled="true" />

                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>

                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <div class="w-full text-righ">
                                <label :for="item.id" class="cursor-pointer">
                                    <PillTag color="success" label="Subir" :small="false" :outline="false"
                                        :icon="mdiCloudUpload" />
                                </label>

                                <input type="file" class="hidden file-input" accept="application/pdf" :name="item.name"
                                    :id="item.id" @change="onchange" />

                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>

            <template #footer>
                <BaseButtons>
                    <BaseButton @click="submit($page.props.auth.user.id)" type="submit" color="info"
                        label="Enviar para validar" />
                </BaseButtons>
            </template>

        </CardBox>

    </LayoutMain>
</template>
