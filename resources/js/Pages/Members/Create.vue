<template>
    <div>
        <Head title="Create Member" />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="store">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <text-input
                        v-model="form.first_name"
                        :error="form.errors.first_name"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="First name"
                    />
                    <text-input
                        v-model="form.middle_name"
                        :error="form.errors.middle_name"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Middle name"
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
                        v-model="form.nic"
                        :error="form.errors.nic"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="National ID"
                    />
                    <text-input
                        v-model="form.phone"
                        :error="form.errors.phone"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Phone"
                    />

                    <select-input
                        v-model="form.gender"
                        :error="form.errors.gender"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Gender"
                    >
                        <option :value="null" disabled />
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                    </select-input>

                    <div class="pb-8 pr-6 w-full lg:w-1/2">
                        <label class="form-label" for="birthday-input"
                            >Birthday</label
                        >
                        <input
                            class="form-input"
                            id="birthday-input"
                            v-model="form.birthday"
                            type="text"
                            pattern="((?:19|20)[0-9][0-9])-(0?[1-9]|1[012])-(0?[1-9]|[12][0-9]|3[01])"
                        />

                        <div v-if="!form.errors.birthday" class="form-hint">
                            Accepted format: YYYY-MM-DD
                        </div>

                        <div v-if="form.errors.birthday" class="form-error">
                            {{ form.errors.birthday }}
                        </div>
                    </div>

                    <select-input
                        v-model="form.marital_status"
                        :error="form.errors.marital_status"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Marital Status"
                    >
                        <option :value="null" disabled />
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                    </select-input>

                    <select-input
                        v-model="form.has_income"
                        :error="form.errors.has_income"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Has Income"
                    >
                        <option :value="null" disabled />
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select-input>

                    <text-input
                        v-model="form.monthly_income"
                        :error="form.errors.monthly_income"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Monthly Income"
                        type="number"
                    />
                </div>
                <div
                    class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100"
                >
                    <loading-button
                        :loading="form.processing"
                        class="btn btn-primary"
                        type="submit"
                    >
                        Create Member
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
        family_unit_id: String,
    },
    remember: "form",
    data() {
        return {
            form: this.$inertia.form({
                family_unit_id: this.family_unit_id,
                first_name: "",
                middle_name: "",
                last_name: "",
                email: "",
                phone: "",
                birthday: "",
                gender: "",
                has_income: "",
                monthly_income: "",
                marital_status: "",
                nic: "",
            }),

            breadcrumb_items: [
                {
                    text: "Family Units",
                    link: "/family_units",
                },
                {
                    text: "Members",
                    link: "/members",
                },
                {
                    text: "Create",
                    link: "",
                },
            ],
        };
    },
    methods: {
        store() {
            this.form.post("/members");
        },
    },
};
</script>
