<template>
    <Head title="Create User"/>

    <h1 class="text-3xl">update User data</h1>

    <form @submit.prevent="submit" class="max-w-md mx-auto mt-8">
        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="name"> Name </label>

            <input v-model="form.name" class="border border-gray-400 p-2 w-full" type="text" name="name" id="name"/>
            <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-1"></div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email"> Email </label>

            <input v-model="form.email" class="border border-gray-400 p-2 w-full" type="email" name="email" id="email"
                   required/>

            <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-1"></div>
        </div>


        <div class="mb-6">
            <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
                    :disabled="form.processing">Submit
            </button>
        </div>
    </form>


</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";
import {router} from '@inertiajs/vue3'

export default {
    name: "edite",
    props: {
        user: {
            type: Object,
            required: true,
        },
    },
    setup(props) {
        const form = useForm({
            name: props.user.name,
            email: props.user.email,

        })

        return {form}

    },
    methods: {
        async submit() {
            await router.post(`/users/${this.user.id}/edit`, this.form.data(), {
                errorBag: 'users.update.validation',
                preserveScroll: true,
                onError: async (response) => {
                    const {name, email} = response
                    this.form.errors = {name, email};
                }
            });


        },
    },
}
</script>

<style scoped>

</style>
