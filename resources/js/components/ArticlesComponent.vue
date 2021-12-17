<template>
    <div class="py-12">




        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <div class="mb-3 xl:w-96">
                    <select v-model="selected_category" class="form-select appearance-none block w-full  px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out
      m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            aria-label="Default select example">
                        <option value="">Select category</option>
                        <option v-for="category in categories" :value="category.id" :key="category.id">
                            {{ category.category_name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="flex bg-gray-200">
                <div class="container h-screen flex justify-center items-center">
                    <div class="relative">
                        <div class="absolute top-4 left-3"><i
                            class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i></div>
                        <input type="text" class="h-14 w-96 pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none"
                               v-model="search_by" placeholder="Search anything...">
                        <button @click=applyFilter($event)
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Button
                        </button>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Id
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    slug
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    category name
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 task-list-container">
                            <tr v-for="article in articles.data" :key="article.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ article.id }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900" v-html="article.title">
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500" v-html="article.slug">
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ categoryName(article.primary_category) }}

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div v-if="articles.length >0">
                            <paginationComponent :data="articles"
                                                 @pagination-change-page="getResults"></paginationComponent>
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
            search_by: ''
        }
    },
    components: {paginationComponent},
    methods: {
        getData: function () {
            console.log(_.isEmpty(this.articles));

        },
        applyFilter: function () {
            var data = {};
            data.category = this.selected_category;
            data.search_by = this.search_by;
            var $this = this;
            axios.post('/api/search', data).then(function (response) {
                $this.articles = response.data.articles;
                console.log($this.articles);
            })
        },
        getResults(page = 1) {
            axios.get('/api/articles?page=' + page).then((response) => {
                this.articles = response.data.articles;
            })
        },
        categoryName: function (category) {
            if (typeof category != 'undefined') {
                return category.category_name;
            }
            return '';
        },
        getArticles: function () {
            axios.get('/api/articles').then((response) => {
                this.articles = response.data.articles;
                this.categories = response.data.categories;
            })
        }

    },
    mounted: function () {
        this.getArticles();
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
