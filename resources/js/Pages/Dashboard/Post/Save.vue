<script setup>

    import { Inertia } from '@inertiajs/inertia'
    import {useForm} from "@inertiajs/vue3"
    import AppLayout from '@/Layouts/AppLayout.vue';
    import FormSection from '@/Components/FormSection.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import { ref, watch } from 'vue';

    //Ckeditor
    import { ClassicEditor, Bold, Essentials, Italic, Mention, Paragraph, Undo, Link, FontFamily, FontSize, List } from 'ckeditor5';
    import { Ckeditor } from '@ckeditor/ckeditor5-vue';
    import 'ckeditor5/ckeditor5.css';

    const props = defineProps({
        errors: Object,
        post: Object,
        categories: Object,
    })

    const dropFiles = ref([])

    const editor = ref(ClassicEditor);
    const editorData = ref('<p>Hello from CKEditor 5 in Vue!</p>');
    const editorConfig = ref({
      plugins: [Bold, Essentials, Italic, Mention, Paragraph, Undo, Link, FontFamily, FontSize],
      toolbar: ['undo', 'redo', '|', 'bold', 'italic', '|','link','|', 'fontFamily', 'fontSize'],
      licenseKey: '<YOUR_LICENSE_KEY>',
      // Otras opciones de configuración...
    });

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
        if(form.id == "") Inertia.post(route("post.store"),form)
        else Inertia.post(route("post.update", form.id), {
            _method: 'put',
            title: form.title,
            date: form.date,
            description: form.description,
            text: form.text,
            type: form.type,
            posted: form.posted,
            category_id: form.category_id,
            image: form.image,
        })
    }

    watch(() => dropFiles, (currentValue, oldValue) => {
        router.post(route("post.upload",props.post.id),{
            "image": currentValue.value[currentValue.value.length -1]
        });
    });
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
                    <!-- <textarea class="rounded-md w-full border-gray-300" v-model="form.description"></textarea> -->
                    <ckeditor
                        v-model="form.description"
                        :editor="editor"
                        :config="editorConfig"
                    />
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

                <!-- <div class="col-span-6">
                    <InputLabel for="">Image</InputLabel>
                    <InputError :message="errors.image"/>
                    <TextInput class="w-full mt-1" type="file" @input="form.image = $event.target.files[0]" v-model="form.image"/>
                </div> -->

                <div class="col-span-6">
                    <InputLabel for="">Image</InputLabel>
                    <o-upload override v-slot="{ onclick }" @input="form.image = $event.target.files[0]" v-model="form.image">
                        <o-button
                            override 
                            tag="button" variant="primary" 
                            @click="onclick"
                            :class="['bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded']"
                        >
                            <o-icon icon="upload" />
                            <span>Click to upload</span>
                        </o-button>
                    </o-upload>
                    <InputError :message="errors.image"/>
                </div>

                <!-- <div class="col-span-6" v-if="post.id">
                    <InputError :message="errors.image"/>
                    <o-upload @input="form.image = $event.target.files[0]" v-model="form.image" multiple drag-drop>
                        <section class="ex-center">
                            <p>
                                <o-icon icon="upload" size="is-large" />
                            </p>
                            <p>Drop your files here or click to upload</p>
                        </section>
                    </o-upload>
                </div> -->
            </template>
            <template #actions>
                <PrimaryButton class="mt-1" type="submit">
                        Send
                </PrimaryButton>
            </template>
        </FormSection>

        <div class="container mb-4" v-if="post.image">
            <div class="card">
                <div class="card-body">
                    <img class="max-w-xs rounded-md shadow-md" :src="'/image/post/' + post.image" alt="">

                    <DangerButton class="mt-4" @click="Inertia.delete(route('post.image-delete',form.id))">Delete</DangerButton>
                    <a :href="'/image/post/' + post.image" download="" class="ml-2 mt-4 link-button-default">Descargar</a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
    input[data-oruga-input="file"] {
        display: none !important;
    }
</style>
