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
    mdiApplicationEdit, mdiTrashCan
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
import { useRole } from '@/Hooks/usePermissions';
import PillTag from "@/components/PillTag.vue";
import axios from 'axios';


export default {
    props: {
        titulo: { type: String, required: true },
        revisorDocs: {
            type: Object,
            required: true
        },
        routeName: { type: String, required: true },
        loadingResults: { type: Boolean, required: true, default: true }
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

        const checkedDocs = ref([]);

        const remove = (arr, cb) => arr.filter(item => !cb(item));

        const isClientName = row => client => row.name === client.name;


        const checked = (isChecked, field) => {
            let checkedArray = checkedDocs.value;

            const isNameChecked = isClientName(field);

            if (isChecked) {
                checkedArray.push(field);
            } else {
                checkedArray = remove(checkedArray, isNameChecked);
            }

            checkedDocs.value = checkedArray;

            console.log(checkedDocs.value)
        }

        //revisorDocs.assign

        const asignar = () => {

            const assignForm = useForm({
                documents: checkedDocs.value,
            });

            if (assignForm.documents.length <= 0) {
                Swal.fire({
                    title: "Seleccione al menos un documento",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK",
                })
            }


            Swal.fire({
                title: "¿Esta seguro?",
                text: "Asignara los documentos seleccionados a los evaluadores",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Si!, asignar documentos!",
            }).then((res) => {
                if (res.isConfirmed) {
                    assignForm.post(route("revisorDocs.assign"));
                }
            });
        };


        return {
            form, eliminar, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit, mdiTrashCan, checkedDocs, checked, asignar, useRole
        }
    }

}
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiTableBorder" :title="titulo" main>
            <a v-if="useRole('Admin')" :href="route(`${routeName}create`)"> <svg xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
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

        <CardBox v-if="revisorDocs.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else-if="useRole('Admin')" class="mb-6" has-table>

            <table>
                <thead>
                    <tr>
                        <th v-if="true" />
                        <th>Nombre</th>
                        <th />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in revisorDocs.data" :key="item.id">
                        <TableCheckboxCell v-if="true" @checked="checked($event, item)" />

                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>

                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="info" :icon="mdiApplicationEdit" small
                                    :href="route(`${routeName}edit`, item.id)" />
                                <BaseButton color="danger" :icon="mdiTrashCan" small @click="eliminar(item.id)" />
                            </BaseButtons>
                        </td>

                    </tr>
                </tbody>
            </table>



            <Pagination :currentPage="revisorDocs.current_page" :links="revisorDocs.links"
                :total="revisorDocs.links.length - 2"></Pagination>

            <template #footer>
                <hr>
                <SectionTitleLineWithButton class="pt-6" :icon="mdiBallotOutline" title="Documentos para asignar" main>

                </SectionTitleLineWithButton>

                <div v-if="checkedDocs.length" class="p-3 my-3">


                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="checkedDoc in checkedDocs" :key="checkedDoc.id">

                                <td data-label="Nombre">
                                    {{ checkedDoc.name }}
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <CardBox v-else>
                    <CardBoxComponentEmpty />
                </CardBox>

                <BaseButtons v-if="checkedDocs.length">
                    <BaseButton @click="asignar" type="submit" color="success" label="Asignar a Evaluadores" />
                </BaseButtons>
            </template>
        </CardBox>
        <CardBox v-else-if="useRole('Revisor')" class="mb-6" has-table>

            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in revisorDocs.data" :key="item.id">
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>

                        <td>
                            <PillTag v-if="item.status_id[0].id == 1" color="success" :label="item.status_id[0].state"
                                :small="false" :outline="false" :icon="pillsIcon" />

                            <PillTag v-if="item.status_id[0].id == 4" color="danger" :label="item.status_id[0].state"
                                :small="false" :outline="false" :icon="pillsIcon" />
                            <PillTag v-if="item.status_id[0].id == 3" color="warning" :label="item.status_id[0].state"
                                :small="false" :outline="false" :icon="pillsIcon" />
                        </td>

                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <a class="w-full text-righ" :href="route('revisorDocs.review', item.id)"
                                v-if="item.status_id[0].id == 3">
                                <label :for="item.id" class="cursor-pointer">
                                    <PillTag color="info" label="Revisar" :small="false" :outline="false"
                                        :icon="mdiCloudUpload" />
                                </label>
                            </a>
                        </td>

                    </tr>
                </tbody>
            </table>



            <Pagination :currentPage="revisorDocs.current_page" :links="revisorDocs.links"
                :total="revisorDocs.links.length - 2"></Pagination>


        </CardBox>

    </LayoutMain>
</template>
