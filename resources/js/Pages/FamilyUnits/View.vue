<template>
    <Head title="Family Unit View" />

    <breadcrumb :items="breadcrumb_items"></breadcrumb>

    <!-- Members Table -->
    <!-- Table -->
    <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <tr>
                <th class="table-header-cell">Full Name</th>
                <th class="table-header-cell">National ID</th>
                <th class="table-header-cell">Gender</th>
                <th class="table-header-cell">Marital Status</th>
                <th class="table-header-cell">Has Income</th>
            </tr>

            <tr
                v-for="member in family_unit.members"
                :key="member.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ member.full_name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ member.nic }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ member.gender_string }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ member.marital_status }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ member.has_income_string }}
                    </div>
                </td>
            </tr>

            <tr v-if="family_unit.members.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">No members.</td>
            </tr>
        </table>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Shared/Layout";
import Breadcrumb from "@/Shared/Breadcrumb";

export default {
    components: { Head, Breadcrumb, Link },
    layout: Layout,
    props: {
        family_unit: Object,
    },
    data() {
        return {
            breadcrumb_items: [
                {
                    text: "Family Units",
                    link: "/family_units",
                },
                {
                    text: "Family Unit ID",
                    link: "",
                },
            ],
        };
    },
};
</script>
