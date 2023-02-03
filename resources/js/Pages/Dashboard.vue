<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Inicio">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inicio
            </h2>
        </template>

        <!--         {{ $page.props }}
 -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
                <div class="bg-white pb-4 px-4 rounded-md w-full">

                </div>
            </div>
        </div>
    </AppLayout>
</template>
