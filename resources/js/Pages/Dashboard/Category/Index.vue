<template>
    <AppLayout>   
        <div class="container w-4/5 m-auto">
            <div class="card">
                <Link class="link-button-default" :href="route('category.create')">Create</Link>
                <table class="w-full my-5">
                    <thead class="bg-gray-100">
                        <tr class="border-b">
                            <th class="p-3">Id</th>
                            <th class="p-3">Title</th>
                            <th class="p-3">Slug</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b" v-for="c in categories.data" :key="c.id">
                            <td class="p-2">{{ c.id }}</td>
                            <td class="p-2">{{ c.title }}</td>
                            <td class="p-2">{{ c.slug }}</td>
                            <td class="p-2">
                                <Link class="text-sm text-purple-400 hover:text-purple-700" :href="route('category.edit',c.id)">Edit</Link>
                                <Link  method="DELETE" as="button" type="button" class="text-sm text-red-400 hover:text-red-700 ml-2" :href="route('category.destroy',c.id)">Delete</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <Pagination :links="categories"/>
            </div>

            <!-- <template v-for="l in categories.links" :key="l">
                <Link v-if="!l.active" class="px-2 py-1" :href="l.url" v-html="l.label"/>
                <span v-else class="px-2 py-1 cursor-pointer text-gray-500" v-html="l.label"/>
            </template> -->
        </div>
    </AppLayout>
</template>

<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Pagination from '@/Helpers/Pagination.vue'
    import {Link} from "@inertiajs/vue3"

    const props = defineProps({
        categories: Object
    })

    console.log(props.categories)

</script>