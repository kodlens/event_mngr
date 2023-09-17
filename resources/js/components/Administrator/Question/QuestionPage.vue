<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8-widescreen is-10-tablet">
                    <div class="box">

                        <div class="is-flex is-justify-content-center mb-2"
                            style="font-size: 20px; font-weight: bold;">LIST OF QUESTION</div>

                        <hr>
                        <div class="level">
                            <div class="level-left">
                                <b-field label="Page">
                                    <b-select v-model="perPage" @input="setPerPage">
                                        <option value="5">5 per page</option>
                                        <option value="10">10 per page</option>
                                        <option value="15">15 per page</option>
                                        <option value="20">20 per page</option>
                                    </b-select>
                                    <b-select v-model="sortOrder" @input="loadAsyncData">
                                        <option value="asc">ASC</option>
                                        <option value="desc">DESC</option>
                                    </b-select>
                                </b-field>
                            </div>

                            <div class="level-right">
                                <div class="level-item">
                                    <b-field label="Search">
                                        <b-input type="text"
                                                 v-model="search.question" placeholder="Search..."
                                                 @keyup.native.enter="loadAsyncData"/>
                                        <p class="control">
                                             <b-tooltip label="Search" type="is-success">
                                            <b-button type="is-primary" icon-right="magnify" @click="loadAsyncData"/>
                                             </b-tooltip>
                                        </p>
                                    </b-field>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <b-field label="Academic Year" label-position="on-border">
                            <b-select v-model="search.academic_year_id" @input="loadAsyncData()">
                                <option v-for="(item, index) in academic_years" :key="index"
                                    :value="item.academic_year_id">{{ item.academic_year_code }}</option>
                            </b-select>
                        </b-field>

                        <b-table
                            :data="data"
                            :loading="loading"
                            paginated
                            backend-pagination
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page"
                            backend-sorting
                            :default-sort-direction="defaultSortDirection"
                            @sort="onSort">

                            <b-table-column field="user_id" label="ID" v-slot="props">
                                {{ props.row.question_id }}
                            </b-table-column>

                            <b-table-column field="academic_year" label="AY Code" v-slot="props">
                                {{ props.row.academic_year.academic_year_code }}
                            </b-table-column>

                            <b-table-column field="order_no" label="Order No" centered v-slot="props">
                                {{ props.row.order_no }}
                            </b-table-column>

                            <b-table-column field="question" label="Question" v-slot="props">
                                {{ props.row.question | truncate(50) }}
                            </b-table-column>

                            <b-table-column field="input_type" label="Type" v-slot="props">
                                {{ props.row.input_type }}
                            </b-table-column>

                            <b-table-column field="event" label="Event" v-slot="props">
                                {{ props.row.event.event }}
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small mr-1" tag="a" icon-right="pencil" @click="getData(props.row.question_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small mr-1" icon-right="delete" @click="confirmDelete(props.row.question_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>
                        </b-table>

                        <hr>
                        <div class="buttons mt-3">
                            <b-button :href="`/questions/create`"
                                tag="a"
                                icon-right="chat-question"
                                class="is-primary is-outlined">NEW</b-button>
                        </div>

                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->



    </div>
</template>

<script>

export default{

    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'question_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 20,
            defaultSortDirection: 'asc',

            academic_years: [],

            search: {
                academic_year_id: 0,
                question: '',
            },

            fields: {},
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `question=${this.search.question}`,
                `ay=${this.search.academic_year_id}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-questions?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                    })
                    this.loading = false
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },
        /*
        * Handle page-change event
        */
        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },

        loadAcademicYears(){
            axios.get('/load-academic-years').then(res=>{
                this.academic_years = res.data

                this.academic_years.forEach(item => {
                    if(item.active === 1){
                        this.search.academic_year_id = item.academic_year_id
                    }
                })

                this.loadAsyncData();
            })
        },


        //alert box ask for deletion
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/questions/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


    },

    mounted() {
        this.loadAcademicYears()
    }
}
</script>


<style>


</style>
