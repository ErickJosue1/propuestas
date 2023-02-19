<template>
    <div>
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: {
        title: { required: true },
        isActive: { required: true, default: false }
    }
}
</script>

<style></style>