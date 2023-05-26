<template>
    <h1 class="text-3xl underline">Member Create</h1>

    <form>
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
    </form>
</template>

<script>
import TextInput from "@/Shared/TextInput";

export default {
    components: {
        TextInput,
    },
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
