<script>
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, mdiEye, mdiTrashCan } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Tabs from '@/components/Tabs.vue';
import Tab from '@/components/Tab.vue';
import ToggleSwitch from '@/components/ToggleSwitch.vue';
import TodoList from '@/components/TodoList.vue';
import DocList from '@/components/DocList.vue';
import { ref, computed, reactive } from 'vue';
import TableCheckboxCell from "@/components/TableCheckboxCell.vue";
import FormValidationErrors from '@/components/FormValidationErrors.vue'


export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        institutions: { type: Object, required: true },
        assesstments: { type: Object, required: true },
        documents: { type: Object, required: true },

    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        CardBox,
        SectionTitleLineWithButton,
        Tabs,
        Tab,
        ToggleSwitch,
        TodoList,
        TableCheckboxCell,
        DocList,
        FormValidationErrors
    },
    methods: {
        todo: function (data) {
            this.assesstments.push(data[0]);
        },
        docs: function (data) {
            this.documents.push(data[0]);
        }
    },
    setup(props) {
        const submit = () => {
            form.assesstments = checkedRows.value;
            form.documents = checkedDocs.value;
            form.post(route('announcements.store'));
        };

        const showTable = computed(() => {
            return props.assesstments.length > 0 ? true : false
        })

        const form = useForm({
            name: '',
            description: '',
            num_announcement: '1',
            status: 1,
            y_announcement: '2023',
            institutions_id: '',
            assesstments: [],
            documents: []
        });

        const checkedRows = ref([]);
        const checkedDocs = ref([]);

        const remove = (arr, cb) => arr.filter(item => !cb(item));

        const isClientName = row => client => row.name === client.name;

        const checked = (isChecked, client, type) => {
            let checkedArray = type ? checkedRows.value : checkedDocs.value;
            const isNameChecked = isClientName(client);
            console.log(isNameChecked)


            if (isChecked) {
                checkedArray.push(client);
            } else {
                checkedArray = remove(checkedArray, isNameChecked);
            }

            if (type) {
                checkedRows.value = checkedArray;
            } else {
                checkedDocs.value = checkedArray;
            }
        };

        const eliminar = (id, type) => {
            if (type) {
                props.assesstments = remove(props.assesstments, (row) => row.id === id)
            }
            else {
                props.documents = remove(props.documents, (row) => row.id === id)
            }

        }



        return { submit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, checked, checkedRows, mdiEye, mdiTrashCan, showTable, eliminar, checkedDocs }
    },
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            <a :href="route(`${routeName}index`)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg></a>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="submit">
            <FormValidationErrors />

            <Tabs>
                <Tab title="General">
                    <div class="p-4 rounded-lg" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h1 class="text-2xl font-bold mb-4">Informacion general de la convocatoria</h1>
                        <FormField label="Titulo">
                            <FormControl v-model="form.name" type="text" placeholder="Titulo de la convocatoria" />
                        </FormField>

                        <FormField label="Instituciones">
                            <FormControl v-model="form.institutions_id" :options="institutions" />
                        </FormField>

                        <FormField label="Descripcion" help="Descripcion general de la convocatoria. Max 255 caracteres">
                            <FormControl v-model="form.description" type="textarea"
                                placeholder="Explica brevemente la convocatoria" />
                        </FormField>
                    </div>
                </Tab>

                <Tab title="Criterios de Evaluacion">
                    <div class="p-4 rounded-lg" id="profile">
                        <todo-list @tasks="todo" ref="TodoListRef"></todo-list>

                        <div  v-if="assesstments.length > 0">
                            <SectionTitleLineWithButton class="pt-6" :icon="mdiBallotOutline" title="Criterios" main>
                                <a :href="route('announcements.index')"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg></a>
                            </SectionTitleLineWithButton>

                            <BaseDivider />

                            <div v-if="checkedRows.length" class="p-3 bg-gray-100/50 dark:bg-slate-800">
                                <span v-for="checkedRow in checkedRows" :key="checkedRow.id"
                                    class="inline-block px-2 py-1 rounded-sm mr-2 text-sm bg-gray-100 dark:bg-slate-700">
                                    {{ checkedRow.name }}
                                </span>
                            </div>

                            <table class="border-gray-200 dark:border-gray-700">
                                <thead>
                                    <tr>
                                        <th v-if="true" />
                                        <th>Nombre</th>
                                        <th>Peso</th>
                                        <th />
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="client in assesstments" :key="client.id">
                                        <TableCheckboxCell @checked="checked($event, client, true)" />

                                        <td data-label="Name">
                                            {{ client.name }}
                                        </td>

                                        <td data-label="Progress" class="lg:w-32">
                                            <progress class="flex w-2/5 self-center lg:w-full" max="100"
                                                :value="client.value">
                                                {{ client.value }}
                                            </progress>
                                        </td>
                                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                                <BaseButton color="info" :icon="mdiEye" small />
                                                <BaseButton @click="eliminar(client.id, true)" color="danger"
                                                    :icon="mdiTrashCan" small />
                                            </BaseButtons>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </Tab>
                <Tab title="Documentos">
                    <div class="p-4 rounded-lg" id="profile">
                        <doc-list @docs="docs"></doc-list>
                        <div v-if="documents.length > 0">
                            <SectionTitleLineWithButton class="pt-6" :icon="mdiBallotOutline" title="Documentos" main>
                                <a :href="route('announcements.index')"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg></a>
                            </SectionTitleLineWithButton>

                            <BaseDivider />

                            <div v-if="checkedDocs.length" class="p-3 bg-gray-100/50 dark:bg-slate-800">
                                <span v-for="checkedDoc in checkedDocs" :key="checkedDoc.id"
                                    class="inline-block px-2 py-1 rounded-sm mr-2 text-sm bg-gray-100 dark:bg-slate-700">
                                    {{ checkedDoc.name }}
                                </span>
                            </div>
                            <table class="border-gray-200 dark:border-gray-700">
                                <thead>
                                    <tr>
                                        <th v-if="true" />
                                        <th>Nombre</th>
                                        <th />
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="document in documents" :key="document.id">
                                        <TableCheckboxCell v-if="true" @checked="checked($event, document, false)" />

                                        <td data-label="Name">
                                            {{ document.name }}
                                        </td>
                                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                                <BaseButton color="info" :icon="mdiEye" small />
                                                <BaseButton @click="eliminar(document.id, false)" color="danger"
                                                    :icon="mdiTrashCan" small />
                                            </BaseButtons>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <base-divider></base-divider>
                        <BaseButtons>
                            <BaseButton @click="submit" type="submit" color="info" label="Subir" />
                            <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                                label="Cancelar" />
                        </BaseButtons>
                    </div>
                </Tab>
            </Tabs>

        </CardBox>
    </LayoutMain>
</template>
