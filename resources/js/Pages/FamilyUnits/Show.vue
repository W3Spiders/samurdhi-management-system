<template>
    <Head title="Family Unit View" />

    <breadcrumb :items="breadcrumb_items"></breadcrumb>

    <!-- Family Unit Summary -->
    <div class="mt-6 bg-white rounded-md shadow overflow-x-auto">
        <div class="flex flex-wrap p-8">
            <div class="flex mb-12 w-full bg-slate-100 rounded-md p-8">
                <div class="pr-6 w-full lg:w-1/2">
                    <div class="form-label">GN Division No</div>
                    <div class="form-input">
                        {{ this.family_unit.gn_division.gn_division_no }}
                    </div>
                </div>

                <div class="pr-6 w-full lg:w-1/2">
                    <div class="form-label">GN Division</div>
                    <div class="form-input">
                        {{ this.family_unit.gn_division.gn_division_name }}
                    </div>
                </div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Family Unit Reference</div>
                <div class="form-input">{{ family_unit.family_unit_ref }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Address</div>
                <div
                    class="form-input"
                    v-html="family_unit.full_address_html"
                ></div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">No. of Members</div>
                <div class="form-input">{{ family_unit.members_count }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Total Income</div>
                <div class="form-input">{{ this.totalMonthlyIncome }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Has Met Samurdhi Eligible Criteria</div>
                <div class="form-input">
                    {{
                        this.family_unit.has_met_samurdhi_eligible_criteria
                            ? "Yes"
                            : "No"
                    }}
                </div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Status</div>
                <div class="form-input">
                    {{ this.family_unit.status.status_title }}
                </div>
            </div>
        </div>

        <div class="form-footer gap-3">
            <button
                class="btn btn-danger-outline"
                type="button"
                @click="
                    ($event) => {
                        this.delete();
                    }
                "
            >
                Delete
            </button>

            <Link
                class="btn btn-primary"
                :href="route('family_units.edit', { id: family_unit.id })"
            >
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </Link>
        </div>
    </div>

    <!-- Set House Holder -->

    <h2 class="mt-12 text-2xl font-bold">House Holder Information</h2>

    <div class="mt-6 bg-white rounded-md shadow p-8">
        <p v-if="!family_unit.primary_member" class="mb-4 text-red-700">
            There is no house holder selected in this family unit. Please set a
            one.
        </p>

        <!-- <p v-if="family_unit.primary_member" class="mb-4 text-red-700">
            You can change house holder by selecting a one from following list.
        </p> -->

        <h3 class="mb-4 text-xl font-bold">Set House Holder</h3>
        <div class="bg-slate-100 rounded-md p-8 mb-8 border border-slate-300">
            <form @submit.prevent="submitPrimaryMemberUpdateForm">
                <div class="flex">
                    <select-input
                        v-model="primaryMemberUpdateForm.primary_member_id"
                        :error="
                            primaryMemberUpdateForm.errors?.primary_member_id
                        "
                        class="pr-6 w-full lg:w-1/2"
                    >
                        <option value="null" disabled></option>
                        <option
                            v-for="primary_eligible_member in family_unit.primary_eligible_members"
                            :key="primary_eligible_member.id"
                            :value="primary_eligible_member.id"
                        >
                            {{ primary_eligible_member.full_name }}
                        </option>
                    </select-input>

                    <div>
                        <loading-button
                            :loading="primaryMemberUpdateForm.processing"
                            class="btn btn-primary"
                            type="submit"
                        >
                            {{ family_unit.primary_member ? "Update" : "Set" }}
                        </loading-button>
                    </div>
                </div>
            </form>
        </div>

        <div class="flex flex-wrap">
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">House Holder Name</div>
                <div class="form-input">
                    {{ family_unit.primary_member?.full_name || "-" }}
                </div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">House Holder's Occupation Type</div>
                <div class="form-input">
                    {{
                        family_unit.primary_member?.occupation_type?.name || "-"
                    }}
                </div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">House Holder's Occupation</div>
                <div class="form-input">
                    {{ family_unit.primary_member?.occupation || "-" }}
                </div>
            </div>
        </div>
    </div>

    <!-- Members Table -->
    <h2 class="mt-12 text-2xl font-bold">Members</h2>

    <!-- Table Actions -->
    <div class="flex items-center justify-end mb-6">
        <Link
            class="btn btn-primary"
            :href="
                route('members.create', { family_unit_id: this.family_unit.id })
            "
        >
            <span>Add</span>
        </Link>
    </div>

    <div class="mt-6 bg-white rounded-md shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <tr>
                <th class="table-header-cell">Full Name</th>
                <th class="table-header-cell">National ID</th>
                <th class="table-header-cell">Gender</th>
                <th class="table-header-cell">Marital Status</th>
                <th class="table-header-cell">Occupation Type</th>
            </tr>

            <tr
                v-for="member in family_unit.members"
                :key="member.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
                <td class="border-t">
                    <div class="table-cell-inner">
                        <Link
                            :href="
                                route('members.show', {
                                    family_unit_id: member.family_unit_id,
                                    id: member.id,
                                })
                            "
                        >
                            {{ member.full_name }}
                        </Link>
                    </div>
                </td>
                <td class="border-t">
                    <div class="table-cell-inner">
                        {{ member.nic || "-" }}
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
            </tr>

            <tr v-if="family_unit.members.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">No members.</td>
            </tr>
        </table>
    </div>

    <!-- Family Unit Actions -->

    <h2 class="mt-12 text-2xl font-bold">Actions</h2>

    <div class="mt-6 bg-white rounded-md shadow p-8">
        <div class="flex gap-4">
            <!-- This button is visible only for SN -->
            <!-- And only for family units with status "new" -->
            <loading-button
                v-if="
                    (family_unit.status.status_code === 'new' ||
                        family_unit.status.status_code === 'viewed') &&
                    auth.user.user_type === 'sn'
                "
                :loading="statusUpdateForm.processing"
                class="btn bg-teal-600 text-white"
                type="submit"
                @click="onClickStatusChange('pending_approval')"
            >
                Send to Approval
            </loading-button>

            <loading-button
                v-if="
                    family_unit.status.status_code === 'new' &&
                    auth.user.user_type === 'gn'
                "
                :loading="statusUpdateForm.processing"
                class="btn bg-cyan-600 text-white"
                type="submit"
                @click="onClickStatusChange('viewed')"
            >
                Mark as Viewed
            </loading-button>

            <loading-button
                v-if="
                    family_unit.status.status_code === 'pending_approval' &&
                    auth.user.user_type === 'ds'
                "
                :loading="statusUpdateForm.processing"
                class="btn bg-emerald-600 text-white"
                type="submit"
                @click="onClickStatusChange('approved')"
            >
                Approve
            </loading-button>

            <loading-button
                v-if="
                    family_unit.status.status_code === 'new' &&
                    auth.user.user_type === 'ds'
                "
                :loading="statusUpdateForm.processing"
                class="btn bg-red-800 text-white"
                type="submit"
                @click="onClickStatusChange('rejected')"
            >
                Mark as Rejected
            </loading-button>
        </div>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Shared/Layout";
import Breadcrumb from "@/Shared/Breadcrumb";
import SelectInput from "@/Shared/SelectInput";
import LoadingButton from "@/Shared/LoadingButton";

export default {
    components: { Head, Breadcrumb, Link, SelectInput, LoadingButton },
    layout: Layout,
    props: {
        family_unit: Object,
        status_list: Object,
        auth: Object,
    },
    data() {
        return {
            primaryMemberUpdateForm: this.$inertia.form({
                primary_member_id: this.family_unit.primary_member?.id || null,
                gn_division_id: this.family_unit.gn_division?.id,
                house_no: this.family_unit.house_no,
                address_line_1: this.family_unit.address_line_1,
                address_line_2: this.family_unit.address_line_2,
                city: this.family_unit.city,
                postal_code: this.family_unit.postal_code,
            }),
            statusUpdateForm: this.$inertia.form({
                ...this.family_unit,
                status_id: null,
            }),
            breadcrumb_items: [
                {
                    text: "Family Units",
                    link: route("family_units.index"),
                },
                {
                    text: this.family_unit.family_unit_ref,
                    link: "",
                },
            ],
        };
    },
    computed: {
        totalMonthlyIncome() {
            const incomes = this.family_unit.members.map(
                (member) => member.monthly_income
            );
            const filteredIncomes = incomes.filter((item) => item !== null);

            let totalIncome = 0;

            if (filteredIncomes.length > 0) {
                totalIncome = filteredIncomes.reduce((total, value) => {
                    return total + value;
                });
            }

            return totalIncome;
        },

        isMetSamurdhiEligibleCriteria() {
            return true;
        },
    },
    methods: {
        submitPrimaryMemberUpdateForm() {
            this.primaryMemberUpdateForm.put(
                route("family_units.update", { id: this.family_unit.id })
            );
        },

        onClickStatusChange(next_status_code) {
            const next_status_id = this.getStatusIdByCode(next_status_code);

            this.statusUpdateForm.status_id = next_status_id;

            if (!confirm("Are you sure want to continue?")) {
                return;
            }

            this.statusUpdateForm.put(
                route("family_units.update", { id: this.family_unit.id })
            );
        },

        getStatusIdByCode(code) {
            const status = this.status_list.find((s) => s.status_code === code);
            return status?.id || -1;
        },
    },
};
</script>
