<template>
    <div>
        <Head :title="`${member ? 'Edit' : 'Create'} Member`" />

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
                        v-model="form.occupation_type"
                        :error="form.errors.occupation_type"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Occupation Type"
                    >
                        <option
                            v-for="occupation_type in occupation_types"
                            :value="occupation_type.id"
                        >
                            {{ occupation_type.name }}
                        </option>
                    </select-input>

                    <text-input
                        v-model="form.occupation"
                        :error="form.errors.occupation"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="Occupation"
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
                        {{ this.member ? "Update" : "Create" }}
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
        member: Object,
        family_unit_id: String,
        family_unit: Object,
        occupation_types: Array,
    },
    remember: "form",
    data() {
        return {
            form: this.$inertia.form({
                family_unit_id: this.member
                    ? this.member.family_unit_id
                    : this.family_unit_id,
                first_name: this.member ? this.member.first_name : "",
                middle_name: this.member ? this.member.middle_name : "",
                last_name: this.member ? this.member.last_name : "",
                email: this.member ? this.member.email : "",
                phone: this.member ? this.member.phone : "",
                birthday: this.member ? this.member.birthday : "",
                gender: this.member ? this.member.gender : "",
                monthly_income: this.member ? this.member.monthly_income : "",
                marital_status: this.member ? this.member.marital_status : "",
                nic: this.member ? this.member.nic : "",
                occupation_type: this.member
                    ? this.member.occupation_type_id
                    : "",
                occupation: this.member ? this.member.occupation : "",
            }),

            breadcrumb_items: [
                {
                    text: "Family Units",
                    link: route("family_units.index"),
                },
                {
                    text: this.family_unit.family_unit_ref,
                    link: route("family_units.show", this.family_unit.id),
                },
                {
                    text: "Members",
                    link: route(
                        "family_units.show",
                        this.member
                            ? this.member.family_unit_id
                            : this.family_unit_id
                    ),
                },
                {
                    text: this.member ? "Edit" : "Create",
                    link: "",
                },
            ],
        };
    },
    methods: {
        submit() {
            if (this.member) {
                this.form.put(route("members.update", { id: this.member.id }));
            } else {
                this.form.post(route("members.store"));
            }
        },
    },
};
</script>
