<template>
    <!-- Table -->
    <div class="bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6">Family Unit No</th>
                <th class="pb-4 pt-6 px-6">House Holder's Name</th>
                <th class="pb-4 pt-6 px-6">Amount</th>
                <th class="pb-4 pt-6 px-6">Status</th>
            </tr>
            <tr
                v-for="payment_request in payment_requests"
                :key="payment_request.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ payment_request.family_unit_ref }}
                    </div>
                </td>

                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ payment_request.house_holder_name }}
                    </div>
                </td>

                <td class="border-t">
                    <div class="table-cell-inner">
                        {{
                            payment_request.amount
                                ? `Rs. ${payment_request.amount}`
                                : "-"
                        }}
                    </div>
                </td>

                <td class="border-t">
                    <div class="table-cell-inner">
                        <span
                            :class="`px-4 py-2 rounded-lg text-xs font-medium ${
                                statusColors[payment_request.status]
                            }`"
                        >
                            {{ payment_request.status_string }}
                        </span>
                    </div>
                </td>
            </tr>
            <tr v-if="payment_requests.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">
                    No payments for this month.
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        payment_requests: Array,
    },
    data() {
        return {
            statusColors: {
                1: "bg-blue-200", // New
                2: "bg-amber-200", // Pending Approval
                3: "bg-green-200", // Approved
                4: "bg-red-200", // Rejected
                5: "bg-lime-200", // Paid
            },
        };
    },
};
</script>
