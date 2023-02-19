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


export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        institutions: { type: Object, required: true }
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
        Tab
    },
    setup() {
        const submit = () => {
            form.post(route('announcements.store'));
        };

        const form = useForm({
            name: '',
            status: ''
        });

        const tabs = [{ name: 'General', tab: 'Tab1' }, { name: 'Criterios de Evaluacion', tab: 'Tab2' },];
        const activeTab = 'Tab1';


        return { submit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, tabs, activeTab }
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
                        <FormField label="Titulo">
                            <FormControl v-model="form.phone" type="tel" placeholder="Titulo de la convocatoria" />
                        </FormField>

                        <FormField label="Instituciones">
                            <FormControl v-model="form.department" :options="institutions" />
                        </FormField>

                        <FormField label="Descripcion" help="Descripcion general de la convocatoria. Max 255 caracteres">
                            <FormControl type="textarea" placeholder="Explica brevemente la convocatoria" />
                        </FormField>
                    </div>
                </template>

                <template v-slot:Tab2>
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                        aria-labelledby="profile-tab">

                        <FormField label="Grouped with icons">
                            <FormControl v-model="form.name" :icon="mdiAccount" />
                            <FormControl v-model="form.email" type="email" :icon="mdiMail" />
                        </FormField>

                        <FormField label="With help line" help="Do not enter the leading zero">
                            <FormControl v-model="form.phone" type="tel" placeholder="Your phone number" />
                        </FormField>

                        <FormField label="Dropdown">
                            <FormControl v-model="form.department" :options="selectOptions" />
                        </FormField>

                        <BaseDivider />

                        <FormField label="Question" help="Your question. Max 255 characters">
                            <FormControl type="textarea" placeholder="Explain how we can help you" />
                        </FormField>
                    </div>
                </template>
            </Tabs>




        </CardBox>
    </LayoutMain>
</template>
