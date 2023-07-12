<template>
    <Head title="Reports" />

    <h1 class="mb-8 text-3xl font-medium">Reports</h1>

    <h2
        class="mb-8 text-xl font-medium underline decoration-sky-500 underline-offset-4"
    >
        Registered Family Units for Samurdhi by GN Division
    </h2>
    <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">GN Division No</th>
                <th class="pb-4 pt-6 px-6">GN Division Name</th>
                <th class="pb-4 pt-6 px-6">Count</th>
            </tr>
            <tr
                v-for="data_row in gn_wise_samurdhi_registered_family_data"
                :key="data_row.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.gn_division_no }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.gn_division_name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.family_units_count }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h2
        class="mt-12 mb-8 text-xl font-medium underline decoration-sky-500 underline-offset-4"
    >
        Registered Members for Elder Allowance by GN Division
    </h2>
    <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">GN Division No</th>
                <th class="pb-4 pt-6 px-6">GN Division Name</th>
                <th class="pb-4 pt-6 px-6">Count</th>
            </tr>
            <tr
                v-for="data_row in gn_wise_elder_allowance_registered_members"
                :key="data_row.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.gn_division_no }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.gn_division_name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.approved_member_count }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h2
        class="mt-12 mb-8 text-xl font-medium underline decoration-sky-500 underline-offset-4"
    >
        Last Month Samurdhi Payment Allocation by GN Division
    </h2>
    <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">GN Division No</th>
                <th class="pb-4 pt-6 px-6">GN Division Name</th>
                <th class="pb-4 pt-6 px-6">Amount</th>
            </tr>
            <tr
                v-for="data_row in gn_wise_samurdhi_payment_allocation_items"
                :key="data_row.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.gn_division_no }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.gn_division_name }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        Rs. {{ getFormattedPrice(data_row.total_amount) }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h2
        class="hidden mt-12 mb-8 text-xl font-medium underline decoration-sky-500 underline-offset-4"
    >
        Last Month Elder Allowance Allocation by GN Division
    </h2>
    <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">GN Division No</th>
                <th class="pb-4 pt-6 px-6">GN Division Name</th>
                <th class="pb-4 pt-6 px-6">Amount</th>
            </tr>
            <tr
                v-for="data_row in gn_wise_elder_allowance_payment_allocation_last_month"
                :key="data_row.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.gn_division_no }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.gn_division }}
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ data_row.member_count }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Shared/Layout";

export default {
    components: {
        Head,
        Link,
    },
    data() {
        return {
            gn_wise_elder_allowance_registered_members:
                this.gn_wise_elder_allowance_registered_member_data,
            gn_wise_samurdhi_payment_allocation_items:
                this.gn_wise_samurdhi_payment_allocation_last_month,
        };
    },
    props: {
        gn_wise_samurdhi_registered_family_data: Array,
        gn_wise_elder_allowance_registered_member_data: Array,
        gn_wise_samurdhi_payment_allocation_last_month: Array,
        gn_wise_elder_allowance_payment_allocation_last_month: Array,
    },
    layout: Layout,
    methods: {
        getFormattedPrice(price) {
            let price2;

            if (typeof price === "string") {
                price2 = parseInt(price);
            } else if (typeof price !== "number") {
                return "0.00";
            }

            return price
                .toLocaleString("en-US", {
                    style: "currency",
                    currency: "USD",
                    minimumFractionDigits: 2,
                })
                .replace(/[^0-9.,]/g, "");
        },
    },
    mounted() {
        this.gn_wise_elder_allowance_registered_members =
            this.gn_wise_elder_allowance_registered_members.map((data_item) => {
                let approvedMemberCount = 0;

                data_item.family_units.forEach((family_unit) => {
                    family_unit.members.forEach((member) => {
                        if (member.is_elder && member.status_id === 3) {
                            approvedMemberCount++;
                        }
                    });
                });

                return {
                    ...data_item,
                    approved_member_count: approvedMemberCount,
                };
            });

        this.gn_wise_samurdhi_payment_allocation_items =
            this.gn_wise_samurdhi_payment_allocation_last_month.map(
                (data_item) => {
                    let total = 0;

                    data_item.samurdhi_payment_requests.forEach(
                        (payment_request) => {
                            if (payment_request.status_id === 3) {
                                total += parseInt(
                                    payment_request.payment_amount
                                );
                            }
                        }
                    );

                    return {
                        ...data_item,
                        total_amount: total,
                    };
                }
            );
    },
};
</script>
