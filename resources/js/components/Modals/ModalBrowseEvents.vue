<template>
    <div>
        

        <b-field label="Event" label-position="on-border">
            <b-input :value="valueName" expanded
                icon="calendar-text-outline" 
                placeholder="Select Event" 
                required readonly>
            </b-input>

            <p class="control">
                <b-button 
                    class="button is-primary" 
                    @click="openModal">...</b-button>
            </p>
        </b-field>


        <b-modal v-model="this.isModalActive" has-modal-card
                 trap-focus scroll="keep" aria-role="dialog" aria-modal>
            <div class="modal-card card-width">
                <header class="modal-card-head">
                    <p class="modal-card-title">Select Event</p>
                    <button type="button" class="delete"
                            @click="isModalActive = false" />

                </header>

                <section class="modal-card-body">
                    <div>
                        <b-field label="Academic Year" label-position="on-border" expanded>
                            <b-select expanded 
                                @input="loadAsyncData"
                                v-model="search.ayid" >
                                <option v-for="(item, index) in academicYears" 
                                    :key="index"
                                    :value="item.academic_year_id"> 
                                        {{ item.academic_year_code }} - {{ item.academic_year_desc }}
                                    </option>
                            </b-select>
                        </b-field>
                        <b-field label="Search" label-position="on-border" >
                            <b-input type="text" v-model="search.event"
                                 placeholder="Search Item Name..."
                                 @keyup.native.enter="loadAsyncData" expanded auto-focus></b-input>
                            <p class="control">
                                <b-button class="is-primary" icon-pack="fa" icon-left="search" @click="loadAsyncData"></b-button>
                            </p>
                        </b-field>

                        <div class="table-container">
                            <b-table
                                :data='data'
                                :loading="loading"
                                paginated
                                backend-pagination
                                :total='total'
                                :per-page="perPage"
                                @page-change="onPageChange"
                                detail-transition=""
                                aria-next-label="Next page"
                                aria-previous-label="Previouse page"
                                aria-page-label="Page"
                                :show-detail-icon=true
                                aria-current-label="Current page"
                                default-sort-direction="defualtSortDirection"
                                @sort="onSort">

                                <b-table-column field="event_id" label="ID" v-slot="props">
                                    {{props.row.event_id}}
                                </b-table-column>

                                <b-table-column field="event" label="Event" v-slot="props">
                                    {{props.row.event }}
                                </b-table-column>

                                <b-table-column field="event_desc" label="Description" v-slot="props">
                                    {{ props.row.event_description | truncate(70) }}
                                </b-table-column>

                                <b-table-column field="" label="Action" v-slot="props">
                                    <div class="buttons">
                                        <b-button class="is-small is-warning" @click="selectData(props.row)">
                                            <i class="fa fa-pencil"></i>&nbsp;&nbsp;SELECT</b-button>
                                    </div>
                                </b-table-column>
                            </b-table>
                        </div>

                    </div>
                </section>

                <footer class="modal-card-foot">
                    <b-button
                        label="Close"
                        @click="isModalActive=false"></b-button>
                </footer>
            </div>
        </b-modal>


    </div>
</template>

<script>
export default {
    props: {
        propName: {
            type: String,
            default: '',
        },

    },


    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'event_id',
            sortOrder:'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection:'',

            isModalActive: false,
            errors:{},

            academicYears: [],

            event: {},

            search: {
                ayid: null,
                event: '',
            },
        }
    },
    methods: {
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `ayid=${this.search.ayid}`,
                `event=${this.search.event}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/load-browse-events?${params}`)
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

        onPageChange(page) {
            this.page = page;
            this.loadAsyncData();
        },

        onSort(field, order) {
            this.sortfield = field;
            this.sortOrder = order;
            this.loadAsyncData();
        },

        setPerPage() {
            this.loadAsyncData();
        },

        loadAcademicYears(){
            axios.get(`/load-academic-years`).then(res=>{
                this.academicYears = res.data
            })
        },


        openModal(){
            this.loadAsyncData();
            this.isModalActive = true;
        },

        selectData(dataRow){
            this.isModalActive = false;
            this.$emit('browseEvents', dataRow);
        }

    },

    mounted(){
        this.loadAcademicYears()
    },

    computed: {
        valueName(){
            return this.propName;
        },




    },

}
</script>

<style scoped>
.card-width{
    width: 640px;
}
</style>
