<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6-widescreen is-7-desktop is-10-tablet">
                    <div class="box">

                        <div class="is-flex is-justify-content-center mb-2"
                            style="font-size: 20px; font-weight: bold;">LIST OF DEPARTMENTS</div>

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
                                                 v-model="search.code" placeholder="Search..."
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
<!-- 
                        <b-field label="Academic Year" label-position="on-border">
                            <b-select v-model="search.academic_year_id" @input="loadAsyncData()">
                                <option v-for="(item, index) in academic_years" :key="index"
                                    :value="item.academic_year_id">{{ item.academic_year_code }}</option>
                            </b-select>
                        </b-field> -->

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

                            <b-table-column field="department_id" label="Id" centered v-slot="props">
                                {{ props.row.department_id }}
                            </b-table-column>
                            <b-table-column field="code" label="Code" centered v-slot="props">
                                {{ props.row.code }}
                            </b-table-column>

                            <b-table-column field="department" label="Department" v-slot="props">
                                {{ props.row.department | truncate(50) }}
                            </b-table-column>

                            <b-table-column field="active" label="Active" v-slot="props">
                                <span v-if="props.row.active" class="yes">YES</span>
                                <span v-else class="no">NO</span>
                            </b-table-column>


                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small mr-1" tag="a" icon-right="pencil" 
                                            @click="getData(props.row.department_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small mr-1" icon-right="delete" 
                                            @click="confirmDelete(props.row.department_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>
                        </b-table>

                        <hr>
                        <div class="buttons mt-3">
                            <b-button
                                @click="openModal"
                                icon-right="chat-question"
                                class="is-primary is-outlined">NEW</b-button>
                        </div>

                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->





        <!--modal create-->
        <b-modal v-model="isModalCreate" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

            <form @submit.prevent="submit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Department Information</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Code" label-position="on-border"
                                        :type="this.errors.code ? 'is-danger':''"
                                        :message="this.errors.code ? this.errors.code[0] : ''">
                                        <b-input type="text" v-model="fields.code"
                                            placeholder="Code"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Department" label-position="on-border"
                                        :type="this.errors.department ? 'is-danger':''"
                                        :message="this.errors.department ? this.errors.department[0] : ''">
                                        <b-input type="text" v-model="fields.department"
                                            placeholder="Department"></b-input>
                                    </b-field>
                                </div>
                            </div>

                           
                            <div class="columns">
                                <div class="column">
                                    <b-field>
                                        <b-checkbox v-model="fields.active"
                                            :true-value="1"
                                            :false-value="0">
                                            Active
                                        </b-checkbox>
                                    </b-field>
                                </div>
                            </div>

                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            :class="btnClass"
                            @click="submit"
                            label="Save"
                            icon-left="content-save-all"
                            type="is-primary"></b-button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->



    </div>
</template>

<script>

export default{

    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'department_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 20,
            defaultSortDirection: 'asc',

            global_id: 0,

   
            search: {
                code: '',
            },

            fields: {
                code: null,
                department: null,
                active: null
            },
            errors: {},

            isModalCreate: false,
            btnClass: {
                'is-primary': true,
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
                `code=${this.search.code}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-departments?${params}`)
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
            axios.delete('/departments/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


        openModal(){
            this.isModalCreate = true
            this.clearFields()
            this.global_id = 0
        },

        submit(){
            this.btnClass['is-loading'] = true

            if(this.global_id > 0){
                //update
                axios.put('/departments/' + this.global_id, this.fields).then(res=>{
                  
                    this.btnClass['is-loading'] = false
                    if(res.data.status === 'updated'){
                       
                        this.$buefy.dialog.alert({
                            title: 'Updated.',
                            message: 'Successfully updated.',
                            onConfirm: ()=>{
                                this.clearFields()
                                this.loadAsyncData()
                                this.isModalCreate = false
                            }
                        })
                    }
                }).catch(err=>{
                    this.btnClass['is-loading'] = false

                    if(err.response.status === 422){
                        this.errors = err.response.data.errors
                    }
                })
            }else{
                //insert
                axios.post('/departments', this.fields).then(res=>{
                    this.btnClass['is-loading'] = false

                    if(res.data.status === 'saved'){

                        this.$buefy.dialog.alert({
                            title: 'Saved.',
                            message: 'Successfully saved.',
                            onConfirm: ()=>{
                                this.clearFields()
                                this.loadAsyncData()
                                this.isModalCreate = false
                            }
                        })
                    }
                }).catch(err=>{
                    this.btnClass['is-loading'] = false

                    if(err.response.status === 422){
                        this.errors = err.response.data.errors
                    }
                })
            }
        },

        clearFields(){
            this.fields.code = null
            this.fields.department = null
            this.fields.active = null
        },

        //update code here
        getData: function(data_id){

            this.clearFields();

            this.global_id = data_id;
            this.isModalCreate = true;

            axios.get('/departments/'+ data_id).then(res=>{
                this.fields = res.data;
            });
        },

    },

    mounted() {
        //this.loadAcademicYears()
        this.loadAsyncData();
    }
}
</script>


<style scoped>
     .yes, .no {
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

</style>
