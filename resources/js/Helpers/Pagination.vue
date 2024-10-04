<template>
    <component
            v-for="l in links.links"
            :key="l.label"
            :is="!l.active ? Link : 'span'"
            class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 ml-2"
            :class="!l.active ? '' : 'cursor-pointer text-gray-500'"
            :href="l.url !== null ? l.url : '#'"
            v-html="l.label"
    />
</template>

<script setup>
    import {Link} from "@inertiajs/vue3"
    import { defineProps } from "vue";

    const props = defineProps({
        links: Object
    })
</script>