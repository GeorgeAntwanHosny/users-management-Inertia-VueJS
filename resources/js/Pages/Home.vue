<template>

    <h1>my Home Pages</h1>
   <h3>Welcome {{ this.getAuthUser?.username??'please login' }}
       <Link
           v-if="!this.getAuthUser?.username"

           class="text-blue-500 underline"
           href="/auth/login"
       >here</Link>
   </h3>

</template>

<script>

import {Inertia} from "@inertiajs/inertia";
import route from 'ziggy';
import {usePage} from "@inertiajs/vue3";


export default {
    name: "app",

    // props:{
    //     auth:Object,
    // }
    computed:{
        getAuthUser(){
            return usePage().props.auth?.user
        }


    }

}
</script>

<style scoped>

</style>
