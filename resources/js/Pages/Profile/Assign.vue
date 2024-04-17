<script>
import axios from 'axios';
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub, mdiEye } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import TableCheckboxCell from "@/components/TableCheckboxCell.vue";
import Pagination from '@/Shared/Pagination.vue';
import { ref, computed, reactive } from 'vue';
import Swal from "sweetalert2";

export default {
    props: {
        titulo: { type: String, required: true },
        roles: { type: Object, required: true },
        permissions: { type: Object, required: true },
        user: { type: Object, required: true },
        user_roles: { required: true },
        user_permissions: { required: true },
        permissions: { type: Object, required: true },
    },
    data() {
        return {
            selectedRole: null,
            mdiBallotOutline,
            mdiAccount,
            mdiMail,
            mdiGithub,
            mdiEye
        };
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        SectionTitleLineWithButton,
        CardBox,
        TableCheckboxCell,
        Pagination
    },
    methods: {
        assignRole() {

        },
    },
    setup(props) {
        const form = useForm({
            roles: [],
            permissions: [],
            rRoles: [],
            rPermissions: []
        })
        const checkedRoles = ref([]);
        const checkedPermissions = ref([]);

        const unCheckedRoles = ref([]);
        const unCheckedPermissions = ref([]);

        const remove = (arr, cb) => arr.filter(item => !cb(item));

        const isDataName = row => data => row.name === data;

        const checked = (isChecked, data, type) => {

            const isNameChecked = isDataName(data);

            let checkedArray = type ? checkedRoles.value : checkedPermissions.value;

            let unCheckedArray = type ? unCheckedRoles.value : unCheckedPermissions.value;


            if (type) {

                if (isChecked) {
                    if (unCheckedRoles.value.length > 0 && unCheckedArray.find(item => item == data.name) != null) {
                        unCheckedArray = remove(unCheckedArray, isNameChecked);
                        unCheckedRoles.value = unCheckedArray;
                    }
                    else {
                        checkedArray.push(data.name);
                        checkedRoles.value = checkedArray;
                    }
                }
                else {
                    if (checkedRoles.value.length > 0 && checkedArray.find(item => item == data.name) != null) {
                        checkedArray = remove(checkedArray, isNameChecked);
                        checkedRoles.value = checkedArray;
                    }
                    else {
                        unCheckedArray.push(data.name);
                        unCheckedRoles.value = unCheckedArray;
                    }
                }

            }
            else {
                if (isChecked) {
                    if (unCheckedPermissions.value.length > 0 && unCheckedArray.find(item => item == data.name) != null) {
                        unCheckedArray = remove(unCheckedArray, isNameChecked);
                        unCheckedPermissions.value = unCheckedArray;
                    }
                    else {
                        checkedArray.push(data.name);
                        checkedPermissions.value = checkedArray;
                    }
                }
                else {
                    if (checkedPermissions.value.length > 0 && checkedArray.find(item => item == data.name) != null) {
                        checkedArray = remove(checkedArray, isNameChecked);
                        checkedPermissions.value = checkedArray;
                    }
                    else {
                        unCheckedArray.push(data.name);
                        unCheckedPermissions.value = unCheckedArray;
                    }
                }
            }


        };

        const submit = () => {

            form.roles = checkedRoles.value;
            form.permissions = checkedPermissions.value;
            form.rRoles = unCheckedRoles.value;
            form.rPermissions = unCheckedPermissions.value;

            if (form.roles.length == 0 && form.permissions.length == 0 && form.rRoles.length == 0 && form.rPermissions.length == 0) {
                Swal.fire({
                    title: "No hay nada que hacer",
                    text: "No ha hecho ninguna modificacion",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok",
                })
            } else {


                console.log(form.data())

                form.post(route('profile.assignRole', props.user.id))
            }


        }


        return { submit, checked, form };
    },
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="titulo" main>
            <a :href="route('profile.index')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg></a>
        </SectionTitleLineWithButton>



        <CardBox :hasTable="true" form @submit.prevent="assignRole">
            <SectionTitleLineWithButton class="pl-8 pt-6" :title="`Roles`" main>
            </SectionTitleLineWithButton>
            <hr>

            <table class="border-gray-200 dark:border-gray-700">
                <thead>
                    <tr>
                        <th v-if="true" />
                        <th>Nombre</th>
                        <th />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in roles" :key="role.id">
                        <TableCheckboxCell @checked="checked($event, role, true)" :value="user_roles[role.name]"
                            v-if="true" />

                        <td data-label="Name">
                            {{ role.name }}
                        </td>
                        <td class="before:hidden lg:w-1 whitespace-nowrap">
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton color="info" :icon="mdiEye" small />
                            </BaseButtons>
                        </td>
                    </tr>
                </tbody>
            </table>

            <SectionTitleLineWithButton class="pl-8 pt-8" :title="`Permisos`" main>
            </SectionTitleLineWithButton>
            <hr>

            <table>
                <thead>
                    <tr>
                        <th v-if="true" />
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Guard Name</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in permissions.data" :key="item.id">
                        <TableCheckboxCell @checked="checked($event, item, false)" :value="user_permissions[item.name]"
                            v-if="true" />
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Descripcion">
                            {{ item.description }}
                        </td>
                        <td data-label="Guard Name">
                            {{ item.guard_name }}
                        </td>

                    </tr>
                </tbody>
            </table>



            <Pagination :currentPage="permissions.current_page" :links="permissions.links"
                :total="permissions.links.length - 2">
            </Pagination>
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="submit()" type="submit" color="info" label="Crear" />
                    <BaseButton :href="route('profile.index')" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>
