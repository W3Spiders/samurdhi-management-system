<template>
    <div class="bg-white rounded-md shadow overflow-x-auto">
        <div class="px-8 pt-8 pb-4">
            <div class="text-sm text-slate-500 mb-1">{{ primaryText }}</div>
            <div class="text-4xl text-sky-600 font-bold">
                {{ secondaryText }}
            </div>
        </div>

        <div
            v-if="linkText"
            class="flex items-center px-6 py-4 bg-gray-50 border-t border-gray-100"
        >
            <Link
                :href="link"
                class="ml-auto text-indigo-600 text-sm font-medium"
                >{{ linkText }}</Link
            >
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
    components: { Link },
    props: {
        primaryText: String,
        secondaryText: String,
        link: String,
        linkText: String,
    },
};
</script>
