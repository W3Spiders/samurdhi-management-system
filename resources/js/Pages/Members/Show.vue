<template>
    <breadcrumb :items="breadcrumb_items"></breadcrumb>

    <!-- Member Summary -->
    <div class="max-w-3xl mt-6 bg-white rounded-md shadow overflow-x-auto">
        <div class="flex flex-wrap p-8">
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Full Name</div>
                <div class="form-input">{{ member.full_name }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">National ID</div>
                <div class="form-input">{{ member.nic || "-" }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Birthday</div>
                <div class="form-input">{{ member.birthday }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Email</div>
                <div class="form-input">{{ member.email }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Phone</div>
                <div class="form-input">{{ member.phone }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Gender</div>
                <div class="form-input">{{ member.gender_string }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Marital Status</div>
                <div class="form-input">{{ member.marital_status }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Occupation Type</div>
                <div class="form-input">
                    {{ member.occupation_type?.name || "-" }}
                </div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Occupation</div>
                <div class="form-input">
                    {{ member.occupation || "-" }}
                </div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Monthly Income</div>
                <div class="form-input">{{ member.monthly_income || "-" }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Elder Allowance Status</div>
                <div class="form-input">
                    <span
                        :class="`px-4 py-2 rounded-lg text-xs font-medium ${
                            statusColors[member.status_id]
                        }`"
                    >
                        {{ member.status_string }}
                    </span>
                </div>
            </div>
        </div>

        <hr class="mt-4 mb-2" />

        <div class="p-8 pb-0">
            <h2 class="text-xl font-bold">Bank Account Details</h2>
        </div>

        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Bank Account Number</div>
                <div class="form-input">
                    {{ member.bank_account?.account_number || "-" }}
                </div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Holder's Name</div>
                <div class="form-input">
                    {{ member.bank_account?.holder_name || "-" }}
                </div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Bank Name</div>
                <div class="form-input">
                    {{ member.bank_account?.name || "-" }}
                </div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Branch</div>
                <div class="form-input">
                    {{ member.bank_account?.branch || "-" }}
                </div>
            </div>
        </div>

        <div v-if="auth.user.user_type === 'gn'" class="form-footer gap-3">
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
                :href="route('members.edit', { id: member.id })"
            >
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </Link>
        </div>
    </div>

    <!-- Actions -->
    <h2 class="mt-12 text-2xl font-bold">Actions</h2>
    <div class="max-w-3xl mt-6 bg-white rounded-md shadow overflow-x-auto p-8">
        <div class="flex gap-[10px]">
            <loading-button
                v-if="
                    member.status_code === 'new' && auth.user.user_type === 'gn'
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
                    auth.user.user_type === 'ds' &&
                    member.status_code === 'pending_approval'
                "
                :loading="statusUpdateForm.processing"
                class="btn bg-green-700 text-white"
                type="submit"
                @click="onClickStatusChange('approved')"
            >
                Approve
            </loading-button>

            <loading-button
                v-if="
                    (auth.user.user_type === 'gn' &&
                        member.status_code === 'new') ||
                    (auth.user.user_type === 'ds' &&
                        member.status_code === 'pending_approval')
                "
                :loading="statusUpdateForm.processing"
                class="btn bg-red-700 text-white"
                type="submit"
                @click="onClickStatusChange('rejected')"
            >
                Reject
            </loading-button>
        </div>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Shared/Layout";
import Breadcrumb from "@/Shared/Breadcrumb";

export default {
    components: { Head, Breadcrumb, Link },
    layout: Layout,
    props: {
        auth: Object,
        member: Object,
        status_list: Object,
    },
    data() {
        return {
            statusUpdateForm: this.$inertia.form({
                ...this.member,
                occupation_type: this.member.occupation_type.id,
                status_id: null,
            }),
            breadcrumb_items: [
                {
                    text: "Family Units",
                    link: "/family-units",
                },
                {
                    text: this.member.family_unit.family_unit_ref,
                    link: this.route(
                        "family_units.show",
                        this.member.family_unit.id
                    ),
                },
                {
                    text: this.member.full_name,
                    link: "",
                },
            ],
            statusColors: {
                1: "bg-blue-200", // New
                2: "bg-amber-200", // Pending Approval
                3: "bg-green-200", // Approved
                4: "bg-red-200", // Rejected
            },
        };
    },
    methods: {
        onClickStatusChange(next_status_code) {
            const next_status_id = this.getStatusIdByCode(next_status_code);

            this.statusUpdateForm.status_id = next_status_id;

            if (!confirm("Are you sure want to continue?")) {
                return;
            }

            this.statusUpdateForm.put(
                route("members.update", { id: this.member.id })
            );
        },
        getStatusIdByCode(code) {
            const status = this.status_list.find((s) => s.status_code === code);
            return status?.id || -1;
        },
        delete() {
            if (confirm("Are you sure you want to delete this member?")) {
                this.$inertia.delete(
                    route("members.delete", { id: this.member.id })
                );
            }
        },
    },
};
</script>
