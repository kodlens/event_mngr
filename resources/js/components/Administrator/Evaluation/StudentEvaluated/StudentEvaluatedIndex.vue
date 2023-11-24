<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="box">

                        <div class="columns">
                            <div class="column">

                                <div class="is-flex is-justify-content-center mb-2"
                                    style="font-size: 20px; font-weight: bold;">STUDENT LIST WHO SUBMITTED EVALUATION</div>
                                <hr>
                                
                                
                                <b-field label="Select Event">
                                   <modal-browse-events
                                        :prop-name="event.event"
                                        @browseEvents="emitBrowseEvent"></modal-browse-events>
                                </b-field>
                            </div>
                        </div> <!--cols-->

                        <div class="columns">
                            <div class="column">

                                <div class="buttons is-right">
                                    <b-button class="is-small is-primary" label="Search"
                                        icon-left="magnify" @click="loadAsyncData"></b-button>
                                </div>
                                <b-table
                                    :data="data"
                                    :loading="loading"
                                    paginated
                                    backend-pagination
                                    :total="total"
                                    :hoverable="true"
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
                                        {{ props.row.user.user_id }}
                                    </b-table-column>
                         
                                    <b-table-column field="name" label="Student Name" v-slot="props">
                                        {{ props.row.user.lname }}, {{ props.row.user.fname }} {{ props.row.user.mname}}
                                    </b-table-column>

                                    <b-table-column field="sex" label="Sex" v-slot="props">
                                        {{ props.row.user.sex }}
                                    </b-table-column>

                                    <b-table-column field="created_at" label="Date & Time" v-slot="props">
                                        {{ new Date(props.row.created_at).toLocaleString() }}
                                    </b-table-column>
                                    <!-- <b-table-column label="Action" v-slot="props">
                                        <div class="is-flex">
                                            <b-tooltip label="Set Active" type="is-info">
                                                <b-button class="button is-small mr-1" tag="a" icon-right="thumb-up" @click="setActive(props.row.academic_year_id)"></b-button>
                                            </b-tooltip>
                                            <b-tooltip label="Edit" type="is-warning">
                                                <b-button class="button is-small mr-1" tag="a" icon-right="pencil" @click="getData(props.row.academic_year_id)"></b-button>
                                            </b-tooltip>
                                            <b-tooltip label="Delete" type="is-danger">
                                                <b-button class="button is-small mr-1" icon-right="delete" @click="confirmDelete(props.row.academic_year_id)"></b-button>
                                            </b-tooltip>
                                        </div>
                                    </b-table-column> -->

                                </b-table>
                            </div>
                        </div> <!--cols-->

                    </div>
                </div>
            </div>
        </div> <!--section-->
        
    </div>
</template>

<script>

export default{
    data(){
        return {

            data: [],
            total: 0,
            loading: false,
            sortField: 'academic_year_code',
            sortOrder: 'desc',
            page: 1,
            perPage: 20,
            defaultSortDirection: 'asc',


            academicYears: [],
            report: [],

            event: {
                event_id: null,
                ayid: '',
                event: ''
            }
        }
    },

    methods: {

        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `ayid=${this.event.ayid}`,
                `eventid=${this.event.event_id}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-students-evaluated?${params}`)
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


        loadReportEventEvaluations(){
            const params = [
                `ayid=${this.search.ayid}`
            ].join('&')
            axios.get(`/get-report-event-evaluations?${params}`).then(res=>{
                this.report = res.data
            })
        },

        emitBrowseEvent(row){
            this.event.event_id = row.event_id
            this.event.event = row.event
            this.event.ayid = row.academic_year_id
        }
    },

    mounted(){
    }
}
</script>