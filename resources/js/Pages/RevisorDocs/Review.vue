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
    mdiApplicationEdit, mdiTrashCan, mdiEye, mdiArchiveArrowDown
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
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        revisorDocs: {
            type: Object,
            required: true
        },
        user: {
            type: Object,
            required: true
        },
        routeName: { type: String, required: true },
    },
    components: {
        Link,
        TableCheckboxCell,
        LayoutMain,
        CardBox,
        FormControl,
        FormField,
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
        getPdf(filename) {
            axios({
                url: '/download-pdf/' + (filename + '.pdf') + '/' + this.user.id,
                method: 'GET',
                responseType: 'blob', // This is important
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                console.log(url)
                link.href = url;
                link.setAttribute('download', filename + '.pdf');
                document.body.appendChild(link);
                link.click();
            });
        },
        viewPdf(filename) {
            axios({
                url: '/view-pdf/' + (filename + '.pdf') + '/' + this.user.id,
                method: 'GET',
                responseType: 'blob',
            }).then(response => {
                const blob = new Blob([response.data], { type: 'application/pdf' });
                this.documentUrl = URL.createObjectURL(blob);
                this.pdfTitle = filename
            });
        }
    },
    setup(props) {
        const form = useForm({
            observations: '',
            status: 3
        });

        const approve = () => {
            form.status = 1;
            submit()
        }

        const reject = () => {
            form.status = 4;
            submit()

        }

        const submit = () => {

            var text = form.status == 1 ? "Se aprovara la propuesta" : "Se rechazara la propuesta"

            Swal.fire({
                title: "¿Esta seguro?",
                text: text,
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Si!, enviar documentos!",
            }).then((res) => {
                if (res.isConfirmed) {
                    form.post(route('revisorStatus.assign', props.user.id))
                }
            });
        }
        const documentUrl = ref(null);


        return {
            form, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit, mdiTrashCan, useRole, mdiEye, mdiArchiveArrowDown, documentUrl, approve, reject
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

        <CardBox v-if="revisorDocs.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>


        <CardBox v-else class="mb-6" has-table>

            <div v-if="documentUrl" class="p-4">
                <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="pdfTitle" main>
                    <button class="flex flex-row " @click="documentUrl = null"><svg xmlns="http://www.w3.org/2000/svg"
                            width="32" height="32" fill="crimson" class="bi bi-x" viewBox="0 0 16 16">
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg> <b class="leading-7 text-lg ">Cerrar</b></button>

                </SectionTitleLineWithButton>
                <iframe :src="documentUrl" class="w-full aspect-video" allowfullscreen></iframe>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="p-4">Nombre</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in revisorDocs" :key="item.id">

                        <td class="p-4" data-label="Nombre">
                            {{ item.name }}
                        </td>

                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="info" :icon="mdiEye" small @click="viewPdf(item.name)" />
                                <BaseButton color="success" :icon="mdiArchiveArrowDown" small
                                    @click="getPdf(item.name)" />
                            </BaseButtons>
                        </td>

                    </tr>
                </tbody>
            </table>

            <template #footer>
                <hr class="p-4" />
                <FormField label="Observaciones" label-for="observations" help="Observaciones Generales">
                    <FormControl type="textarea" v-model="form.observations" id="observations"
                        />
                </FormField>
                <BaseButtons>
                    <BaseButton @click="approve()" type="submit" color="success" label="Aprobar" />
                    <BaseButton @click="reject()" type="submit" color="danger" label="Rechazar" />
                </BaseButtons>
            </template>


        </CardBox>

    </LayoutMain>
</template>
