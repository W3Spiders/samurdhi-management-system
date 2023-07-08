<template>
    <div>

        <Head title="Samurdhi Payment Requests" />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <!-- Table Actions -->
        <div class="flex items-center justify-between mb-6">
            <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
            </search-filter>
            <Link v-if="auth.user.user_type === 'sn'" class="btn btn-primary"
                :href="route('samurdhi_payment_requests.create')">
            <span>Add</span>
            </Link>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="pb-4 pt-6 px-6">Reference ID</th>
                    <th class="pb-4 pt-6 px-6">Payment Date</th>
                    <th class="pb-4 pt-6 px-6">No. of Family Units</th>
                    <th class="pb-4 pt-6 px-6">Total Amount</th>
                    <th class="pb-4 pt-6 px-6">Status</th>
                </tr>
                <tr v-for="payment_request in samurdhi_payment_requests" :key="payment_request.id"
                    class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <div class="table-cell-inner">
                            <Link :href="route(
                                'samurdhi_payment_requests.show',
                                payment_request.id
                            )
                                ">
                            {{ payment_request.ref }}
                            </Link>
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ payment_request.payment_date }}
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            {{ payment_request.items.length }}
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            Rs. {{ payment_request.total_amount || "0.00" }}
                        </div>
                    </td>
                    <td class="border-t">
                        <div class="table-cell-inner">
                            <span :class="`px-4 py-2 rounded-lg text-xs font-medium ${statusColors[payment_request.status_id]
                                }`">
                                {{ payment_request.status_string }}
                            </span>
                        </div>
                    </td>
                </tr>
                <tr v-if="samurdhi_payment_requests.length === 0">
                    <td class="px-6 py-4 border-t" colspan="4">
                        No samurdhi payment requests found.
                    </td>
                </tr>
            </table>
        </div>
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
        samurdhi_payment_requests: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
            breadcrumb_items: [
                {
                    text: "Samurdhi Payment Requests",
                    link: "",
                },
            ],
            statusColors: {
                1: "bg-blue-200", // New
                2: "bg-amber-200", // Pending Approval
                3: "bg-green-200", // Approved
                4: "bg-red-200", // Rejected
                5: "bg-lime-200", // Paid
            },
        };
    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get(
                    "/samurdhi-payment-requests",
                    pickBy(this.form),
                    {
                        preserveState: true,
                    }
                );
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
