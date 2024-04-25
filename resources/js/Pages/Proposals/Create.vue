<script>
import { Link, useForm, usePage } from '@inertiajs/vue3';
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
import axios from 'axios';
import FormValidationErrors from "@/components/FormValidationErrors.vue";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import Swal from "sweetalert2";
import { computed, ref } from "vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";




export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        convocatoria: { type: Object, required: true },
        state: { type: Object, required: true },
        areas: { type: Object, required: true },
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
        FormFilePicker,
        FormValidationErrors,
        NotificationBarInCard
    },
    methods: {
        onchange(e) {
            if (this.file.some(val => val.name === e.target.name)) {
                const i = this.file.findIndex(val => val.name === e.target.name)
                const name = e.target.name
                const fileA = e.target.files[0]
                this.file[i] = { name: name, file: fileA }
                console.log(this.file)
            }
            else {
                const name = e.target.name
                const fileA = e.target.files[0]
                this.file.push({ name: name, file: fileA })
                console.log(this.file)
            }

        },
        onFieldChange(e, item, index) {
            this.form.fields[index] = { id: item.id, info: e }
        }
    },
    setup(props) {
        const submit = () => {
            if (file.length < props.convocatoria.documents_supporting.length) {
                Swal.fire({
                    title: "Documentos obligatorios!",
                    text: "Es necesario subir los " + props.convocatoria.documents_supporting.length + " documentos",
                    icon: "warning",
                    timer: 10000,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok!",
                });
            }
            else {
                const config = {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }

                const formData = new FormData();

                for (let index = 0; index < file.length; index++) {
                    formData.append('myFiles[' + index + ']', file[index].file, file[index].name + ".pdf")
                }

                Object.entries(form.data()).forEach(([key, value]) => {
                    if (key == 'fields') {
                        value.forEach((value) => {
                            formData.append('fields[' + value.id + ']', value.info)
                            console.log(value.id)
                        });
                    }
                    else {
                        formData.append(key, value)
                    }
                })

                axios.post(route('proposals.store'), formData, config).then((response) => {
                    window.location = route('proposals.index')
                })
                    .catch(function (error) {
                        if (error.response) {

                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);

                            Object.entries(error.response.data.errors).forEach(([key, value]) => {
                                errors.value.push(value[0])
                            })


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




        };

        const file = []

        const form = useForm({
            title: '',
            announcement_id: props.convocatoria.id,
            area_knowledge_id: '',
            user_id: usePage().props.auth.user.id,
            state_id: props.state.id,
            fields: []
        })

        const linea = ['Linea 1', 'Linea 2', 'Linea 3']

        const errors = ref([]);

        const hasErrors = computed(() => errors.value.length > 0);

        return { submit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, linea, file, hasErrors, errors }
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

        <CardBox>

            <NotificationBarInCard v-if="hasErrors" color="danger">
                <b>Whoops! Algo salio mal!.</b>
                <span v-for="(error, key) in errors" :key="key">{{ error }}</span>
            </NotificationBarInCard>

            <Tabs>
                <Tab title="Gestion de documentacion">
                    <div class="p-4" v-for="(item, index) in convocatoria.documents_supporting" :key="index">
                        <FormField :label="item.name">
                            <label for="file-input" class="sr-only">Choose file</label>
                            <input type="file" :name="item.name" id="file-input" @change="onchange"
                                accept="application/pdf"
                                class="block w-full border border-gray-200 shadow-sm rounded-md text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 file:bg-transparent file:border-0
                                                                          file:bg-gray-100 file:mr-4 file:py-3 file:px-4 dark:file:bg-gray-700 dark:file:text-gray-400">
                        </FormField>
                    </div>

                    <base-divider></base-divider>
                    <BaseButtons>
                        <BaseButton @click="submit" type="submit" color="info" label="Subir" />
                        <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                            label="Cancelar" />
                    </BaseButtons>
                </Tab>

                <Tab title="Gestion de propuestas">


                    <FormField label="Titulo" class="p-4"
                        help="Titulo del Laboratorio. Min 15 caracteres. Max 255 caracteres">
                        <FormControl v-model="form.title" placeholder="Asigne un titulo para el Laboratorio" />
                    </FormField>
                    <FormField class="px-4" label="Area del conocimiento" help="Seleccione un area del conocimiento">
                        <FormControl v-model="form.area_knowledge_id" :options="areas" />
                    </FormField>

                    <hr>

                    <div class="p-4" v-for="(item, index) in convocatoria.fields" :key="index">
                        <FormField :label="item.title" help="Max 255 caracteres">
                            <FormControl @update:modelValue="onFieldChange($event, item, index)"
                                :placeholder="item.description" />
                        </FormField>

                    </div>




                    <!--    
                    <FormField label="Resumen"
                        help="Descripcion general de la convocatoria. Min 1000 caracteres. Max 4000 caracteres">
                        <FormControl v-model="form.abstract" type="textarea"
                            placeholder="Explica brevemente la Propuesta" />
                    </FormField> -->


                    <base-divider></base-divider>

                    <BaseButtons>
                        <BaseButton @click="submit" type="submit" color="info" label="Subir" />
                        <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                            label="Cancelar" />
                    </BaseButtons>
                </Tab>


            </Tabs>

        </CardBox>
    </LayoutMain>
</template>
