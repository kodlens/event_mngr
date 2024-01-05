<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-10-widescreen is-10-desktop">
                    <div class="box">

                        <div class="is-flex is-justify-content-center mb-2"
                            style="font-size: 20px; font-weight: bold;">LIST OF ATTENDEE</div>
                        <hr>
                        <div class="level">
                            <div class="level-left">
                                <b-field label="Page">
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
                            </div>

                            <div class="level-right">
                                <div class="level-item">
                                    <b-field label="Search">
                                        <b-input type="text"
                                            v-model="search.lname" placeholder="Search Lastname"
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
                        <div class="buttons">
                            <b-button class="is-outlined is-primary" icon-left="printer"
                                @click="printPreviewAttendances"></b-button>
                        </div>
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

                            <b-table-column field="event_attendee_id" label="ID No." v-slot="props">
                                {{ props.row.event_attendee_id }}
                            </b-table-column>

                            <b-table-column field="user" label="Attendee's Name" v-slot="props">
                                {{ props.row.user.lname }}, {{ props.row.user.fname }} {{ props.row.user.mname }}
                            </b-table-column>

                            <b-table-column field="date_request" label="Date Request" v-slot="props">
                                {{ new Date(props.row.date_request).toDateString() }}
                            </b-table-column>

                            
                            <b-table-column field="status" label="Status" v-slot="props">
                               <span v-if="props.row.status === 1" class="yes">APPROVED</span>
                               <span v-else-if="props.row.status === 2" class="no">DECLINED</span>
                                <span v-else class="pending">PENDING</span>
                            </b-table-column>
                    

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex" v-if="props.row.status < 1">
                                    <b-tooltip label="Approved" type="is-warning">
                                        <b-button class="button is-small mr-1" 
                                            icon-right="check"
                                            @click="confirmApprove(props.row.event_attendee_id)"
                                            label="Approved">
                                        </b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Decline" type="is-danger">
                                        <b-button class="button is-small mr-1" 
                                            icon-right="close"
                                            label="Decline"
                                            @click="confirmDecline(props.row.event_attendee_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>
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

    props:{
        propEventId: {
            type: Number,
            default: 0
        }
    }, 
    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'event_attendee_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 20,
            defaultSortDirection: 'asc',


            search: {
                event: '',
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
                `eventid=${this.propEventId}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-event-attendees?${params}`)
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
            axios.delete('/event-attendees/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


        printPreviewAttendances(){
            window.location = '/event-attendees-print-preview/' + this.propEventId
        },




        confirmApprove(dataId){
            this.$buefy.dialog.confirm({
                title: 'Approve!',
                type: 'is-info',
                message: 'Are you sure you want to approve this attendee?',
                cancelText: 'Cancel',
                confirmText: 'Ok',
                onConfirm: () => this.approveSubmit(dataId)
            });
        }, 
        approveSubmit(dataId) {
            axios.post('/event-attendees-approve/' + dataId).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


        confirmDecline(dataId){
            this.$buefy.dialog.confirm({
                title: 'Decline?',
                type: 'is-warning',
                message: 'Are you sure you want to decline this attendee?',
                cancelText: 'Cancel',
                confirmText: 'Ok',
                onConfirm: () => this.declineSubmit(dataId)
            });
        },
        declineSubmit(dataId) {
            axios.post('/event-attendees-decline/' + dataId).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


    },

    mounted() {
        this.loadAsyncData();
    }
}
</script>


<style scoped>
    .yes, .no, .pending {
        font-weight: bold;
        font-size: 12px;
        padding: 5px;
        color: white;
    }
    .yes{
        border: 1px solid green;
        background-color: green;
    }
    .no{
        border: 1px solid red;
        background-color: red;
    }
    .pending{
        border: 1px solid #7fa0e9;
        background-color: #7fa0e9;
    }

</style>
