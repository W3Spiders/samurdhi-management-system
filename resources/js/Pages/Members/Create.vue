<template>
    <div>
        <Head title="Create Contact" />
        <h1 class="mb-8 text-2xl font-medium">
            <Link class="breadcrumb-link" href="/family-units"
                >Family Units</Link
            >
            <span class="breadcrumb-link"> /</span>
            <Link class="breadcrumb-link" href="/members"> Members </Link>
            <span class="breadcrumb-link">/</span>
            <span class="breadcrum-current"> Create</span>
        </h1>
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
                        Create Contact
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

export default {
    components: {
        Head,
        Link,
        LoadingButton,
        SelectInput,
        TextInput,
    },
    layout: Layout,
    props: {
        family_unit_id: Number,
    },
    remember: "form",
    data() {
        return {
            form: this.$inertia.form({
                first_name: "",
                last_name: "",
                organization_id: null,
                email: "",
                phone: "",
                address: "",
                city: "",
                region: "",
                country: "",
                postal_code: "",
            }),
        };
    },
};
</script>
