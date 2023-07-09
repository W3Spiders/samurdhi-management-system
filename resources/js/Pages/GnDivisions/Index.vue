<template>
    <div>
        <Head title="GN Divisions" />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <!-- Table Actions -->
        <div class="flex items-center justify-between mb-6">
            <search-filter
                v-model="form.search"
                class="mr-4 w-full max-w-md"
                @reset="reset"
            >
            </search-filter>
            <Link class="btn btn-primary" :href="route('gn_divisions.create')">
                <span>Add</span>
            </Link>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6 w-[150px]">GN Division No</th>
                    <th class="pb-4 pt-6 px-6">GN Division Name</th>
                    <th class="pb-4 pt-6 px-6">Ward No</th>
                    <th class="pb-4 pt-6 px-6">Ward Name</th>
                </tr>
                <tr
                    v-for="gn_division in gn_divisions.data"
                    :key="gn_division.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100"
                >
                    <td class="border-t w-[150px]">
                        <div class="table-cell-inner">
                            <Link
                                :href="
                                    route('gn_divisions.show', gn_division.id)
                                " class="link"
                            >
                            {{ gn_division.gn_division_no }}
                            </Link>
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ gn_division.gn_division_name }}
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ gn_division.ward?.ward_no }}
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ gn_division.ward?.ward_name }}
                        </div>
                    </td>
                </tr>
                <tr v-if="gn_divisions.data.length === 0">
                    <td class="px-6 py-4 border-t" colspan="4">
                        No Grama Niladhari Divisions found.
                    </td>
                </tr>
            </table>
        </div>

        <pagination class="mt-6" :links="gn_divisions.links" />
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
        gn_divisions: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
            breadcrumb_items: [
                {
                    text: "GN Divisions",
                    link: "",
                },
            ],
        };
    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get("/gn-divisions", pickBy(this.form), {
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
