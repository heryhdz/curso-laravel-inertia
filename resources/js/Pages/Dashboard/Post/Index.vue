<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Pagination from '@/Helpers/Pagination.vue';
    import {Link} from "@inertiajs/vue3";

    import { ref } from 'vue';

    import Modal from '@/Components/Modal.vue';
    import ConfirmationModal from '@/Components/ConfirmationModal.vue';

    const props = defineProps({
        posts: Object
    })

    const confirmDeleteActive = ref(false)
    const deletePostRow = ref(null)

    function deletePost () {
        const response = axios.delete(route('post.destroy',deletePostRow.value))
        console.log('eliminar post:', deletePostRow.value)
    }

    const openModal = (postId) => {
        confirmDeleteActive.value = true
        deletePostRow.value = postId
    }
</script>

<template>
    <!-- <Modal :show="true">
            <p>Hola desde vue, funciona</p>
    </Modal> -->
    <ConfirmationModal :show="confirmDeleteActive">

        <template v-slot:title>
           Confirmation
        </template>

        <template v-slot:content>
            <p class="p-4">Are you sure want to delete the record?</p>
        </template>

        <template v-slot:footer>
            <div class="flex flex-row-reverse gap-2 bg-gray-100 p-3">
                <button class="bg-red-700 text-white text-sm rounded-md p-2" @click="deletePost">Delete</button>
                <button class="bg-green-700 text-white text-sm rounded-md p-2" @click="confirmDeleteActive=false">Cancel</button>
            </div>
        </template>
            
    </ConfirmationModal>
    <AppLayout>
        <div class="container w-4/5 m-auto">
            <div class="card">
                <Link class="link-button-default" :href="route('post.create')">Create</Link>
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
                        <tr class="border-b" v-for="p in posts.data" :key="p.id">
                            <td class="p-2">{{ p.id }}</td>
                            <td class="p-2">{{ p.title }}</td>
                            <td class="p-2">{{ p.slug }}</td>
                            <td class="p-2">
                                <Link class="text-sm text-purple-400 hover:text-purple-700" :href="route('post.edit',p.id)">Edit</Link>
                                <!-- <Link  method="DELETE" as="button" type="button" class="text-sm text-red-400 hover:text-red-700 ml-2" :href="route('post.destroy',p.id)">Delete</Link> -->
                                <button class="bg-red-500 text-white text-sm rounded-md px-2 ml-3" @click="openModal(p.id)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <Pagination :links="posts"/>
            </div>

            <!-- <template v-for="l in categories.links" :key="l">
                <Link v-if="!l.active" class="px-2 py-1" :href="l.url" v-html="l.label"/>
                <span v-else class="px-2 py-1 cursor-pointer text-gray-500" v-html="l.label"/>
            </template> -->
        </div>
    </AppLayout>
</template>