<template>
    <div>
        <Head title="Family Units" />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <!-- Table Actions -->
        <div class="flex items-center justify-between mb-6">
            <search-filter
                v-model="form.search"
                class="mr-4 w-full max-w-md"
                @reset="reset"
            >
            </search-filter>
            <Link class="btn btn-primary" href="/contacts/create">
                <span>Create</span>
                <span class="hidden md:inline">&nbsp;Member</span>
            </Link>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">ID</th>
                    <th class="pb-4 pt-6 px-6">Primary Member</th>
                </tr>
                <tr
                    v-for="family_unit in family_units"
                    :key="family_unit.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100"
                >
                    <td class="border-t">
                        <div class="table-cell-inner">
                            <Link
                                :href="`/family-units/${family_unit.id}/view`"
                            >
                                {{ family_unit.id }}
                            </Link>
                        </div>
                    </td>
                    <td class="border-t">
                        <div
                            v-if="family_unit.primary_member"
                            class="table-cell-inner"
                        >
                            <Link
                                :href="`/family-units/${family_unit.id}/members/${family_unit.primary_member.id}`"
                            >
                                {{ family_unit.primary_member.full_name }}
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr v-if="family_units.length === 0">
                    <td class="px-6 py-4 border-t" colspan="4">
                        No family units found.
                    </td>
                </tr>
            </table>
        </div>
        <!-- <pagination class="mt-6" :links="family_units.links" /> -->
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
        family_units: Object,
        members: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
            breadcrumb_items: [
                {
                    text: "Family Units",
                    link: "/family_units",
                },
            ],
        };
    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get("/contacts", pickBy(this.form), {
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
