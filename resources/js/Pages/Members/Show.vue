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
                <div class="form-label">Bank Account Number</div>
                <div class="form-input">{{ member.bank_account_number || "-" }}</div>
            </div>
        </div>

        <div v-if="auth.user.user_type === 'gn'" class="form-footer gap-3">
            <button class="btn btn-danger-outline" type="button" @click="($event) => {
                this.delete();
            }
                ">
                Delete
            </button>

            <Link class="btn btn-primary" :href="route('members.edit', { id: member.id })">
            <i class="fa-solid fa-pen-to-square"></i> Edit
            </Link>
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
    },
    data() {
        return {
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
        };
    },
    methods: {
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
