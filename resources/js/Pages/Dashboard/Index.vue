<template>
    <Head title="Dashboard" />

    <h1 class="mb-8 text-3xl font-medium">Dashboard</h1>

    <div>
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
                        <div class="text-xl font-bold">606A</div>
                    </div>

                    <div>
                        <div class="text-sm text-slate-500 mb-1">
                            Division Name
                        </div>
                        <div class="text-xl font-bold">Welmilla</div>
                    </div>
                </div>

                <div class="px-8 pt-8 pb-4 text-lg border-r border-slate-200">
                    <div class="text-sm text-slate-500 mb-1">
                        Samurdhi Niladhari's Name
                    </div>
                    <div class="text-xl font-bold">Padmini Thilakawardhana</div>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-3 gap-8">
            <dash-card
                primaryText="Total Family Units"
                secondaryText="48"
                :link="route('family_units.index')"
                linkText="View All"
            >
            </dash-card>

            <dash-card
                primaryText="Total Samurdhi Eligible Family Units"
                secondaryText="25"
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

export default {
    components: {
        Head,
        Link,
        DashCard,
        ThisMonthSamurdhiPaymentList,
    },
    props: {
        payment_requests: Array,
    },
    layout: Layout,
};
</script>
