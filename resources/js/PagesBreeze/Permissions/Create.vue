<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
    },
    components: {
        AppLayout
    },
    setup() {
        const submit = () => {
            form.post(route('permissions.store'));
        };

        const form = useForm({
            name: '',
            guard_name: '',
            description: '',
            module_key: ''
        });

        return { submit, form }
    }
}
</script>

<template>
    <AppLayout title="Instituciones">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ titulo }}
            </h2>
        </template>

        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
                <div class="bg-white pb-4 px-4 rounded-md w-full mt-6 p-6">
                    <form @submit.prevent="submit">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="name">
                                    Nombre
                                </label>
                                <input v-model="form.name"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                    id="name" type="text" placeholder="Nombre">
                                <!--                                 <InputError class="mt-2" :message="form.errors.name" />-->
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="status">
                                    Guard name
                                </label>
                                <input v-model="form.guard_name"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="status" type="text" placeholder="Guard name">
                                <!--                                 <InputError class="mt-2" :message="form.errors.paternal_surname" />-->
                            </div>

                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="status">
                                    Descripcion
                                </label>
                                <input v-model="form.description"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="status" type="text" placeholder="Descripcion">
                                <!--                                 <InputError class="mt-2" :message="form.errors.paternal_surname" />-->
                            </div>
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="status">
                                    Module Key
                                </label>
                                <input v-model="form.module_key"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="status" type="text" placeholder=" Module Key">
                                <!--                                 <InputError class="mt-2" :message="form.errors.paternal_surname" />-->
                            </div>
                        </div>

                    </form>
                    <div class="inline-flex items-center rounded-md shadow-sm">
                        <a @click="route(`${routeName}index`)"
                            class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">

                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </span>
                            <span>Cancelar</span>
                        </a>
                        <button @click="submit"
                            class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-r-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                            <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </span>
                            <span>Crear</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
