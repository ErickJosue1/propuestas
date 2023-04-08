<script>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, mdiOpenInNew, mdiInformation } from "@mdi/js";
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
import TableCheckboxCell from "@/components/TableCheckboxCell.vue";
import pdfjsLib from 'pdfjs-dist';
import NotificationBar from "@/components/NotificationBar.vue";




export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        convocatoria: { type: Object, required: true },
        proposal: { type: Object, required: true },
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
        NotificationBarInCard,
        TableCheckboxCell,
        NotificationBar,
        Loading
    },
    methods: {
        getPdf(filename) {
            axios({
                url: '/download-pdf/' + (filename + '.pdf') + '/' + this.proposal.user_id,
                method: 'GET',
                responseType: 'blob', // This is important
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', filename + '.pdf');
                document.body.appendChild(link);
                link.click();
            });
        }
    },
    setup(props) {

        const isLoading = ref(false);

        const submit = () => {
            if (criterias.value.length <= 0) {
                Swal.fire({
                    title: "Evaluó todos los criterio, desea continuar?",
                    text: "Al seleccionar todos criterio o una observación general, la propuestas sera marcada como 'Aprobada'",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok!",
                }).then((res) => {
                    if (res.isConfirmed) {
                        isLoading.value = true;
                        post()
                    }
                });
            }
            else {
                Swal.fire({
                    title: "No seleccionó " + criterias.value.length + " criterios, esta seguro(a) que desea continuar?",
                    text: "Al no seleccionar un criterio u observación general, la propuestas sera marcada como 'Rechazada'",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok!",
                }).then((res) => {
                    if (res.isConfirmed) {
                        isLoading.value = true;

                        const formData = useForm({
                            datos: [],
                        })

                        for (let i = 0; i < criterias.value.length; i++) {
                            formData.datos[i] = ({ assessment_criteria_id: criterias.value[i].criteria, proposal_id: props.proposal.id, observations: document.getElementById(criterias.value[i].observation).value })
                        }

                        axios.post(route('criterias.store', formData.data()))
                            .then(function (response) {
                                console.log(response)
                                post()
                            })
                    }
                });
            }

        };

        const post = () => {

            form.state_id = criterias.value.length ? 3 : 1
            form.put(route('proposals.updateReview', props.proposal.id))

        }

        const remove = (arr, cb) => arr.filter(item => !cb(item));

        const isCriteria = idCriteria => row => row.criteria === idCriteria;

        const checked = (isChecked, idObservation, idCriteria) => {
            let checkedArray = criterias.value
            console.log(criterias.value)
            const isCriteriaChecked = isCriteria(idCriteria);


            if (!isChecked) {
                checkedArray.push({ observation: idObservation, criteria: idCriteria })
                document.getElementById(idObservation).disabled = false;
                document.getElementById(idObservation).value = "";

            }
            else {
                checkedArray = remove(checkedArray, isCriteriaChecked);
                document.getElementById(idObservation).value = "Si cumple";
                document.getElementById(idObservation).disabled = true;
            }

            criterias.value = checkedArray;
            console.log(criterias.value)

        };


        const criterias = ref([]);

        const form = useForm({
            ...props.proposal
        })

        const checkedRows = ref([]);

        const linea = ['Linea 1', 'Linea 2', 'Linea 3']

        const errors = ref([]);

        const hasErrors = computed(() => errors.value.length > 0);

        return { criterias ,checked, submit, isLoading, form, mdiBallotOutline, mdiInformation, mdiAccount, mdiMail, mdiOpenInNew, mdiGithub, linea, hasErrors, errors }
    },
    mounted(){
        let checkedArray = []

        this.convocatoria.assesstment_criterias.forEach(element => {
            checkedArray.push({ observation: element.name + element.value, criteria: element.id })
        });
        
        this.criterias = checkedArray 
    }

}
</script>

<template>
    <LayoutMain :title="titulo">

    <div class="vl-parent">
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
    </div>

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
                <Tab title="Documentacion">
                    <div class="p-4" v-for="(item, index) in convocatoria.documents_supporting" :key="index">
                        <FormField :label="item.name">
                            <BaseButton color="info" :label="'Abrir ' + item.name + '.pdf'" :icon="mdiOpenInNew" />

                            <button @click="getPdf(item.name)"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex justify-center items-center">
                                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                                </svg>
                                <span>Descargar '{{ item.name }}'.pdf </span>
                            </button>
                        </FormField>
                    </div>
                </Tab>

                <Tab title="Informacion general de la propuesta">

                    <ol class="relative border-l border-gray-200 dark:border-gray-700">
                        <li class="m-6">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Titulo de la propuesta</h3>
                            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">{{ form.title }}.</p>

                        </li>
                        <li class="m-6">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Linea de investigacion
                            </h3>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{ form.line_research }}</p>
                        </li>
                        <li class="m-6">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Resumen</h3>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">Deliver great service
                                experiences fast -
                                without the complexity of traditional ITSM solutions.Accelerate critical development work,
                                eliminate toil, and deploy changes with ease, with a complete audit trail for every change.
                            </p>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Descripcion
                                general de la convocatoria. Min 1000 caracteres. Max 4000 caracteres</time>
                        </li>

                        <li class="m-6">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Planteamiento del problema</h3>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{ form.problem_statement }}
                            </p>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Describle
                                la problematica que se abordara. Min 500 caracteres. Max 3000 caracteres</time>
                        </li>

                        <li class="m-6">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Justificacion</h3>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{ form.justification }}
                            </p>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Justifica
                                la realizacion del proyecto. Min 500 caracteres. Max 3000 caracteres</time>
                        </li>

                        <li class="m-6">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Antecedentes de la propuestas
                            </h3>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{ form.background }}
                            </p>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Si la
                                propuesta es la continuacion de una investigacion previamente apoyada, favor de mencionarlo.
                                Min 500 caracteres. Max 3000 caracteres</time>
                        </li>

                        <li class="m-6">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Experiencia de los responsables
                            </h3>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{
                                form.technical_manager_experience }}
                            </p>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Describe la
                                experienca similar en proyectos previos del responsable tecnico y el personal clabe de la
                                Propuesta Min 500 caracteres. Max 4000 caracteres</time>
                        </li>

                        <li class="m-6">
                            <div
                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Capacidades de los responsables
                            </h3>
                            <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{
                                form.capcities }}
                            </p>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Describe
                                las capacidades con las que cuenta para desarrollar el proyecto de investigacion Min 500
                                caracteres. Max 4000 caracteres</time>
                        </li>


                    </ol>
                    <!-- 
                                                                                                                                                                                                                                                    <FormField label="Objetivo general" help="Min 100 caracteres. Max 1000 caracteres">
                                                                                                                                                                                                                                                        <FormControl v-model="form.general_objective" type="textarea"
                                                                                                                                                                                                                                                            placeholder="Describe claro y preciso, la finalidad de la investigación, qué se " />
                                                                                                                                                                                                                                                    </FormField>

                                                                                                                                                                                                                                                    <FormField label="Objetivos específicos" help="Min 100 caracteres. Max 2000 caracteres">
                                                                                                                                                                                                                                                        <FormControl v-model="form.specific_objective" type="textarea"
                                                                                                                                                                                                                                                            placeholder="Describe las metas, medibles y alcanzables durante el desarrollo del proyecto, deben ser presentadas de manera clara, concreta y concisa." />
                                                                                                                                                                                                                                                    </FormField>

                                                                                                                                                                                                                                                    <FormField label="Revisión de la literatura" help="Min 1000 caracteres. Max 4000 caracteres">
                                                                                                                                                                                                                                                        <FormControl type="textarea"
                                                                                                                                                                                                                                                            placeholder="Describe los resultados obtenidos de otros estudios similares previos" />
                                                                                                                                                                                                                                                    </FormField>

                                                                                                                                                                                                                                                    <FormField label="Grado de novedad científica" help="Min 500 caracteres. Max 4000 caracteres">
                                                                                                                                                                                                                                                        <FormControl v-model="form.differentiators" type="textarea"
                                                                                                                                                                                                                                                            placeholder="Enumera los puntos modulares que evidencien el grado de novedad científica, contenido innovador, originalidad y relevancia científica" />
                                                                                                                                                                                                                                                    </FormField>

                                                                                                                                                                                                                                                    <FormField label="Beneficios de la propuesta" help="Min 500 caracteres. Max 3000 caracteres">
                                                                                                                                                                                                                                                        <FormControl v-model="form.benefits" type="textarea"
                                                                                                                                                                                                                                                            placeholder="Describe al menos uno de los elementos que se beneficiarán con la implementación del proyecto de innovación" />
                                                                                                                                                                                                                                                    </FormField>

                                                                                                                                                                                                                                                    <FormField label="Principales resultados esperados" help="Min 500 caracteres. Max 3000 caracteres">
                                                                                                                                                                                                                                                        <FormControl v-model="form.expected_results" type="textarea"
                                                                                                                                                                                                                                                            placeholder="Describe el conocimiento de frontero esperado, Indicar los resultados novedosos" />
                                                                                                                                                                                                                                                    </FormField>

                                                                                                                                                                                                                                                    <FormField label="Entregables comprometidos" help="Min 100 caracteres. Max 2000 caracteres">
                                                                                                                                                                                                                                                        <FormControl type="textarea" v-model="form.expected_results_review"
                                                                                                                                                                                                                                                            placeholder="Especifica cuales son los entregables comprometidos como resultado del proyecto de investigación" />
                                                                                                                                                                                                                                                    </FormField>

                                                                                                                                                                                                                                                    <FormField label="Producto que se compromete a entregar">
                                                                                                                                                                                                                                                        <FormControl :options="linea" />
                                                                                                                                                                                                                                                    </FormField>

                                                                                                                                                                                                                                                    <FormField label="Propiedad intelectual" help="Min 500 caracteres. Max 4000 caracteres">
                                                                                                                                                                                                                                                        <FormControl v-model="form.ownership_proposal" type="textarea"
                                                                                                                                                                                                                                                            placeholder="Descripción de los porcentajes de Uularidad de lo propiedad intelectual y de la propuesto de explotación de los derechos en caso de existir" />
                                                                                                                                                                                                                                                    </FormField>

                                                                                                                                                                                                                                                    <FormField label="Referencias" help="Min 500 caracteres. Max 4000 caracteres">
                                                                                                                                                                                                                                                        <FormControl v-model="form.products_generated" type="textarea" placeholder="Referencias..." />
                                                                                                                                                                                                                                                    </FormField> -->
                </Tab>

                <Tab title="Revisión de criterios">
                    <NotificationBar color="info" :icon="mdiInformation" :outline="true">
                        <b>Seleccione los criterios que bajo su evaluacion estan siendo respetados en esta propuesta</b>.
                        <br> Los criterios seleccionados seran marcados como cumplidos, los no seleccionados
                        seran enviados de vuelta al postulante en conjunto con las observaciones, y la propuestas entrara
                        en estado de "rechazada" hasta que cumpla con lo indicado.

                    </NotificationBar>

                    <table class="border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr>
                                <th v-if="true" />
                                <th>Nombre</th>
                                <th>Peso</th>
                                <th>Obvservaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in convocatoria.assesstment_criterias" :key="item.id">
                                <TableCheckboxCell @checked="checked($event, item.name + item.value, item.id)" />

                                <td data-label="Name">
                                    {{ item.name }}
                                </td>

                                <td data-label="Peso" class="lg:w-32">
                                    <progress class="flex w-2/5 self-center lg:w-full" max="100" :value="item.value">
                                        {{ item.value }}
                                    </progress>
                                </td>
                                <td data-label="Obvservaciones">
                                    <form-field label=""
                                        help="las observaciones estan desabilitadas para los criterios seleccionados">
                                        <FormControl :id="item.name + item.value" type="textarea"  />
                                    </form-field>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <base-divider></base-divider>


                    <FormField label="Obvservaciones generales" help="Min 500 caracteres. Max 3000 caracteres">
                        <FormControl type="textarea"
                            placeholder="De ser el caso, indicar posibles errores en la documentacion o informacion de la propuestas" />
                    </FormField>

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
