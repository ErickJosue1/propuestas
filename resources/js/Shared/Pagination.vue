<template>
    <div v-if="links.length > 3" class="mt-6">
        <ul class="pagination">
            <li v-for="(link, key) in links"
                class="page-item"
                :class="estatus(link)"
                :key="key">

                <Link class="page-link" v-html="link.label" :href="link.url ? link.url : '#'" />

            </li>
        </ul>
    </div>
    <span v-if="total>0" class="text-black-50 ml-auto font-weight-lighter">Usted tiene {{ useNFmt(total, 0) }} registros</span>
</template>

<script>
import { useNFmt } from '@/Hooks/useFormato.js';
import { Link } from '@inertiajs/inertia-vue3';
export default {
    props: { links: Array, total: Number },
    components:{
        Link,
    },
    setup()
    {
        const estatus = (link) => {
            if(link.url===null)
                return 'disabled'
            if(link.active)
                return 'active'
        }
        return { useNFmt, estatus }
    }
}
</script>

