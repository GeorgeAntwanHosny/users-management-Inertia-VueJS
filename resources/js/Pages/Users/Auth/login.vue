<template>
    <Head title="Create User"/>

    <h1 class="text-3xl">Login</h1>

    <form @submit.prevent="submit" class="max-w-md mx-auto mt-8">


        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email"> Email </label>

            <input v-model="form.email" class="border border-gray-400 p-2 w-full" type="email" name="email" id="email"
                   required/>

            <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-1"></div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="password"> Password </label>

            <input
                v-model="form.password"
                class="border border-gray-400 p-2 w-full"
                type="password"
                name="password"
                id="password"
            />

            <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-1"></div>
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
    name: "login",
    setup() {
        const form = useForm({
            email: '',
            password:''
        })
        return {form}
    },
    methods: {
        async submit() {
            await router.post('/auth/login', this.form.data(), {
                errorBag: 'auth.login.validation',
                preserveScroll: true,
                onError: async (response) => {
                    const {email, password} = response
                    this.form.errors = {email, password};
                }
            });
        },
    },
}
</script>
<style scoped>

</style>
