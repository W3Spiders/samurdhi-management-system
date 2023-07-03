<template>
    <Head title="View GN Division" />

    <breadcrumb :items="breadcrumb_items"></breadcrumb>

    <!-- GN Division Summary -->
    <div class="max-w-3xl mt-6 bg-white rounded-md shadow overflow-x-auto">
        <div class="flex flex-wrap p-8">
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Ward No</div>
                <div class="form-input">
                    {{ gn_division.ward?.ward_no }}
                </div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Ward Name</div>
                <div class="form-input">
                    {{ gn_division.ward?.ward_name }}
                </div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">GN Division No</div>
                <div class="form-input">{{ gn_division.gn_division_no }}</div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">GN Division Name</div>
                <div class="form-input">
                    {{ gn_division.gn_division_name }}
                </div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Grama Niladhari</div>
                <div class="form-input">
                    {{ gn_division.gn_user?.full_name }}
                </div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Samurdhi Niladhari</div>
                <div class="form-input">
                    {{ gn_division.sn_user?.full_name }}
                </div>
            </div>

        </div>

        <div v-if="auth.user.user_type == 'admin'" class="form-footer gap-3">
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
                :href="route('gn_divisions.edit', { id: gn_division.id })"
            >
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
        gn_division: Object,
        auth: Object, // globally shared
    },
    data() {
        return {
            breadcrumb_items: [
                {
                    text: "GN Divisions",
                    link: route("gn_divisions.index"),
                },
                {
                    text: this.gn_division?.gn_division_no,
                    link: "",
                },
            ],
        };
    },
    methods: {
        delete() {
            if (confirm("Are you sure you want to delete this gn_division?")) {
                this.$inertia.delete(
                    route("gn_divisions.delete", { id: this.gn_division.id })
                );
            }
        },
    },
};
</script>
