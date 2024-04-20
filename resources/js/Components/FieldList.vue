<template>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Especifica los campos a rellenar para un laboratorio</h1>

        <div class=" mb-4">
            <FormField help="Titulo del campo para la postulacion de un laboratorio">
                <FormControl v-model="title" type="text" placeholder="Nombre del campo" />
            </FormField>
            <FormField help="Descripcion del campo para la postulacion de un laboratorio">
                <FormControl v-model="description" type="text" placeholder="Descripcion del campo" />
            </FormField>
            <BaseButtons>
                <BaseButton @click="addTask" color="info" label="Añadir" />
            </BaseButtons>
        </div>
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
            title: '',
            description: '',
            mdiBallotOutline
        };
    },
    methods: {
        addTask() {
            this.tasks = []
            if (this.title.trim() !== '' && this.description.trim() !== '') {
                this.tasks.push({ title: this.title, description: this.description });
                this.title = '';
                this.description = '';
                this.$emit("fields", this.tasks)
            }
            else {

            }
        }
    }
};
</script>