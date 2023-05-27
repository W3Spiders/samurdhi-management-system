<template>
    <h1 class="mb-8 text-2xl font-medium">
        <template
            v-for="(item, index) in items"
            :key="`breadcrumb-link-${index}`"
        >
            <template v-if="!isLastItem(index)">
                <Link class="breadcrumb-link" :href="item.link">
                    {{ item.text }}
                </Link>
                <span class="breadcrumb-link"> / </span>
            </template>

            <!-- Last link -->
            <template v-if="isLastItem(index)">
                <span class="breadcrum-current"> {{ item.text }}</span>
            </template>
        </template>
    </h1>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
    components: {
        Link,
    },
    props: {
        items: Object, // {link: String, text: String }
    },
    methods: {
        isLastItem(index) {
            return index === this.items.length - 1;
        },
    },
};
</script>
