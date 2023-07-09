<template>
    <div>
        <Head :title="`${user ? 'Edit' : 'Create'} User`" />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="submit">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <text-input
                        v-model="form.first_name"
                        :error="form.errors.first_name"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="First name"
                    />
                    <text-input
                        v-model="form.last_name"
                        :error="form.errors.last_name"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Last name"
                    />
                    <text-input
                        v-model="form.email"
                        :error="form.errors.email"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Email"
                    />
                    <text-input
                        v-model="form.username"
                        :error="form.errors.username"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Username"
                        :disabled="user"
                    />
                    <select-input
                        v-model="form.user_type"
                        :error="form.errors.user_type"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="User Type"
                        :disabled="user"
                    >
                        <option value="gn">Grama Niladhari</option>
                        <option value="gn">Samurdhi Niladhari</option>
                    </select-input>
                    <text-input
                        v-if="!user"
                        v-model="form.password"
                        :error="form.errors.password"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Password"
                        type="password"
                    />
                </div>
                <div
                    class="flex items-center justify-end gap-[10px] px-8 py-4 bg-gray-50 border-t border-gray-100"
                >
                    <a class="btn btn-secondary-outline" @click="cancel">
                        Cancel
                    </a>
                    <loading-button
                        :loading="form.processing"
                        class="btn btn-primary"
                        type="submit"
                    >
                        {{ this.user ? "Update" : "Create" }}
                    </loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/vue3";
import Layout from "@/Shared/Layout";
import TextInput from "@/Shared/TextInput";
import SelectInput from "@/Shared/SelectInput";
import LoadingButton from "@/Shared/LoadingButton";
import Breadcrumb from "@/Shared/Breadcrumb";

export default {
    components: {
        Head,
        Link,
        LoadingButton,
        SelectInput,
        TextInput,
        Breadcrumb,
    },
    layout: Layout,
    props: {
        user: Object,
    },
    remember: "form",
    data() {
        return {
            form: this.$inertia.form({
                username: this.user ? this.user.username : "",
                email: this.user ? this.user.email : "",
                first_name: this.user ? this.user.first_name : "",
                last_name: this.user ? this.user.last_name : "",
                user_type: this.user ? this.user.user_type : "",
                password: this.user ? undefined : "",
            }),

            breadcrumb_items: [
                {
                    text: "Users",
                    link: route("users.index"),
                },
                this.user
                    ? {
                          text: this.user.full_name,
                          link: route("users.show", this.user.id),
                      }
                    : null,
                {
                    text: this.user ? "Edit" : "Create",
                    link: "",
                },
            ],
        };
    },
    methods: {
        submit() {
            if (this.user) {
                this.form.put(route("users.update", { id: this.user.id }));
            } else {
                this.form.post(route("users.store"));
            }
        },

        cancel() {
            if (
                !this.form.isDirty ||
                confirm("Are you sure want to cancel changes?")
            ) {
                this.$inertia.visit(
                    this.user
                        ? route("users.show", this.user.id)
                        : route("users.index")
                );
            }
        },
    },
};
</script>
