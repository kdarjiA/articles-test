<template>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex space-x-6 pb-4 items-center">

                    <select v-model="selected_category" class="form-select appearance-none block w-full  px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out
      m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none max-w-xs"
                            aria-label="Default select example">
                        <option value="">Select category</option>
                        <option v-for="category in categories" :value="category.id" :key="category.id">
                            {{ category.category_name }}
                        </option>
                    </select>

                    <input type="text" class="w-96 rounded z-0 border border-solid border-gray-300 focus:shadow focus:outline-none"
                           v-model="search_by" placeholder="Search anything...">

                    <button @click=applyFilter()
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Search
                    </button>


            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Slug
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Parent Category
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 task-list-container">
                            <tr v-for="article in articles.data" :key="article.id">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900" v-html="article.title">
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500" v-html="article.slug">
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    {{ categoryName(article.primary_category) }}
                                </td>
                            </tr>
                            </tbody>
                            <tbody v-show="isEmptyArticles && is_empty">
                            <tr>
                                <td></td>
                                <td></td>
                                <td>No Record found !</td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div v-show="!isEmptyArticles">
                            <paginationComponent :data="articles" @pagination-change-page="getResults"></paginationComponent>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import paginationComponent from "./PaginationComponent";

export default {
    metaInfo: function () {
        return {
            title: "Articles",
        }
    },
    data: function () {
        return {
            articles: {},
            categories: {},
            selected_category: '',
            search_by: '',
            is_empty:false
        }
    },
    components: {paginationComponent},
    computed: {
        isEmptyArticles: function () {
            return _.isEmpty(this.articles.data);
        }
    },
    methods: {
        applyFilter: function (page=1) {
            var data = {};
            data.category = this.selected_category;
            data.search_by = this.search_by;
            var $this = this;
            axios.get('/api/search?page=' + page + '&category=' + this.selected_category + '&search_by=' + this.search_by).then(function (response) {
                $this.articles = response.data.articles;
                $this.categories = response.data.categories;
                $this.is_empty = $this.isEmptyArticles
            });
        },
        getResults(page = 1) {
            var url = '/api/articles?page=' + page;
            if (this.selected_category != '' || this.search_by != '') {
                this.applyFilter(page)
            } else {
                this.getArticles(page, url);
            }
        },
        categoryName: function (category) {
            if (typeof category != 'undefined') {
                return category.category_name;
            }
            return '';
        },
        getArticles: function (page,url) {
            var $this = this;

            axios.get(url).then((response) => {
                this.articles = response.data.articles;
                this.categories = response.data.categories;
                this.is_empty = $this.isEmptyArticles
            })
        }

    },
    mounted: function () {
        this.getArticles(1,'/api/articles');
        EventHub.$on('pagination-change-page', this.getResults);

    },
    created: function () {

    }
}</script>

<style scoped>
.pagination {
    margin-top: 30px;
    float: right;
}
</style>
