<template>
    <div>

        <Head title="Family Units" />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <!-- Table Actions -->
        <div class="flex items-center justify-between mb-6">
            <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
            </search-filter>
            <Link v-if="auth.user.user_type === 'gn'" class="btn btn-primary" :href="route('family_units.create')">
            <span>Add</span>
            </Link>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Reference ID</th>
                    <th class="pb-4 pt-6 px-6">Status</th>
                    <th class="pb-4 pt-6 px-6">House Holder</th>
                    <th class="pb-4 pt-6 px-6">Address</th>
                    <th class="pb-4 pt-6 px-6">No of Members</th>
                </tr>
                <tr v-for="family_unit in family_units.data" :key="family_unit.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <div class="table-cell-inner">
                            <Link class="link" :href="route('family_units.show', family_unit.id)
                                ">
                            {{ family_unit.family_unit_ref }}
                            </Link>
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            <span :class="`px-4 py-2 rounded-lg text-xs font-medium ${statusColors[family_unit.status_id]
                                }`">
                                {{ family_unit.status_string }}
                            </span>
                        </div>
                    </td>
                    <td class="border-t">
                        <div v-if="family_unit.primary_member" class="table-cell-inner">
                            <Link :href="`/family-units/${family_unit.id}/members/${family_unit.primary_member.id}`">
                            {{ family_unit.primary_member.full_name }}
                            </Link>
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner text-xs" v-html="family_unit.full_address_html"></div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ family_unit.member_count }}
                        </div>
                    </td>
                </tr>
                <tr v-if="family_units.data.length === 0">
                    <td class="px-6 py-4 border-t" colspan="4">
                        No family units found.
                    </td>
                </tr>
            </table>
        </div>
        <pagination class="mt-6" :links="family_units.links" />
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
        auth: Object,
        filters: Object,
        family_units: Object,
        members: Object,
        status_list: Object,
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
            statusColors: {
                1: "bg-blue-200", // New
                2: "bg-blue-200", // Viewed
                3: "bg-amber-200", // Pending Approval
                4: "bg-green-200", // Approved
                5: "bg-red-200", // Rejected
                6: "bg-lime-200", // Paid
            },
        };
    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get("/family-units", pickBy(this.form), {
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
