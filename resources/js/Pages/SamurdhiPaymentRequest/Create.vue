<template>
    <div>

        <Head :title="samurdhi_payment_request
            ? 'Edit Samurdhi Payment Request'
            : 'Create Samurdhi Payment Request'
            " />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <div class="p-8 border-b border-slate-200">
                <div class="flex flex-wrap justify-between mb-6">
                    <ul class="flex flex-col gap-y-[5px]">
                        <li>
                            <span class="font-bold">Gn Division No:</span>
                            {{ this.gn_division.gn_division_no }}
                        </li>
                        <li>
                            <span class="font-bold">GN Division Name:</span>
                            {{ this.gn_division.gn_division_name }}
                        </li>
                        <li class="mt-[10px]">
                            <span class="font-bold">Number of Family Units:</span>
                            {{ this.form.items.length }}
                        </li>
                        <li>
                            <span class="font-bold">Total Payment:</span>
                            {{
                                getFormattedCurrencyString(
                                    paymentRequestTotalAmount
                                )
                            }}
                        </li>
                    </ul>

                    <ul class="flex flex-col gap-y-[5px]">
                        <li>
                            <span class="font-bold">Status:</span>
                            New
                        </li>
                        <li>
                            <span class="font-bold">Payment Month:</span>
                            Jun 2023
                        </li>
                    </ul>
                </div>

                <div>
                    <div class="pb-3 pr-6 w-full lg:w-1/2">
                        <label class="form-label" for="payment-date-input">
                            Payment Date
                        </label>
                        <!-- <input
                            class="form-input"
                            id="payment-date-input"
                            v-model="form.payment_date"
                            type="text"
                            pattern="((?:19|20)[0-9][0-9])-(0?[1-9]|1[012])-(0?[1-9]|[12][0-9]|3[01])"
                        /> -->

                        <input class="form-input" id="payment-date-input" v-model="form.payment_date" type="date" />

                        <!-- <div v-if="!form.errors.payment_date" class="form-hint">
                            Accepted format: YYYY-MM-DD
                        </div> -->

                        <div v-if="form.errors.payment_date" class="form-error">
                            {{ form.errors.payment_date }}
                        </div>
                    </div>
                </div>
            </div>

            <form @submit.prevent="submit">
                <!-- Selected Family Units Table -->
                <div class="bg-white rounded-md shadow overflow-x-auto relative max-h-[450px] overflow-auto">
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

                        <tr v-for="item in form.items" :key="item.family_unit_id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <div class="table-cell-inner">
                                    {{ item.family_unit.family_unit_ref }}
                                </div>
                            </td>

                            <td class="border-t">
                                <div class="table-cell-inner">
                                    {{
                                        item.family_unit.primary_member
                                            ?.full_name
                                    }}
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
                <div class="flex items-center gap-4 justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
                    <button class="btn btn-secondary-outline" @click="cancel">
                        Cancel
                    </button>
                    <loading-button :loading="form.processing" class="btn btn-primary" type="submit">
                        {{
                            this.samurdhi_payment_request ? "Update" : "Create"
                        }}
                    </loading-button>
                </div>
            </form>
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
        samurdhi_payment_request: Object,
        samurdhi_approved_family_units: Object,
    },
    remember: "form",
    data() {
        return {
            form: this.$inertia.form({
                gn_division_id: this.gn_division.id,
                payment_date: null,
                items: [],
                total_amount: 0,
            }),

            breadcrumb_items: [
                {
                    text: "Samurdhi Payment Requests",
                    link: route("samurdhi_payment_requests.index"),
                },
                {
                    text: this.samurdhi_payment_request ? "Edit" : "Create",
                    link: "",
                },
            ],
        };
    },

    methods: {
        getFormattedCurrencyString(number) {
            return "Rs. " + number.toFixed(2);
        },

        submit() {
            this.form.total_amount = this.paymentRequestTotalAmount;

            if (this.samurdhi_payment_request) {
                // this.form.put(
                //     route("samurdhi_payment_requests.update", {
                //         id: this.samurdhi_payment_request.id,
                //     })
                // );
            } else {
                this.form.post(route("samurdhi_payment_requests.store"));
            }
        },

        cancel() {
            if (confirm("Are you sure want to cancel changes?")) {
                this.$inertia.visit(route("samurdhi_payment_requests.index"));
            }
        },
    },

    computed: {
        paymentRequestTotalAmount() {
            let total = 0;

            this.form.items.forEach((item) => {
                total += item.amount;
            });

            return total;
        },
    },

    mounted() {
        if (!this.samurdhi_payment_request) {
            this.samurdhi_approved_family_units.forEach((family_unit) => {
                //console.log("family unit: ", family_unit);

                const requestItem = new RequestItem();
                requestItem.family_unit = family_unit;
                requestItem.family_unit_id = family_unit.id;

                this.form.items.push(requestItem);
            });
        }
    },
};

class RequestItem {
    is_new = true;
    family_unit_id = null;
    family_unit = null;
    amount = 20000;
}
</script>
