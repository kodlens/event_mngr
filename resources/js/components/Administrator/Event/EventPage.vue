<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-11-desktop is-10-widescreen">
                    <div class="box">

                        <div class="is-flex is-justify-content-center mb-2"
                            style="font-size: 20px; font-weight: bold;">LIST OF EVENTS</div>
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
                                            v-model="search.event" placeholder="Search Event"
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

                            <!-- <b-table-column field="event_id" label="ID" v-slot="props">
                                {{ props.row.event_id }}
                            </b-table-column> -->

                            <b-table-column field="academic_year" label="AY" v-slot="props">
                                {{ props.row.academic_year.academic_year_code }}
                            </b-table-column>

                            <b-table-column field="event" label="Event" v-slot="props">
                                {{ props.row.event }}
                            </b-table-column>

                            <b-table-column field="event_type" label="Type" v-slot="props">
                                {{ props.row.event_type.event_type }}
                            </b-table-column>

                            <b-table-column field="content" label="Description" v-slot="props">
                                {{ props.row.content | truncate(50) }}
                            </b-table-column>

                            <b-table-column field="event_date" label="Date" v-slot="props">
                                {{ new Date(props.row.event_date).toLocaleDateString() }}
                            </b-table-column>

                            <b-table-column field="time" label="Time" v-slot="props">
                                {{ props.row.event_time_from | formatTime }} - 
                                {{ props.row.event_time_to | formatTime }}
                            </b-table-column>

                            <b-table-column field="duration" label="Duration" v-slot="props">
                                {{ durationHours(
                                    new Date(props.row.event_date + ' ' + props.row.event_time_from),
                                    new Date(props.row.event_date + ' ' + props.row.event_time_to)
                                ) }}
                               
                            </b-table-column>

                            <b-table-column field="approval_status" label="Status" v-slot="props">
                                <span v-if="props.row.approval_status === 1" class="yes">APPROVED</span>
                                <span v-else-if="props.row.approval_status === 0" class="pending">PENDING</span>
                                <span v-else-if="props.row.approval_status === 2" class="no">DECLINED</span>
                            </b-table-column>


                            <b-table-column field="approval_status" label="Evaluation" v-slot="props">
                                <span v-if="props.row.is_open === 1" class="yes">OPEN</span>
                                <span v-else class="no">CLOSE</span>
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">

                                    <b-dropdown aria-role="list">
                                        <template #trigger="{ active }">
                                            <b-button
                                                label=""
                                                class="is-small"
                                                type="is-info"
                                                icon-left="menu"
                                                :icon-right="active ? 'menu-up' : 'menu-down'" />
                                        </template>

                                        <b-dropdown-item aria-role="listitem"
                                            v-if="['ORGANIZER'].includes(propUser.role)"
                                            @click="gotoListAttendee(props.row.event_id)">
                                            List of Attendee
                                            <b-icon icon="account" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            v-if="['EVENT OFFICER'].includes(propUser.role)"
                                            @click="confirmApprove(props.row.event_id)">
                                            Approve
                                            <b-icon icon="thumb-up-outline" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            v-if="['EVENT OFFICER'].includes(propUser.role)"
                                            @click="confirmCancel(props.row.event_id)">
                                            Decline
                                            <b-icon icon="cancel" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            v-if="['EVENT OFFICER'].includes(propUser.role)"
                                            tag="a"
                                            :href="`/events/${props.row.event_id}/edit`">
                                            Edit
                                            <b-icon icon="pencil" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            v-if="['EVENT OFFICER'].includes(propUser.role)"
                                            @click="confirmEval(props.row.event_id)">
                                            Open Evaluation
                                            <b-icon icon="open-in-app" size="is-small"></b-icon>
                                        </b-dropdown-item>
                                        <b-dropdown-item aria-role="listitem"
                                            v-if="['EVENT OFFICER'].includes(propUser.role)"
                                            @click="confirmCloseEval(props.row.event_id)">
                                            Close Evaluation
                                            <b-icon icon="close" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                        v-if="['EVENT OFFICER'].includes(propUser.role)"
                                            @click="confirmDelete(props.row.event_id)">
                                            Delete
                                            <b-icon icon="delete" size="is-small"></b-icon>
                                        </b-dropdown-item>
                                    </b-dropdown>
                                </div>
                            </b-table-column>

                            <template #detail="props">
                                <tr>
                                    <th>Need Approval</th>
                                    <th>Approve By</th>

                                </tr>
                                <tr>
                                    <td>
                                        <span v-if="props.row.is_need_approval === 1" class="yes">YES</span>
                                        <span v-else-if="props.row.is_need_approval === 0" class="pending">NO</span>
                                    </td>
                                    <td>
                                        <span v-if="props.row.approve_by">{{ props.row.approve_by }}</span>
                                    </td>
                                </tr>
                            </template>
                        </b-table>

                        <hr>

                        <div class="buttons mt-3" v-if="['ORGANIZER'].includes(propUser.role)">
                            <b-button tag="a"
                                href="/events/create"
                                icon-right="calendar" class="is-primary is-outlined">NEW</b-button>
                        </div>
                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->




    </div>
</template>

<script>

export default{

    props: {
        propUser:{
            type: Object,
            default: {}
        },
    },
   

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
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-events?${params}`)
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

        //approve
        confirmApprove(dataId){
            this.$buefy.dialog.confirm({
                title: 'APPROVE?',
                type: 'is-info',
                message: 'Approve this event?',
                cancelText: 'Cancel',
                confirmText: 'Approve',
                onConfirm: () => this.submitApprove(dataId)
            });
        },
        submitApprove(dataId){
            this.loading = true
            axios.post('/events-approve/' + dataId).then(res => {
                
                if(res.data.status === 'approved'){
                    this.loadAsyncData();
                    this.loading = false

                    this.$buefy.dialog.alert({
                        title: 'Approved',
                        type: 'is-info',
                        message: 'Event approved and notification was sent to the creator of the event and the participants.'
                    });
                }
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


        confirmCancel(dataId){
            this.$buefy.dialog.confirm({
                title: 'Decline?',
                type: 'is-info',
                message: 'Decline this event?',
                confirmText: 'Yes',
                onConfirm: () => this.submitCancel(dataId)
            });
        },
        submitCancel(dataId){
            this.loading = true
            axios.post('/events-cancel/' + dataId).then(res => {
                if(res.data.status === 'declined'){
                    this.loadAsyncData();
                    this.loading = false

                    this.$buefy.dialog.alert({
                        title: 'Declined',
                        type: 'is-info',
                        message: 'Event declined and notification was sent to the creator of the event.'
                    });
                }

            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


        confirmEval(dataId) {
            this.$buefy.dialog.confirm({
                title: 'Open?',
                type: 'is-info',
                message: 'Are you sure you want to open the evaluation?',
                cancelText: 'Cancel',
                confirmText: 'Open',
                onConfirm: () => this.submitOpenEval(dataId)
            });
        },
        submitOpenEval(dataId){
            axios.post('/events-open-evaluation/' + dataId).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },
        confirmCloseEval(dataId) {
            this.$buefy.dialog.confirm({
                title: 'Close?',
                type: 'is-info',
                message: 'Are you sure you want to close the evaluation?',
                cancelText: 'Cancel',
                confirmText: 'Open',
                onConfirm: () => this.submitCloseEval(dataId)
            });
        },
        submitCloseEval(dataId){
            axios.post('/events-close-evaluation/' + dataId).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        gotoListAttendee(dataId){
            window.location = '/event-attendees/' + dataId
        },

        durationHours(stime, etime){
            let timeDifference =  etime - stime;
            // Convert milliseconds to hours
            let hoursDifference = timeDifference / (1000 * 60 * 60);
            let result = parseFloat(hoursDifference.toFixed(2))
            return result + 'hour(s)'
        }

    },

    mounted() {
        this.loadAsyncData();
    },


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

    .pending {
        border: 1px solid green;
        background-color: rgb(64, 97, 185);
    }

</style>
