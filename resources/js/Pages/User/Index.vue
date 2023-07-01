<template>
    <div>
        <Head title="Users" />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <!-- Table Actions -->
        <div class="flex items-center justify-between mb-6">
            <search-filter
                v-model="form.search"
                class="mr-4 w-full max-w-md"
                @reset="reset"
            >
            </search-filter>
            <Link class="btn btn-primary" :href="route('users.create')">
                <span>Add</span>
            </Link>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">User ID</th>
                    <th class="pb-4 pt-6 px-6">Full Name</th>
                    <th class="pb-4 pt-6 px-6">Username</th>
                    <th class="pb-4 pt-6 px-6">Email</th>
                    <th class="pb-4 pt-6 px-6">GN Division No</th>
                    <th class="pb-4 pt-6 px-6">GN Division</th>
                </tr>
                <tr
                    v-for="user in users.data"
                    :key="user.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100"
                >
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ user.id }}
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            <Link :href="route('users.show', user.id)">
                                {{ user.full_name }}
                            </Link>
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ user.username }}
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ user.email }}
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ user.gn_division?.gn_division_no }}
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ user.gn_division?.gn_division_name }}
                        </div>
                    </td>
                </tr>
                <tr v-if="users.data.length === 0">
                    <td class="px-6 py-4 border-t" colspan="4">
                        No users found.
                    </td>
                </tr>
            </table>
        </div>

        <pagination class="mt-6" :links="users.links" />
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Icon from "@/Shared/Icon";
import pickBy from "lodash/pickBy";
import Layout from "@/Shared/Layout";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import Pagination from "@/Shared/Pagination";
import SearchFilter from "@/Shared/SearchFilter";
import Breadcrumb from "@/Shared/Breadcrumb";

export default {
    components: {
        Head,
        Icon,
        Link,
        Pagination,
        SearchFilter,
        Breadcrumb,
    },
    layout: Layout,
    props: {
        filters: Object,
        users: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
            breadcrumb_items: [
                {
                    text: "Users",
                    link: "",
                },
            ],
        };
    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get("/users", pickBy(this.form), {
                    preserveState: true,
                });
            }, 150),
        },
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null);
        },
    },
};
</script>
