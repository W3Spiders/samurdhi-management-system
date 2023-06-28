<template>
    <div>
        <Head
            title="
                View Samurdhi Payment Request
            "
        />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <div class="p-8 border-b border-slate-200">
                <div class="flex flex-wrap justify-between mb-6">
                    <ul class="flex flex-col gap-y-[5px]">
                        <li>
                            <span class="font-bold">Gn Division No:</span>
                            {{ this.samurdhi_payment_request.gn_division_no }}
                        </li>
                        <li>
                            <span class="font-bold">GN Division Name:</span>
                            {{ this.samurdhi_payment_request.gn_division_name }}
                        </li>
                        <li class="mt-[10px]">
                            <span class="font-bold"
                                >Number of Family Units:</span
                            >
                            {{ this.samurdhi_payment_request.items.length }}
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
                        <li>
                            <span class="font-bold">Payment Date:</span>
                            {{ samurdhi_payment_request.payment_date }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Selected Family Units Table -->
            <div
                class="bg-white rounded-md shadow overflow-x-auto relative max-h-[450px] overflow-auto"
            >
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
                        v-for="item in samurdhi_payment_request.items"
                        :key="item.family_unit_id"
                        class="hover:bg-gray-100 focus-within:bg-gray-100"
                    >
                        <td class="border-t">
                            <div class="table-cell-inner">
                                {{ item.family_unit.family_unit_ref }}
                            </div>
                        </td>

                        <td class="border-t">
                            <div class="table-cell-inner">
                                {{ item.family_unit.primary_member?.full_name }}
                            </div>
                        </td>

                        <td class="border-t">
                            <div class="table-cell-inner">
                                {{ getFormattedCurrencyString(item.amount) }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div
                class="flex items-center gap-4 justify-end px-8 py-4 bg-gray-50 border-t border-gray-100"
            >
                <a :href="''" class="btn btn-primary"> Edit </a>
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
        gn_division: Object,
        samurdhi_payment_request: Object,
    },
    remember: "form",
    data() {
        return {
            breadcrumb_items: [
                {
                    text: "Samurdhi Payment Requests",
                    link: route("samurdhi_payment_requests.index"),
                },
                {
                    text: this.samurdhi_payment_request.ref,
                    link: "",
                },
            ],
        };
    },

    methods: {
        getFormattedCurrencyString(number) {
            if (typeof number === "string") {
                number = parseFloat(number);
            }

            return "Rs. " + number.toFixed(2);
        },
    },

    computed: {
        paymentRequestTotalAmount() {
            let total = 0;

            this.samurdhi_payment_request.items.forEach((item) => {
                let amount = item.amount;

                if (typeof amount === "string") {
                    amount = parseFloat(amount);
                }

                total += amount;
            });

            return total;
        },
    },
};

class RequestItem {
    is_new = true;
    family_unit_id = null;
    family_unit = null;
    amount = 20000;
}
</script>
