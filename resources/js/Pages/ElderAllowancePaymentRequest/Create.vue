<template>
    <div>
        <Head
            :title="
                elder_allowance_payment_request
                    ? 'Edit Elder Allowance Payment Request'
                    : 'Create Elder Allowance Payment Request'
            "
        />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <div
            class="bg-white rounded-md shadow overflow-hidden p-6 mb-6 flex justify-between items-center"
        >
            <div>
                <span
                    :class="`px-4 py-2 rounded-lg text-xs font-medium ${
                        statusColors[
                            elder_allowance_payment_request
                                ? elder_allowance_payment_request.status_id
                                : 1
                        ]
                    }`"
                >
                    {{
                        elder_allowance_payment_request
                            ? elder_allowance_payment_request.status_string
                            : "New"
                    }}
                </span>
            </div>
            <div class="flex gap-x-4">
                <button class="btn btn-secondary-outline" @click="cancel">
                    Cancel
                </button>
                <loading-button
                    :loading="form.processing"
                    class="btn btn-primary"
                    @click="submit"
                >
                    {{
                        this.elder_allowance_payment_request
                            ? "Update"
                            : "Create"
                    }}
                </loading-button>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-x-[20px]">
            <div
                class="max-w-3xl bg-white rounded-md shadow overflow-hidden col-span-1 px-6 py-6 flex flex-col gap-y-[20px]"
            >
                <div>
                    <div class="pb-10 mb-3 border-b border-slate-200">
                        <div>
                            <label class="form-label" for="payment-date-input">
                                Payment Date
                            </label>

                            <input
                                class="form-input"
                                id="payment-date-input"
                                v-model="form.payment_date"
                                type="date"
                            />

                            <div
                                v-if="form.errors.payment_date"
                                class="form-error"
                            >
                                {{ form.errors.payment_date }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <text-input
                                v-model="form.payment_amount"
                                :error="form.errors.payment_amount"
                                label="Payment Amount"
                                type="number"
                                @keyup="onPaymentAmountKeyup"
                            />
                        </div>
                    </div>
                </div>

                <div>
                    <div class="form-label">GN Division No</div>
                    <div class="form-input">
                        {{ gn_division.gn_division_no }}
                    </div>
                </div>

                <div>
                    <div class="form-label">GN Division Name</div>
                    <div class="form-input">
                        {{ gn_division.gn_division_name }}
                    </div>
                </div>

                <div>
                    <div class="form-label">Number of Members</div>
                    <div class="form-input">
                        {{ form.items.length }}
                    </div>
                </div>

                <div>
                    <div class="form-label">Total Payment</div>
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
                class="max-w-3xl bg-white rounded-md overflow-hidden col-span-2"
            >
                <!-- Selected members Table -->
                <div class="bg-white overflow-x-auto relative overflow-auto">
                    <table class="w-full whitespace-nowrap">
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">
                                Member Name
                            </th>
                            <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">
                                Age
                            </th>
                            <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">
                                Amount
                            </th>
                        </tr>

                        <tr
                            v-for="item in form.items"
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
                                        getFormattedCurrencyString(item.amount)
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
        elder_allowance_approved_members: Object,
    },
    remember: "form",
    data() {
        return {
            paymentAmountKeyupTimer: null,
            form: this.$inertia.form({
                gn_division_id: this.gn_division.id,
                payment_amount: this.elder_allowance_payment_request
                    ? this.elder_allowance_payment_request.payment_amount
                    : null,
                payment_date:
                    this.elder_allowance_payment_request?.payment_date || null,
                items: this.elder_allowance_payment_request
                    ? this.elder_allowance_payment_request.items
                    : [],
                total_amount: 0,
                status_id:
                    this.elder_allowance_payment_request?.status_id || null,
            }),

            breadcrumb_items: [
                {
                    text: "Elder Allowance Payment Requests",
                    link: route("elder_allowance_payment_requests.index"),
                },
                {
                    text: this.elder_allowance_payment_request
                        ? "Edit"
                        : "Create",
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
            let number2 = number;

            if (typeof number2 === "string") {
                number2 = parseFloat(number2);
            }

            return "Rs. " + number2.toFixed(2);
        },

        onPaymentAmountKeyup(event) {
            const value = event.target.value;

            clearTimeout(this.paymentAmountKeyupTimer);

            this.paymentAmountKeyupTimer = setTimeout(() => {
                this.form.items.forEach((item) => {
                    if (parseInt(value) >= 0) {
                        item.amount = value;
                    } else {
                        item.amount = 0;
                    }
                });
            }, 500);
        },

        submit() {
            this.form.total_amount = this.paymentRequestTotalAmount;

            if (this.elder_allowance_payment_request) {
                if (typeof this.form.payment_amount === "string") {
                    this.form.payment_amount = parseFloat(
                        this.form.payment_amount
                    );
                }

                this.form.put(
                    route("elder_allowance_payment_requests.update", {
                        id: this.elder_allowance_payment_request.id,
                    })
                );
            } else {
                if (typeof this.form.payment_amount === "string") {
                    this.form.payment_amount = parseFloat(
                        this.form.payment_amount
                    );
                }
                this.form.post(route("elder_allowance_payment_requests.store"));
            }
        },

        cancel() {
            if (confirm("Are you sure want to cancel changes?")) {
                this.$inertia.visit(
                    route("elder_allowance_payment_requests.index")
                );
            }
        },
    },

    computed: {
        paymentRequestTotalAmount() {
            return this.form.items.length * this.form.payment_amount;
        },
    },

    mounted() {
        if (!this.elder_allowance_payment_request) {
            this.elder_allowance_approved_members.forEach((member) => {
                const requestItem = new RequestItem();
                requestItem.member = member;
                requestItem.member_id = member.id;

                this.form.items.push(requestItem);
            });
        }
    },
};

class RequestItem {
    is_new = true;
    member_id = null;
    member = null;
    amount = 0;
}
</script>
