<script setup>

    import { Inertia } from '@inertiajs/inertia'
    import {useForm} from "@inertiajs/vue3"
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormSection from '@/Components/FormSection.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    const props = defineProps({
        errors: Object,
        post: Object,
        categories: Object
    })

    const form = useForm({
        id: props.post.id,
        title: props.post.title,
        slug: props.post.slug,
        date: props.post.date,
        description: props.post.description,
        text: props.post.text,
        type: props.post.type,
        posted: props.post.posted,
        category_id: props.post.category_id,
        image: ""      
    })

    function submit(){
        Inertia.put(route('post.update',form.id),form)
    }

    function upload(){
        Inertia.post(route('post.upload', form.id),form)
    }
</script>

<template>
    <AppLayout>
        <FormSection @submitted="submit" class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <template #title>
                Edit Post
            </template>
            <template #description>
                Edit Post
            </template>
            <template #form>
                <div class="col-span-6">
                    <InputLabel for="">Title</InputLabel>
                    <InputError :message="errors.title"/>
                    <TextInput class="w-full mt-1" type="text" v-model="form.title"/>
                </div>

                <div class="col-span-6">
                    <InputLabel for="">Slug</InputLabel>
                    <InputError :message="errors.slug"/>
                    <TextInput class="w-full mt-1" type="text" v-model="form.slug"/>
                </div>

                <div class="col-span-6">
                    <InputLabel for="">Date</InputLabel>
                    <InputError :message="errors.text"/>
                    <TextInput class="w-full mt-1" type="date" v-model="form.date"/>
                </div>

                <div class="col-span-6">
                    <InputLabel for="">Text</InputLabel>
                    <InputError :message="errors.text"/>
                    <textarea class="rounded-md w-full border-gray-300" v-model="form.text"></textarea>
                </div>

                <div class="col-span-6">
                    <InputLabel for="">Decription</InputLabel>
                    <InputError :message="errors.description"/>
                    <textarea class="rounded-md w-full border-gray-300" v-model="form.description"></textarea>
                </div>

                <div class="col-span-6">
                    <InputLabel for="">Posted</InputLabel>

                    <select class="rounded-md w-full border-gray-300" v-model="form.posted">
                        <option value="not">No</option>
                        <option value="yes">Yes</option>
                    </select>

                    <InputError :message="errors.posted"/>
                    
                </div>

                <div class="col-span-6">
                    <InputLabel for="">Type</InputLabel>

                    <select class="rounded-md w-full border-gray-300" v-model="form.type">
                        <option value="adverd">Adverd</option>
                        <option value="post">Post</option>
                        <option value="course">Course</option>
                        <option value="movie">Movie</option>
                    </select>

                    <InputError :message="errors.type"/>
                    
                </div>

                <div class="col-span-6">
                    <InputLabel for="">Category</InputLabel>

                    <select class="rounded-md w-full border-gray-300" v-model="form.category_id">
                        <option v-for="c in categories" :value="c.id" :key="c.id">{{ c.title }}</option>
                    </select>

                    <InputError :message="errors.category_id"/>
                    
                </div>
            </template>
            <template #actions>
                <PrimaryButton class="mt-1" type="submit">
                        Send
                </PrimaryButton>
            </template>
        </FormSection>

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <InputLabel for="">Image</InputLabel>
                            <InputError :message="errors.image"/>
                            <TextInput class="w-full mt-1" type="file" @input="form.image = $event.target.files[0]" v-model="form.image"/>
                        </div>
                        <div>
                            <PrimaryButton class="mt-3" @click="upload">
                                Send
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style lang="scss" scoped>

</style>