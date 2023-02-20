<template>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Añade criterios a la convocatoria</h1>

        <div class=" mb-4">
            <FormField>
                <FormControl v-model="name" type="text" placeholder="Criterio" />
                <FormControl v-model="value" type="text" placeholder="Peso del criterio" />
            </FormField>
            <BaseButtons>
                <BaseButton @click="addTask" color="info" label="Añadir" />
            </BaseButtons>
        </div>

        <SectionTitleLineWithButton class="pt-6" :icon="mdiBallotOutline" title="Criterios" main>
            <a :href="route('announcements.index')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg></a>
        </SectionTitleLineWithButton>
        <hr class="p-2">

        <ul class="list-disc pl-8">
            <li v-for="(task, index) in tasks" :key="index" class="mb-2">{{ task.name }}</li>
        </ul>
    </div>
</template>
  
<script>
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";



export default {
    components: {
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        SectionTitleLineWithButton
    },
    data() {
        return {
            tasks: [],
            name: '',
            value: '',
            mdiBallotOutline
        };
    },
    methods: {
        addTask() {
            if (this.name.trim() !== '' && this.value.trim() !== '') {
                this.tasks.push({ name: this.name, value: this.value });
                this.name = '';
                this.value = '';
            }
            else {

            }
        }
    }
};
</script>
  