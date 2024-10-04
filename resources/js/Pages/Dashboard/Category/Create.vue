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
        errors: Object
    })

    const form = useForm({
        title: null,
        slug: null
    })

    function submit(){
        Inertia.post(route('category.store',form))
    }
</script>

<template>
    <AppLayout>
        <FormSection @submitted="submit" class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <template #title>
                Create Category
            </template>
            <template #description>
                Create Category
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
            </template>
            <template #actions>
                <PrimaryButton class="mt-1" type="submit">
                        Send
                </PrimaryButton>
            </template>
        </FormSection>
    </AppLayout>
</template>

<style lang="scss" scoped>

</style>