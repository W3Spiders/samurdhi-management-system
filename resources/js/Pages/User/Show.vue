<template>
    <Head title="View User" />

    <breadcrumb :items="breadcrumb_items"></breadcrumb>

    <!-- User Summary -->
    <div class="max-w-3xl mt-6 bg-white rounded-md shadow overflow-x-auto">
        <div class="flex flex-wrap p-8">
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">First Name</div>
                <div class="form-input">{{ user.first_name }}</div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Last Name</div>
                <div class="form-input">{{ user.last_name }}</div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Username</div>
                <div class="form-input">{{ user.username }}</div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">User Type</div>
                <div class="form-input">
                    {{ getUserTypeTitle(user.user_type) }}
                </div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">Email</div>
                <div class="form-input">{{ user.email }}</div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">GN Division No</div>
                <div class="form-input">
                    {{ user.gn_division?.gn_division_no || "-" }}
                </div>
            </div>
            <div class="pb-8 pr-6 w-full lg:w-1/2">
                <div class="form-label">GN Division Name</div>
                <div class="form-input">
                    {{ user.gn_division?.gn_division_name || "-" }}
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
                :href="route('users.edit', { id: user.id })"
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
        user: Object,
        auth: Object, // globally shared
    },
    data() {
        return {
            breadcrumb_items: [
                {
                    text: "Users",
                    link: route("users.index"),
                },
                {
                    text: this.user?.full_name,
                    link: "",
                },
            ],
        };
    },
    methods: {
        getUserTypeTitle(code) {
            if (code === "gn") {
                return "Grama Niladhari";
            } else if (code === "sn") {
                return "Samurdhi Niladhari";
            } else if (code === "ds") {
                return "Divisional Secretariat";
            } else if (code === "admin") {
                return "Admin User";
            }

            return "No Title";
        },
        delete() {
            if (confirm("Are you sure you want to delete this user?")) {
                this.$inertia.delete(
                    route("users.delete", { id: this.user.id })
                );
            }
        },
    },
};
</script>
