<template>
    <div>
        <div class="mb-4">
            <Link class="group flex items-center py-3" href="/">
                <icon
                    name="dashboard"
                    class="mr-2 w-4 h-4"
                    :class="
                        isUrl('')
                            ? 'fill-white'
                            : 'fill-slate-500 group-hover:fill-white'
                    "
                />
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
        <div class="mb-4">
            <Link class="group flex items-center py-3" href="/family-units">
                <icon
                    name="office"
                    class="mr-2 w-4 h-4"
                    :class="
                        isUrl('family-units')
                            ? 'fill-white'
                            : 'fill-slate-500 group-hover:fill-white'
                    "
                />
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
