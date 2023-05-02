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
    mdiEye, mdiTrashCan
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import LayoutWelcome from '@/layouts/LayoutWelcome.vue';
import axios from 'axios';


export default {
    props: {
        records: {
            type: Object,
            required: true
        },
    },
    components: {
        Link,
        LayoutMain,
        CardBox,
        TableSampleClients,
        SectionTitleLineWithButton,
        BaseLevel,
        BaseButtons,
        BaseButton,
        CardBoxComponentEmpty,
        Pagination,
        LayoutWelcome
    },
    methods: {
        getPdf(filename, announcement) {
            axios({
                url: '/download-AdPdf/' + (filename + '.pdf') + '/' + announcement,
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
    },
    setup() {

        return {
            mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiEye, mdiTrashCan,
        }
    }

}
</script>

<template>
    <LayoutWelcome>
        <CardBox class="mr-12 mt-24 max-xl:m-4 max-lg:mt-8" v-if="records.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <div v-else class="lg:flex flex-wrap max-lg:p-5 pt-2 p-2 gap-5">
            <div v-for="item in records" :key="item.id" class='flex items-center max-lg:pt-4 xl:max-w-lg'>
                <div class="rounded-xl border p-5 shadow-md  bg-white dark:bg-slate-900">
                    <div class="flex w-full items-center justify-between border-b pb-3">
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-8 rounded-full bg-slate-400 bg-[url('https://i.pravatar.cc/32')]"></div>
                            <div class="text-lg font-bold text-slate-700 dark:text-white">{{ item.name }}
                            </div>
                        </div>
                        <div class="flex items-center space-x-5">
                            <button
                                class="rounded-2xl border bg-blue-200 dark:bg-blue-500 px-3 py-1 text-xs font-semibold">{{
                                    item.num_announcement
                                }}</button>
                            <button
                                class="rounded-2xl border bg-neutral-100 dark:bg-slate-700 px-3 py-1 text-xs font-semibold">{{
                                    item.institutions.name
                                }}</button>
                            <div class="text-xs text-neutral-500 dark:text-white">{{ item.y_announcement }}</div>
                        </div>
                    </div>

                    <div class="mt-4 mb-6">
                        <div class="text-sm dark:text-white text-neutral-600">Aliquam a tristique sapien, nec bibendum
                            urna.
                            Maecenas
                            convallis dignissim turpis, non suscipit mauris interdum at. Morbi sed gravida nisl, a
                            pharetra nulla. Etiam tincidunt turpis leo, ut mollis ipsum consectetur quis. Etiam faucibus
                            est risus, ac condimentum mauris consequat nec. Curabitur eget feugiat massa</div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between text-slate-500 dark:text-white">
                            <div class="flex space-x-4 md:space-x-8">
                                <div class="flex cursor-pointer items-center transition hover:text-slate-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    <a :href="route('login')"> <span>Inscribirse</span></a>
                                </div>
                                <button @click="getPdf('advertising', item.name)" class="flex cursor-pointer gap-2 items-center transition hover:text-slate-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class=" bi bi-cloud-download" viewBox="0 0 16 16">
                                        <path
                                            d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z" />
                                        <path
                                            d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z" />
                                    </svg>
                                    <span>Descargar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutWelcome>
</template>
