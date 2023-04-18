<template>
    <Head title="Users List"/>

    <div class="flex  mb-6 p-2">
        <div class="flex items-center mr-16">
            <h1 class="text-3xl">Users</h1>

        </div>

        <input @input="debounceSearch" v-model="search" type="text" placeholder="Search..."
               class="border px-2 rounded-lg"/>
    </div>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto ">
            <div class="py-2 align-middle inline-block min-w-full sm:px-4 lg:px-6">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="user in users.data" :key="user.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ user.name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!--                            TODO check if the user can edit or not-->
                            <td
                                v-if="this.getAuthUser?.username && user.can.edit"
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link :href="`/users/${user.id}/edit`" class="text-indigo-600 hover:text-indigo-900">
                                    Edit
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">

            <Pagination
                :links="users.links"
                :prev="users.prev_page_url"
                :next="users.next_page_url"
                :from="users.from"
                :to="users.to"
                :total="users.total"/>
        </div>
    </div>

</template>

<script>
import Pagination from "../../Shared/Pagination.vue";
import route from 'ziggy';
import debounce from "lodash/debounce";
import {usePage} from "@inertiajs/vue3";

export default {
    components: {'Pagination': Pagination},
    name: 'Users/index',
    props: {
        users: Array,
        filters: Object,
    },
    data() {
        return {
            search: String
        }
    },
    mounted() {
        if (this.filters.search === undefined) {
            this.search = '';
        } else {
            this.search = this.filters.search;
        }
        this.debounceSearch = debounce(() => {
            this.sendSearch();
        }, 600);

    },

    methods: {
        async sendSearch() {
            const url = route('users.index', {
                _query: {
                    search: this.search,
                },
            });
            await this.$inertia.get(url, {}, {preserveState: true, replace: true});
        },

    },
    computed:{
        getAuthUser(){
            return usePage().props.auth?.user
        }


    }

}


</script>

<style scoped>

</style>
