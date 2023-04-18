<script setup>
import Navbar from "./navbar.vue";
</script>

<template>
    <main>
        <header>
            <Navbar/>


        </header>
        <article class="mt-6 ml-6 py-2">
            <slot />
        </article>
    </main>
</template>
