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
                                {{ props.row.event_id }}
                            </b-table-column>

                            <b-table-column field="academic_year" label="AY" v-slot="props">
                                {{ props.row.academic_year.academic_year_code }}
                            </b-table-column>

                            <b-table-column field="event" label="Event" v-slot="props">
                                {{ props.row.event }}
                            </b-table-column>

                            <b-table-column field="event_type" label="Type" v-slot="props">
                                {{ props.row.event_type }}
                            </b-table-column>

                            <b-table-column field="content" label="Content" v-slot="props">
                                {{ props.row.content | truncate(70) }}
                            </b-table-column>

                            <b-table-column field="event_datetime" label="Date Time" v-slot="props">
                                {{ props.row.event_datetime | formatDateTime }}
                            </b-table-column>

                            <b-table-column field="approval_status" label="Status" v-slot="props">
                                <span v-if="props.row.approval_status === 1" class="yes">APPROVED</span>
                                <span v-else-if="props.row.approval_status === 0" class="pending">PENDING</span>
                                <span v-else-if="props.row.approval_status === 2" class="no">CANCELLED</span>
                            </b-table-column>


                            <b-table-column field="approval_status" label="Open" v-slot="props">
                                <span v-if="props.row.is_open === 1" class="yes">YES</span>
                                <span v-else class="no">NO</span>
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
                                            @click="confirmApprove(props.row.event_id)">
                                            Approve
                                            <b-icon icon="thumb-up-outline" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            @click="confirmCancel(props.row.event_id)">Cancel
                                            <b-icon icon="cancel" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            tag="a"
                                            :href="`/events/${props.row.event_id}/edit`">
                                            Edit
                                            <b-icon icon="pencil" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            @click="confirmEval(props.row.event_id)">
                                            Open Evaluation
                                            <b-icon icon="open-in-app" size="is-small"></b-icon>
                                        </b-dropdown-item>
                                        <b-dropdown-item aria-role="listitem"
                                            @click="confirmCloseEval(props.row.event_id)">
                                            Close Evaluation
                                            <b-icon icon="close" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            @click="confirmDelete(props.row.event_id)">
                                            Delete
                                            <b-icon icon="delete" size="is-small"></b-icon>
                                        </b-dropdown-item>
                                    </b-dropdown>
                                </div>
                            </b-table-column>
                        </b-table>

                        <hr>

                        <div class="buttons mt-3">
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
            axios.post('/events-approve/' + dataId).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


        confirmCancel(dataId){
            this.$buefy.dialog.confirm({
                title: 'Cancel?',
                type: 'is-info',
                message: 'Cancel this event?',
                confirmText: 'Cancel',
                onConfirm: () => this.submitCancel(dataId)
            });
        },
        submitCancel(dataId){
            axios.post('/events-cancel/' + dataId).then(res => {
                this.loadAsyncData();
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

    .pending {
        border: 1px solid green;
        background-color: rgb(64, 97, 185);
    }

</style>
