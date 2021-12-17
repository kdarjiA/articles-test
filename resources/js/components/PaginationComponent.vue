<template>
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <div v-for="link in data.links">
                        <a @click="onPaginationChangePage(link)" href="#"
                           :class="[(link.active) ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium': 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium']"
                           aria-current="page" class="" v-html="link.label"></a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        data: {default: null},
    },
    data: function () {
        return {
            selected_page: 1
        }
    },
    methods: {
        onPaginationChangePage(link) {

            var url_string = link.url;
            var url = new URL(url_string);
            var page = url.searchParams.get("page");
            console.log(page);
            this.selected_page = page;
            this.$emit('pagination-change-page', page);
        }
    },
}</script>

<style scoped>
.pagination {
    margin-top: 30px;
    float: right;
}
</style>
