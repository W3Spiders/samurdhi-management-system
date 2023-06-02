<template>
    <div>
        <div class="mb-4 border-b border-slate-700">
            <Link class="group flex items-center py-3" href="/">
                <div
                    :class="
                        isUrl('')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                    "
                >
                    Dashboard
                </div>
            </Link>
        </div>

        <div class="mb-4 border-b border-slate-700">
            <Link
                class="group flex items-center py-3"
                :href="route('family_units.index')"
            >
                <div
                    :class="
                        isUrl('family-units')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                    "
                >
                    Family Units
                </div>
            </Link>
        </div>

        <div class="mb-4 border-b border-slate-700">
            <Link
                class="group flex items-center py-3"
                :href="route('family_units.index')"
            >
                <div
                    :class="
                        isUrl('family-units')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                    "
                >
                    Samurdhi Management
                </div>
            </Link>
        </div>

        <div class="mb-4 border-b border-slate-700">
            <Link
                class="group flex items-center py-3"
                :href="route('family_units.index')"
            >
                <div
                    :class="
                        isUrl('family-units')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                    "
                >
                    Elder Allowance Management
                </div>
            </Link>
        </div>

        <div class="mb-4 border-b border-slate-700">
            <Link
                class="group flex items-center py-3"
                :href="route('reports.index')"
            >
                <div
                    :class="
                        isUrl('reports')
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                    "
                >
                    Reports
                </div>
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import Icon from "@/Shared/Icon";

export default {
    components: {
        Icon,
        Link,
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1);
            if (urls[0] === "") {
                return currentUrl === "";
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length;
        },
    },
};
</script>
