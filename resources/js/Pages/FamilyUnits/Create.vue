<template>
    <div>
        <Head title="Create Family Unit" />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="submit">
                <div class="flex flex-wrap -mb-8 p-8">
                    <div
                        class="flex mb-12 w-full bg-slate-100 rounded-md p-4 mr-6"
                    >
                        <div class="pr-6 w-full lg:w-1/2">
                            <div class="form-label">GN Division No</div>
                            <div class="form-input">
                                {{ this.gn_division.gn_division_no }}
                            </div>
                        </div>

                        <div class="pr-4 w-full lg:w-1/2">
                            <div class="form-label">GN Division</div>
                            <div class="form-input">
                                {{ this.gn_division.gn_division_name }}
                            </div>
                        </div>
                    </div>

                    <text-input
                        name="house_no"
                        v-model="form.house_no"
                        :error="form.errors.house_no"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="House No"
                    />

                    <text-input
                        v-model="form.address_line_1"
                        :error="form.errors.address_line_1"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Address Line 1"
                    />

                    <text-input
                        v-model="form.address_line_2"
                        :error="form.errors.address_line_2"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Address Line 2"
                    />

                    <text-input
                        v-model="form.city"
                        :error="form.errors.city"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="City"
                    />

                    <text-input
                        name="postal_code"
                        v-model="form.postal_code"
                        :error="form.errors.postal_code"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Postal Code"
                    />
                </div>
                <div
                    class="flex items-center gap-4 justify-end px-8 py-4 bg-gray-50 border-t border-gray-100"
                >
                    <loading-button
                        :loading="false"
                        class="btn btn-secondary-outline"
                        type="reset"
                    >
                        Cancel
                    </loading-button>
                    <loading-button
                        :loading="form.processing"
                        class="btn btn-primary"
                        type="submit"
                    >
                        {{ this.family_unit ? "Update" : "Create" }}
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
        gn_division: Object,
        family_units: Object,
    },
    remember: "form",
    data() {
        return {
            form: this.$inertia.form({
                gn_division_id: this.gn_division?.id,
                house_no: "",
                address_line_1: "",
                address_line_2: "",
                city: "",
                postal_code: "",
            }),

            breadcrumb_items: [
                {
                    text: "Family Units",
                    link: route("family_units.index"),
                },
                {
                    text: this.family_unit ? "Edit" : "Create",
                    link: "",
                },
            ],
        };
    },
    methods: {
        submit() {
            if (this.family_unit) {
                this.form.put(
                    route("family_units.update", { id: this.family_unit.id })
                );
            } else {
                this.form.post(route("family_units.store"));
            }
        },
    },
};
</script>
