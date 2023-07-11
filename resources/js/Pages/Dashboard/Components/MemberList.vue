<template>
    <!-- Table -->
    <div
        class="bg-white rounded-md shadow overflow-x-auto relative max-h-[450px] overflow-y-auto"
    >
        <table class="w-full whitespace-nowrap max-h-full">
            <tr class="text-left font-bold">
                <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">Full Name</th>
                <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">Gender</th>
                <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">
                    Marital Status
                </th>
                <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">
                    Occupation Type
                </th>
                <th class="pb-4 pt-6 px-6 sticky top-0 bg-white">Status</th>
            </tr>
            <tr
                v-for="member in members"
                :key="member.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
                <td class="border-t">
                    <div class="table-cell-inner">
                        <Link
                            :href="route('members.show', member.id)"
                            class="link"
                        >
                            {{ member.full_name }}
                        </Link>
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
                        {{ member.occupation_type.name }}
                    </div>
                </td>

                <td class="border-t">
                    <div class="table-cell-inner">
                        <span
                            :class="`px-4 py-2 rounded-lg text-xs font-medium ${
                                statusColors[member.status_id]
                            }`"
                        >
                            {{ member.status_string }}
                        </span>
                    </div>
                </td>
            </tr>
            <tr v-if="members.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">
                    No members found found.
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";

export default {
    components: {
        Link,
    },
    props: {
        members: Array,
    },
    data() {
        return {
            statusColors: {
                1: "bg-blue-200", // New
                2: "bg-amber-200", // Pending Approval
                3: "bg-green-200", // Approved
                4: "bg-red-200", // Rejected
            },
        };
    },
};
</script>
