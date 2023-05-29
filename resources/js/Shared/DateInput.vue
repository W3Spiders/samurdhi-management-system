<template>
    <div :class="$attrs.class">
        <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
        <VueDatePicker
            :value="modelValue"
            :format="format"
            :year-range="[1930, 2023]"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <div v-if="error" class="form-error">{{ error }}</div>
    </div>
</template>

<script>
import { ref } from "vue";

export default {
    components: {},
    props: {
        id: {
            type: String,
            default() {
                return `date-input-${1}`;
            },
        },
        error: String,
        label: String,
        modelValue: Date,
    },
    emits: ["update:modelValue"],
    methods: {
        focus() {
            this.$refs.input.focus();
        },
        select() {
            this.$refs.input.select();
        },
        setSelectionRange(start, end) {
            this.$refs.input.setSelectionRange(start, end);
        },
    },
    data() {
        return {
            date: ref(),
        };
    },
};
</script>
