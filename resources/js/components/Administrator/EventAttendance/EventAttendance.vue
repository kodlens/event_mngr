<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-10-widescreen is-10-desktop">
                    <div class="box">

                        <div class="is-flex is-justify-content-center mb-2"
                            style="font-size: 20px; font-weight: bold;">LIST OF ATTENDEES</div>
                        <hr>
                        

                        <div class="columns">
                            <div class="column">
                                <b-field label="Page" label-position="on-border">
                                    <b-select v-model="perPage" @input="setPerPage">
                                        <option value="10">10 per page</option>
                                        <option value="20">20 per page</option>
                                        <option value="30">30 per page</option>
                                        <option value="40">40 per page</option>
                                    </b-select>
                                    <b-select v-model="sortOrder" @input="loadAsyncData">
                                        <option value="asc">ASC</option>
                                        <option value="desc">DESC</option>

                                    </b-select>
                                </b-field>
                            </div> <!--col--> 
                        </div> <!--cols-->

                        <div class="columns">
                            <div class="column is-3">
                                <b-field label="Event" label-position="on-border">
                                    <b-input type="text"
                                        v-model="search.event" placeholder="Search Event"
                                        @keyup.native.enter="loadAsyncData"/>
                                </b-field>
                            </div>

                            <div class="column">
                                <b-field label="Search Last Name" label-position="on-border">
                                    <b-input type="text"
                                        v-model="search.lname" placeholder="Search Lastname"
                                        @keyup.native.enter="loadAsyncData"/>
                                    <p class="control">
                                        <b-tooltip label="last Name" type="is-success">
                                            <b-button type="is-primary" icon-right="magnify" @click="loadAsyncData"/>
                                        </b-tooltip>
                                    </p>
                                </b-field>
                            </div>
                        </div>

                        <hr>
                        <!-- <div class="buttons">
                            <b-button class="is-outlined is-primary" icon-left="printer"
                                @click="printPreviewAttendances"></b-button>
                        </div> -->
                        <b-table
                            :data="data"
                            :loading="loading"
                            paginated
                            detailed
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

                            <b-table-column field="event_attendance_id" label="ID" v-slot="props">
                                {{ props.row.event_attendance_id }}
                            </b-table-column>

                            <b-table-column field="event_title" label="Title" v-slot="props">
                                {{ props.row.event.event }}
                            </b-table-column>

                            <b-table-column field="user" label="Participant's Name" v-slot="props">
                                {{ props.row.user.lname }}, {{ props.row.user.fname }} {{ props.row.user.mname }}
                            </b-table-column>

                            <b-table-column field="event_datetime" label="Date & Time" v-slot="props">
                                {{ new Date(props.row.event.event_datetime).toLocaleString() }}
                            </b-table-column>
                    
<!-- 
                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small mr-1" tag="a"
                                            icon-right="pencil"
                                            :href="`/events/${props.row.event_id}/edit`"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small mr-1" icon-right="delete"
                                            @click="confirmDelete(props.row.event_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column> -->

                            <template #detail="props">
                                <tr>
                                    <th>IN AM</th>
                                    <th>OUT AM</th>
                                    <th>IN PM</th>
                                    <th>OUT PM</th>
                                </tr>
                                <tr>
                                    <td>
                                        <span v-if="props.row.in_am">
                                            {{ new Date(props.row.in_am).toLocaleString() }}
                                        </span>
                                    </td>

                                    <td>
                                        <span v-if="props.row.out_am">
                                            {{ new Date(props.row.out_am).toLocaleString() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="props.row.in_pm">
                                            {{ new Date(props.row.in_pm).toLocaleString() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="props.row.out_pm">
                                            {{ new Date(props.row.out_pm).toLocaleString() }}
                                        </span>
                                    </td>
                                   
                                </tr>
                            </template>
                        </b-table>

                        <hr>

                        <!-- <div class="buttons mt-3">
                            <b-button tag="a"
                                href="/events/create"
                                icon-right="calendar" class="is-primary is-outlined">NEW</b-button> 
                        </div>-->
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
            sortField: 'event_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 20,
            defaultSortDirection: 'asc',


            search: {
                event: '',
                lname: ''
            },


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
                `event=${this.search.event}`,
                `lname=${this.search.lname}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-event-attendances?${params}`)
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
            axios.delete('/events/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


        printPreviewAttendances(){
            window.location = '/event-attendances-print-preview'
        }


    },

    mounted() {
        this.loadAsyncData();
    }
}
</script>


<style>


</style>
