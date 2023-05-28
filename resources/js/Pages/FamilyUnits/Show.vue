<template>
    <Head title="Family Unit View" />

    <breadcrumb :items="breadcrumb_items"></breadcrumb>

    <!-- Family Unit Summary -->
    <div class="mt-6 bg-white rounded-md shadow overflow-x-auto">
        <div class="flex flex-wrap p-8">
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Family Unit Reference</div>
                <div class="form-input">{{ family_unit.family_unit_ref }}</div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">House Holder Name</div>
                <div class="form-input">
                    {{ family_unit.primary_member.full_name }}
                </div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">House Holder's Occupation Type</div>
                <div class="form-input">
                    {{ family_unit.primary_member.occupation_type.name }}
                </div>
            </div>

            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">House Holder's Occupation</div>
                <div class="form-input">
                    {{ family_unit.primary_member.occupation || "-" }}
                </div>
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
                <th class="table-header-cell">Has Income</th>
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
                        {{ member.nic }}
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
                        {{ member.has_income_string }}
                    </div>
                </td>
            </tr>

            <tr v-if="family_unit.members.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">No members.</td>
            </tr>
        </table>
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
        family_unit: Object,
    },
    data() {
        return {
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
};
</script>
