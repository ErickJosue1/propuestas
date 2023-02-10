<script setup>

import SectionMain from "@/components/SectionMain.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";


</script>

<template>
    <LayoutAuthenticated>

        <Head title="Dashboard" />
        <SectionMain>
            <slot />

        </SectionMain>
    </LayoutAuthenticated>
</template>
