<script>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import axios from "axios";
import { computed, onMounted, reactive, ref, toRefs, watch } from "vue";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import Swal from "sweetalert2";




export default {
    props: {
        roles: { type: Object, required: true },
        workplaces: { type: Object, required: true },
        colonies: { type: Object, required: true },
    },
    components: {
        axios,
        AuthenticationCardLogo,
        Head,
        Link,
        PrimaryButton,
        InputError,
        Loading
    },
    setup(props) {
        const isLoading = ref(false);
        const fullPage = true;

        const submit = () => {
            isLoading.value = true;
            form.post(route('register'), {
                onSuccess: (e) => {
                    form.reset()
                    cp.postal_code = {
                        cp: "",
                        township: "",
                        colony: "",
                        state: ""
                    }
                    isLoading.value = false;

                },
                onFinish: () => {
                    isLoading.value = false;
                    form.reset(fields('password' | 'password_confirmation'))
                }
            });
        };

        const cp = reactive({
            postal_code: {
                cp: "",
                township: "",
                colony: [],
                state: ""
            }
        });

        const getData = () => {
            isLoading.value = true;
            axios
                .get(route("renapo.show", form.curp))
                .then((response) => {
                    isLoading.value = false;
                    form.name = response['data']['nombres']
                    form.paternal_surname = response['data']['apellidoPaterno']
                    form.maternal_surname = response['data']['apellidoMaterno']

                })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status == 500) {
                            isLoading.value = false;
                            Swal.fire({
                                title: "Curp Incorrecta!",
                                text: "La curp ingresada no es valida, intente nuevamente",
                                icon: "warning",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Ok!",
                            });
                        }
                    } else if (error.request) {
                        isLoading.value = false;
                        Swal.fire({
                            title: "Error!",
                            text: "Lo sentimos hubo un error, intente nuevamente",
                            icon: "warning",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Ok!",
                        });
                    } else {
                        isLoading.value = false;
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                })

        };

        const getColony = (e) => {
            isLoading.value = true;
            if (cp.postal_code != '') {
                axios
                    .get(route("colony.index", cp.postal_code))
                    .then((response) => {
                        cp.postal_code.township = response['data'][0]['township']['name'];
                        cp.postal_code.colony.push({ id: response['data'][0]['id'], name: response['data'][0]['name'] });
                        cp.postal_code.state = response['data'][1]['name'];
                        isLoading.value = false;
                        console.log(cp.postal_code.colony[0])
                    })
                    .catch(function (error) {
                        if (error.response) {
                            if (error.response.status == 500) {
                                isLoading.value = false;
                                Swal.fire({
                                    title: "CP Incorrecta!",
                                    text: "El codigo postal ingresado no es valido, intente nuevamente",
                                    icon: "warning",
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "Ok!",
                                });
                            }
                        } else if (error.request) {
                            isLoading.value = false;
                            Swal.fire({
                                title: "Error!",
                                text: "Lo sentimos hubo un error, intente nuevamente",
                                icon: "warning",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Ok!",
                            });
                            console.log(error.request);
                        } else {
                            isLoading.value = false;
                            console.log('Error', error.message);
                        }
                        console.log(error.config);
                    })
            }

        };

        const form = useForm({
            name: '',
            paternal_surname: '',
            maternal_surname: '',
            email: '',
            password: '',
            password_confirmation: '',
            curp: '',
            role: "",
            colony_id: '',
            workplace_id: '',
            terms: false,
        });


        return { submit, form, getData, getColony, cp, isLoading, fullPage };
    }
}







</script>

<template>

    <Head title="Register" />

    <!-- <div class="swal-modal" role="dialog" aria-modal="true">
        <div class="swal-icon swal-icon--error">
            <div class="swal-icon--error__x-mark">
                <span class="swal-icon--error__line swal-icon--error__line--left"></span>
                <span class="swal-icon--error__line swal-icon--error__line--right"></span>
            </div>
        </div>
        <div class="swal-title" style="">Error</div>
        <div class="swal-text" style="">Su cuenta no ha sido activada, se le mandó un enlace a su correo para activar.
        </div>
        <div class="swal-footer">
            <div class="swal-button-container">

                <button class="swal-button swal-button--confirm">OK</button>

                <div class="swal-button__loader">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>

            </div>
        </div>
    </div> -->

    <div class="vl-parent">
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="fullPage" />
    </div>



    <div class="min-h-screen flex flex-col sm:justify-center items-center p-6 sm:pt-0 bg-gray-100">
        <div class="pt-2">
            <AuthenticationCardLogo />
        </div>
        <div class="w-full max-w-sm md:max-w-5xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                        Busqueda
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" id="default-search"
                            class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-200 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Busqueda de curp..." v-model="form.curp" required>
                        <button type="submit" formmethod="get" @click="getData"
                            class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2  ">Buscar</button>
                    </div>
                </div>
            </div>

            <InputError class="mb-2" :message="form.errors.curp" />
            <form @submit.prevent="submit">


                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                            Nombre(s)
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                            id="name" type="text" placeholder="Nombre" v-model="form.name">
                        <InputError class="mt-2" :message="form.errors.name" />

                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="paterno">
                            Paterno
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="paterno" type="text" placeholder="Apellido Paterno" v-model="form.paternal_surname">
                        <InputError class="mt-2" :message="form.errors.paternal_surname" />

                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="materno">
                            Materno
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="materno" type="text" placeholder="Apellido Materno" v-model="form.maternal_surname">
                        <InputError class="mt-2" :message="form.errors.maternal_surname" />

                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="role">
                            Rol de registro
                        </label>
                        <div class="relative">
                            <select
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="role" v-model="form.role">
                                <option value="" disabled selected>Selecciona un Rol</option>
                                <option v-for="item in roles" :key="item" :value="item.name">{{ item.name }}</option>
                            </select>

                        </div>
                        <InputError class="mt-2" :message="form.errors.role" />
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                            Email
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="email" type="email" placeholder="correo@ejemplo.com" v-model="form.email">
                        <InputError class="mt-2" :message="form.errors.email" />

                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="password">
                            Contraseña
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="password" type="password" placeholder="******************" v-model="form.password">
                        <InputError class="mt-2" :message="form.errors.password" />

                    </div>

                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="password_conf">
                            Confirmar Contraseña
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="password_conf" type="password" placeholder="******************"
                            v-model="form.password_confirmation">
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="zip">
                            CP
                        </label>
                        <input @change="getColony" v-model="cp.postal_code.cp"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="zip" type="text" placeholder="90210">
                        <p class="text-grey-600 text-xs italic">Ingrese el codigo postal de su residencia para
                            autocompeltar los siguientes campos</p>

                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="state">
                            Estado
                        </label>
                        <input disabled v-model="cp.postal_code.state"
                            class="appearance-none block w-full bg-gray-200 text-gray-800 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="state" type="text" placeholder="">
                    </div>

                </div>
                <div class="flex flex-wrap -mx-3 mb-7">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2"
                            for="township">
                            Municipio
                        </label>
                        <input disabled v-model="cp.postal_code.township"
                            class="appearance-none block w-full bg-gray-200 text-gray-800 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="township" type="text" placeholder="">
                    </div>

                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="colony">
                            Colonia
                        </label>
                        <div class="relative">
                            <select
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="colony" v-model="cp.postal_code.colony">
                                <option value="" disabled selected>Selecciona una colonia</option>
                                <option v-for="item in cp.postal_code.colony" :key="item.id" :value="item.id">{{
                                    item.name
                                }}
                                </option>
                            </select>
                        </div>
                        <InputError class="mt-2" :message="form.errors.colony_id" />
                    </div>

                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="workplace">
                            Centro de trabajo
                        </label>
                        <div class="relative">
                            <select
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="workplace" v-model="form.workplace_id">
                                <option value="" disabled selected>Selecciona un Centro de trabajo</option>
                                <option v-for="item in workplaces" :key="item.id" :value="item.id">{{ item.name }}
                                </option>
                            </select>
                        </div>
                        <InputError class="mt-2" :message="form.errors.workplace_id" />
                    </div>



                </div>
                <div class="w-full md:w-1/3 pr-4 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="other_workplace">
                        Otro Centro de trabajo
                    </label>
                    <div class="relative">
                        <select
                            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="other_workplace">
                            <option value="" disabled selected>Selecciona otro un Centro de trabajo</option>
                            <option v-for="item in workplaces" :key="item.id" :value="item.id">{{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>



                <div class="flex items-center justify-end mt-4">
                    <a class="bg-red-500 hover:bg-red-700 text-white py-1 px-4 rounded">
                        Cancelar
                    </a>

                    <PrimaryButton class="ml-4" @click="submit" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Registrarse
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>


</template>
