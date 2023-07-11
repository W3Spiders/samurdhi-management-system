<template>
    <Head title="Dashboard" />

    <h1 class="mb-8 text-3xl font-medium">Dashboard</h1>

    <div v-if="auth.user.user_type === 'gn' || auth.user.user_type === 'sn'">
        <h2
            class="mb-8 text-xl font-medium underline decoration-sky-500 underline-offset-4"
        >
            Grama Niladhari Division Summary
        </h2>

        <div class="bg-white rounded-md shadow overflow-x-auto">
            <div class="grid grid-cols-3 gap-2">
                <div class="px-8 pt-8 pb-4 text-lg border-r border-slate-200">
                    <div class="text-sm text-slate-500 mb-1">
                        Divisional Secretariat
                    </div>
                    <div class="text-xl font-bold">Horana</div>
                </div>
                <div class="px-8 pt-8 pb-4 text-lg border-r border-slate-200">
                    <div class="mb-4">
                        <div class="text-sm text-slate-500 mb-1">
                            Division No
                        </div>
                        <div class="text-xl font-bold">
                            {{ gn_division?.gn_division_no || "-" }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-slate-500 mb-1">
                            Division Name
                        </div>
                        <div class="text-xl font-bold">
                            {{ gn_division?.gn_division_name || "-" }}
                        </div>
                    </div>
                </div>

                <div class="px-8 pt-8 pb-4 text-lg border-r border-slate-200">
                    <div class="mb-4">
                        <div class="text-sm text-slate-500 mb-1">
                            Grama Niladhari's Name
                        </div>
                        <div class="text-xl font-bold">
                            {{ getUserFullName(gn_division.gn_user) }}
                        </div>
                    </div>

                    <div class="text-sm text-slate-500 mb-1">
                        Samurdhi Niladhari's Name
                    </div>
                    <div class="text-xl font-bold">
                        {{ getUserFullName(gn_division.sn_user) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-3 gap-8">
            <dash-card
                primaryText="Total Family Units"
                :secondaryText="family_units_count"
                :link="route('family_units.index')"
                linkText="View All"
            >
            </dash-card>

            <dash-card
                primaryText="Total Samurdhi Approved Family Units"
                :secondaryText="samurdhi_approved_count"
                :link="route('family_units.index')"
                linkText="View All"
            >
            </dash-card>

            <dash-card
                primaryText="Total Elder Allowance Eligible Members"
                secondaryText="20"
                :link="route('family_units.index')"
                linkText="View All"
            >
            </dash-card>
        </div>
    </div>

    <div v-if="auth.user.user_type === 'ds'" class="mt-12">
        <h2
            class="mb-8 text-xl font-medium underline decoration-sky-500 underline-offset-4"
        >
            Pending Monthly Samurdhi Payment Request Approvals
        </h2>
        <samurdhi-payment-request-list
            :payment_requests="pending_samurdhi_payment_requests"
        ></samurdhi-payment-request-list>
    </div>

    <div v-if="auth.user.user_type === 'sn'" class="mt-12">
        <h2
            class="mb-8 text-xl font-medium underline decoration-sky-500 underline-offset-4"
        >
            Approved Samurdhi Payment Requests
        </h2>
        <samurdhi-payment-request-list
            :payment_requests="approved_samurdhi_payment_requests"
        ></samurdhi-payment-request-list>
    </div>

    <div v-if="auth.user.user_type === 'gn'" class="mt-12">
        <h2
            class="mb-8 text-xl font-medium underline decoration-sky-500 underline-offset-4"
        >
            New Elder Members
        </h2>

        <member-list :members="new_elder_members"></member-list>
    </div>

    <div v-if="auth.user.user_type === 'ds'" class="mt-12">
        <h2
            class="mb-8 text-xl font-medium underline decoration-sky-500 underline-offset-4"
        >
            Pending Elder Allowance Approvals
        </h2>

        <member-list :members="pending_elder_members"></member-list>
    </div>

    <div class="mt-12">
        <h2
            class="mb-8 text-xl font-medium underline decoration-sky-500 underline-offset-4"
        >
            Samurdhi Payment List of This Month
        </h2>
        <this-month-samurdhi-payment-list
            :payment_requests="payment_requests"
        ></this-month-samurdhi-payment-list>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Shared/Layout";
import DashCard from "@/Shared/DashCard";
import ThisMonthSamurdhiPaymentList from "./Components/ThisMonthSamurdhiPaymentList.vue";
import SamurdhiPaymentRequestList from "./Components/SamurdhiPaymentRequestList.vue";
import MemberList from "./Components/MemberList.vue";

export default {
    components: {
        Head,
        Link,
        DashCard,
        ThisMonthSamurdhiPaymentList,
        SamurdhiPaymentRequestList,
        MemberList,
    },
    props: {
        gn_division: Object,
        payment_requests: Array,
        family_units_count: Number,
        samurdhi_approved_count: Number,
        auth: Object, // globally shared one
        pending_samurdhi_payment_requests: Array,
        approved_samurdhi_payment_requests: Array,
        new_elder_members: Array,
        pending_elder_members: Array,
    },
    methods: {
        getUserFullName(user) {
            let name = user.first_name;

            if (user.last_name) {
                name += " " + user.last_name;
            }

            return name;
        },
    },
    layout: Layout,
};
</script>
