<template>
    <div>
        <Head :title="`${gn_division ? 'Edit' : 'Create'} GN Division`" />

        <breadcrumb :items="breadcrumb_items"></breadcrumb>

        <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
            <form @submit.prevent="submit">
                <div class="flex flex-wrap -mb-8 -mr-6 p-8">
                    <select-input
                        v-model="form.ward_no"
                        :error="form.errors.ward_id"
                        class="pb-8 pr-6 w-full lg:w-1"
                        label="Ward"
                    >
                        <option :value="null" disabled />
                       <option :value="ward.ward_no" v-for="ward in wards" :key="ward.id">
                            {{ ward.ward_name }}
                        </option>
                    </select-input>
                    <text-input
                        v-model="form.gn_division_no"
                        :error="form.errors.gn_division_no"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="GN Division No"
                    />
                    <text-input
                        v-model="form.gn_division_name"
                        :error="form.errors.gn_division_name"
                        class="pb-8 pr-6 w-full lg:w-1/2"
                        label="GN Division Name"
                    />
                    <select-input
                        v-model="form.gn_user_id"
                        :error="form.errors.gn_user_id"
                        class="pb-8 pr-6 w-full lg:w-1"
                        label="Grama Niladhari"
                    >
                        <option :value="null" disabled />
                        <option :value="user.id" v-for="user in gn_users" :key="user.id">
                            {{ user.full_name }}
                        </option>
                    </select-input>
                    <select-input
                        v-model="form.sn_user_id"
                        :error="form.errors.sn_user_id"
                        class="pb-8 pr-6 w-full lg:w-1"
                        label="Samurdhi Niladhari"
                    >
                        <option :value="null" disabled />
                        <option :value="user.id" v-for="user in sn_users" :key="user.id">
                            {{ user.full_name }}
                        </option>
                    </select-input>
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
                        {{ this.gn_division ? "Update" : "Create" }}
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
        wards: Object,
        gn_users: Object,
        sn_users: Object
    },
    remember: "form",
    data() {
        return {
            form: this.$inertia.form({
                gn_division_name: this.gn_division?.gn_division_name || "",
                gn_division_no: this.gn_division?.gn_division_no || "",
                ward_no: this.gn_division?.ward?.ward_no || null,
                gn_user_id: this.gn_division?.gn_user_id || null,
                sn_user_id: this.gn_division?.sn_user_id || null
            }),

            breadcrumb_items: [
                {
                    text: "GN Divisions",
                    link: route("gn_divisions.index"),
                },
                this.gn_division
                    ? {
                          text: this.gn_division.gn_division_no,
                          link: route("gn_divisions.show", this.gn_division.id),
                      }
                    : null,
                {
                    text: this.gn_division ? "Edit" : "Create",
                    link: "",
                },
            ],
        };
    },
    methods: {
        submit() {
            if (this.gn_division) {
                this.form.put(route("gn_divisions.update", { id: this.gn_division.id }));
            } else {
                this.form.post(route("gn_divisions.store"));
            }
        },

        cancel() {
            if (
                !this.form.isDirty ||
                confirm("Are you sure want to cancel changes?")
            ) {
                this.$inertia.visit(
                    this.gn_division
                        ? route("gn_divisions.show", this.gn_division.id)
                        : route("gn_divisions.index")
                );
            }
        },
    },
};
</script>
