<template>
    <div>
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent"
                role="tablist">
                <li v-for="(tab, index) in tabs" :key="index" class="mr-2" role="presentation">
                    <button @click="activeTab = tab.tab" :class="{ 'border-b-2': activeTab === tab.tab }"
                        class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="dashboard-tab" data-tabs-target="#dashboard" type="button" aria-selected="false">{{ tab.name
                        }}</button>
                </li>
            </ul>
        </div>
        <div>
            <slot :name="activeTab"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        tabs: { required: true },
        activeTab: { required: true }
    },
    mounted(){
        console.log(this.tabs); 
    }
}
</script>
