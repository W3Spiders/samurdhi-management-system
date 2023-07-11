<template>
    <div>
        <Head
            title="
                View Elder Allowance Payment Request
            "
        />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <div
            class="bg-white rounded-md shadow overflow-hidden p-6 mb-6 flex justify-between items-center"
        >
            <div>
                <span
                    :class="`px-4 py-2 rounded-lg text-xs font-medium ${
                        statusColors[elder_allowance_payment_request.status_id]
                    }`"
                >
                    {{ elder_allowance_payment_request.status_string }}
                </span>
            </div>

            <div class="flex gap-[10px]">
                <a
                    v-if="
                        elder_allowance_payment_request.status_code === 'new' ||
                        elder_allowance_payment_request.status_code ===
                            'pending_approval'
                    "
                    :href="
                        route(
                            'elder_allowance_payment_requests.edit',
                            elder_allowance_payment_request.id
                        )
                    "
                    class="btn btn-primary"
                >
                    Edit
                </a>

                <a
                    v-if="
                        elder_allowance_payment_request.status_code ===
                            'approved' ||
                        elder_allowance_payment_request.status_code === 'paid'
                    "
                    :href="
                        route(
                            'elder_allowance_payment_requests.export_payment_list',
                            elder_allowance_payment_request.id
                        )
                    "
                    class="btn btn-primary"
                >
                    Export Excel
                </a>

                <a
                    v-if="
                        elder_allowance_payment_request.status_code ===
                            'approved' ||
                        elder_allowance_payment_request.status_code === 'paid'
                    "
                    :href="
                        route(
                            'elder_allowance_payment_requests.print_payment_list',
                            elder_allowance_payment_request.id
                        )
                    "
                    class="btn btn-primary"
                >
                    Download PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-x-[20px]">
            <div
                class="max-w-3xl bg-white rounded-md shadow overflow-hidden col-span-1 px-6 py-6 flex flex-col gap-y-[20px]"
            >
                <div class="flex gap-x-[15px]">
                    <loading-button
                        v-if="
                            elder_allowance_payment_request.status
                                .status_code === 'new' &&
                            auth.user.user_type === 'gn'
                        "
                        :loading="paymentRequestUpdateForm.processing"
                        class="mb-[20px] btn bg-cyan-600 text-white"
                        type="submit"
                        @click="onClickStatusChange('pending_approval')"
                    >
                        Send to Approval
                    </loading-button>

                    <loading-button
                        v-if="
                            elder_allowance_payment_request.status
                                .status_code === 'pending_approval' &&
                            auth.user.user_type === 'ds'
                        "
                        :loading="paymentRequestUpdateForm.processing"
                        class="mb-[20px] btn bg-green-700 text-white"
                        type="submit"
                        @click="onClickStatusChange('approved')"
                    >
                        Approve
                    </loading-button>

                    <loading-button
                        v-if="
                            elder_allowance_payment_request.status
                                .status_code === 'pending_approval' &&
                            auth.user.user_type === 'ds'
                        "
                        :loading="paymentRequestUpdateForm.processing"
                        class="mb-[20px] btn btn-danger text-white"
                        type="submit"
                        @click="onClickStatusChange('rejected')"
                    >
                        Reject
                    </loading-button>

                    <loading-button
                        v-if="
                            elder_allowance_payment_request.status
                                .status_code === 'approved' &&
                            auth.user.user_type === 'sn'
                        "
                        :loading="paymentRequestUpdateForm.processing"
                        class="mb-[20px] btn bg-teal-600 text-white"
                        type="submit"
                        @click="onClickStatusChange('paid')"
                    >
                        Mark as Paid
                    </loading-button>
                </div>

                <div>
                    <div class="form-label">GN Division No</div>
                    <div class="form-input">
                        {{
                            this.elder_allowance_payment_request.gn_division
                                .gn_division_no
                        }}
                    </div>
                </div>

                <div>
                    <div class="form-label">GN Division Name</div>
                    <div class="form-input">
                        {{
                            this.elder_allowance_payment_request.gn_division
                                .gn_division_name
                        }}
                    </div>
                </div>

                <div>
                    <div class="form-label">Payment Date</div>
                    <div class="form-input">
                        {{ elder_allowance_payment_request.payment_date }}
                    </div>
                </div>

                <div>
                    <div class="form-label">Payment Amount(Per Unit)</div>
                    <div class="form-input">
                        {{ elder_allowance_payment_request.payment_amount }}
                    </div>
                </div>

                <div>
                    <div class="form-label">Number of Family Units</div>
                    <div class="form-input">
                        {{ this.elder_allowance_payment_request.items.length }}
                    </div>
                </div>

                <div>
                    <div class="form-label">Total Amount</div>
                    <div class="form-input">
                        {{
                            getFormattedCurrencyString(
                                paymentRequestTotalAmount
                            )
                        }}
                    </div>
                </div>
            </div>
            <div
                class="max-w-3xl bg-white rounded-md shadow overflow-hidden col-span-2"
            >
                <!-- Selected Family Units Table -->
                <div class="relative overflow-auto">
                    <table class="w-full whitespace-nowrap">
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">
                                Family Unit Ref
                            </th>
                            <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">
                                House Holder
                            </th>
                            <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">
                                Amount
                            </th>
                        </tr>

                        <tr
                            v-for="item in elder_allowance_payment_request.items"
                            :key="item.member_id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100"
                        >
                            <td class="border-t">
                                <div class="table-cell-inner">
                                    {{ item.member.full_name }}
                                </div>
                            </td>

                            <td class="border-t">
                                <div class="table-cell-inner">
                                    {{ item.member.age }}
                                </div>
                            </td>

                            <td class="border-t">
                                <div class="table-cell-inner">
                                    {{
                                        getFormattedCurrencyString(
                                            elder_allowance_payment_request.payment_amount
                                        )
                                    }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Shared/Layout";
import TextInput from "@/Shared/TextInput";
import SelectInput from "@/Shared/SelectInput";
import LoadingButton from "@/Shared/LoadingButton";
import Breadcrumb from "@/Shared/Breadcrumb";

export default {
    components: {
        Head,
        Link,
        LoadingButton,
        SelectInput,
        TextInput,
        Breadcrumb,
    },
    layout: Layout,
    props: {
        auth: Object,
        gn_division: Object,
        elder_allowance_payment_request: Object,
        status_list: Object,
    },
    remember: "form",
    data() {
        return {
            paymentRequestUpdateForm: this.$inertia.form({
                ...this.elder_allowance_payment_request,
                status_id: null,
            }),
            breadcrumb_items: [
                {
                    text: "Elder Allowance Payment Requests",
                    link: route("elder_allowance_payment_requests.index"),
                },
                {
                    text: this.elder_allowance_payment_request.ref,
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

    methods: {
        getFormattedCurrencyString(number) {
            if (typeof number === "string") {
                number = parseFloat(number);
            }

            return "Rs. " + number.toFixed(2);
        },

        onClickStatusChange(next_status_code) {
            const next_status_id = this.getStatusIdByCode(next_status_code);

            this.paymentRequestUpdateForm.status_id = next_status_id;

            if (!confirm("Are you sure want to continue?")) {
                return;
            }

            this.paymentRequestUpdateForm.put(
                route("elder_allowance_payment_requests.update", {
                    id: this.elder_allowance_payment_request.id,
                })
            );
        },

        getStatusIdByCode(code) {
            const status = this.status_list.find((s) => s.status_code === code);
            return status?.id || -1;
        },
    },

    computed: {
        paymentRequestTotalAmount() {
            // let total = 0;

            // this.elder_allowance_payment_request.items.forEach((item) => {
            //     let amount = item.amount;

            //     if (typeof amount === "string") {
            //         amount = parseFloat(amount);
            //     }

            //     total += amount;
            // });

            // return total;
            return (
                this.elder_allowance_payment_request.items.length *
                this.elder_allowance_payment_request.payment_amount
            );
        },
    },
};

class RequestItem {
    is_new = true;
    member_id = null;
    member = null;
    amount = 20000;
}
</script>
