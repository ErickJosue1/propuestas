<script>
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
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
import FormFilePicker from "@/components/FormFilePicker.vue";





export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        convocatoria: { type: Object, required: true },
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
        FormFilePicker
    },
    setup() {
        const submit = () => {
            form.post(route('announcements.store'));
        };

        const form = useForm({
            name: '',
            num_announcement: '',
            status: '',
            y_announcement: '',
            institutions_id: '',
            assesstments: [],
            file: null
        });

        const linea = [ 'Linea 1', 'Linea 2', 'Linea 3' ]

        const tabs = [{ name: 'Gestion de documentacion', tab: 'Tab1' }, { name: 'Gestion de propuestas', tab: 'Tab2' }, { name: 'Criterios de Evaluacion', tab: 'Tab3', enable: false }];
        const activeTab = 'Tab1';


        return { submit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, tabs, activeTab, linea }
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


            <Tabs :tabs="tabs" :activeTab="activeTab">
                <template v-slot:Tab1>
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <FormField label="Titulo y Status">
                            <FormFilePicker label="Upload" />
                        </FormField>
                    </div>
                </template>

                <template v-slot:Tab2>
                    <FormField label="Titulo de la propuestas" help="Max 255 caracteres">
                        <FormControl v-model="form.phone" type="tel" placeholder="Asigne el nombre de identificacion para el proyecto" />
                    </FormField>

                    <FormField label="Linea de investigacion" help="Seleccione una linea de investigacion">
                        <FormControl :options="linea" />
                    </FormField>

                    <FormField label="Resumen" help="Descripcion general de la convocatoria. Max 4000 caracteres">
                        <FormControl type="textarea" placeholder="Explica brevemente la Propuesta" />
                    </FormField>
                    <FormField label="Planteamiento del problema"
                        help="Describle la problematica que se abordara. Max 3000 caracteres">
                        <FormControl type="textarea" placeholder="Explica una o mas problematicas" />
                    </FormField>
                    <FormField label="Justificacion" help="Justifica la realizacion del proyecto. Max 3000 caracteres">
                        <FormControl type="textarea"
                            placeholder="Describe las dimensiones, necesidades y oportunidades de la Propuesta" />
                    </FormField>

                    <FormField label="Antecedentes de la propuestas" help="Si la propuesta es la continuacion de una investigacion previamente apoyada, favor de mencionarlo. Max 3000 caracteres">
                        <FormControl type="textarea"
                            placeholder="Describe los estudios previos, vacios del conocimiento, resultados contradictorios en otras investigaciones" />
                    </FormField>
                    <FormField label="Experiencia de los responsables" help="Max 3000 caracteres">
                        <FormControl type="textarea"
                            placeholder="Describe la experienca similar en proyectos previos del responsable tecnico y el personal clabe de la Propuesta" />
                    </FormField>
                    <FormField label="Capacidades de los responsables" help="Max 4000 caracteres">
                        <FormControl type="textarea"
                            placeholder="Describe las capacidades con las que cuenta para desarrollar el proyecto de investigacion" />
                    </FormField>
                </template>
                <template v-slot:Tab3>

                </template>
            </Tabs>

        </CardBox>
    </LayoutMain>
</template>
