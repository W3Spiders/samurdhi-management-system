<template>
    <div class="flex items-center">
        <div class="flex w-full bg-white rounded shadow">
            <input
                class="relative px-6 py-3 w-full rounded-r focus:shadow-outline"
                autocomplete="off"
                type="text"
                name="search"
                placeholder="Search…"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </div>
        <button
            class="ml-3 btn btn-primary"
            type="button"
            @click="$emit('reset')"
        >
            Reset
        </button>
    </div>
</template>

<script>
import Dropdown from "@/Shared/Dropdown";

export default {
    components: {
        Dropdown,
    },
    props: {
        modelValue: String,
        maxWidth: {
            type: Number,
            default: 300,
        },
    },
    emits: ["update:modelValue", "reset"],
};
</script>
