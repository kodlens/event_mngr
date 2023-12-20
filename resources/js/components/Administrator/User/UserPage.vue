<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-11-tablet is-11-desktop is-10-widescreen">
                    <div class="box">

                        <div class="is-flex is-justify-content-center mb-2"
                            style="font-size: 20px; font-weight: bold;">LIST OF USER</div>

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
                            narrowed
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
<!--
                            <b-table-column field="user_id" label="ID" v-slot="props">
                                {{ props.row.user_id }}
                            </b-table-column> -->

                            <b-table-column field="ref" label="Reference Code" v-slot="props">
                                {{ props.row.qr_code }}
                            </b-table-column>

                            <b-table-column field="username" label="Username" v-slot="props">
                                {{ props.row.username }}
                            </b-table-column>

                            <b-table-column field="lname" label="Last Name" v-slot="props">
                                {{ props.row.lname }}
                            </b-table-column>

                            <b-table-column field="lname" label="First Name" v-slot="props">
                                {{ props.row.fname }}
                            </b-table-column>

                            <b-table-column field="mname" label="Middle Name" v-slot="props">
                                {{ props.row.mname }}
                            </b-table-column>

                            <b-table-column field="sex" label="Sex" v-slot="props">
                                {{ props.row.sex }}
                            </b-table-column>

                            <b-table-column field="role" label="User Type" v-slot="props">
                                <span v-if="props.row.role === 'ADMINISTRATOR'">ADMINISTRATOR</span>
<!--                                <span v-if="props.row.role === 'ADMINSTAFF'">ADMINSTAFF</span>-->
                                <span v-if="props.row.role === 'APPROVING OFFICER'">APPROVING OFFICER</span>
                                <span v-if="props.row.role === 'REQUESTING PARTY'">REQUESTING PARTY</span>
                                <span v-if="props.row.role === 'ATTENDEE'">ATTENDEE</span>
                            </b-table-column>



                            <b-table-column field="active" label="Activated" v-slot="props">
                                <span v-if="props.row.email_verified_at" class="yes">YES</span>
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
                                            @click="confirmActivate(props.row.user_id)">
                                            Activate
                                            <b-icon icon="thumb-up-outline" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            @click="openModalResetPassword(props.row.user_id)">Change Password
                                            <b-icon icon="lock" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            @click="getData(props.row.user_id)">
                                            Edit
                                            <b-icon icon="pencil" size="is-small"></b-icon>
                                        </b-dropdown-item>

                                        <b-dropdown-item aria-role="listitem"
                                            @click="confirmDelete(props.row.user_id)">
                                            Delete
                                            <b-icon icon="delete" size="is-small"></b-icon>
                                        </b-dropdown-item>
                                    </b-dropdown>
                                </div>
                            </b-table-column>


                            <template  #detail="props">
                                <tr>
                                    <th>Email</th>
                                    <!-- <th>Contact No.</th> -->
                                    <th>Department</th>
                                    <th>Approving Officer</th>
                                </tr>
                                <tr>
                                    <td>
                                        {{ props.row.email }}
                                    </td>
                                    <!-- <td>
                                        <span v-if="props.row.contact_no">
                                            {{ props.row.contact_no }}
                                        </span>
                                    </td> -->
                                    <td>
                                        <span v-if="props.row.department">
                                            {{ props.row.department.code }}
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="props.row.ao">
                                            {{ props.row.ao.lname }}, {{ props.row.ao.fname}} {{ props.row.ao.mname }}
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </b-table>

                        <hr>
                        <div class="buttons mt-3">
                            <b-button @click="openModal"
                                icon-right="account-arrow-up-outline"
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
                        <p class="modal-card-title">User Information</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Username" label-position="on-border"
                                        :type="this.errors.username ? 'is-danger':''"
                                        :message="this.errors.username ? this.errors.username[0] : ''">
                                        <b-input v-model="fields.username"
                                                 placeholder="Username" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Last Name" label-position="on-border"
                                             :type="this.errors.lname ? 'is-danger':''"
                                             :message="this.errors.lname ? this.errors.lname[0] : ''">
                                        <b-input v-model="fields.lname"
                                                 placeholder="Last Name" required>
                                        </b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="First Name" label-position="on-border"
                                             :type="this.errors.fname ? 'is-danger':''"
                                             :message="this.errors.fname ? this.errors.fname[0] : ''">
                                        <b-input v-model="fields.fname"
                                                 placeholder="First Name" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Middle Name" label-position="on-border"
                                             :type="this.errors.mname ? 'is-danger':''"
                                             :message="this.errors.mname ? this.errors.mname[0] : ''">
                                        <b-input v-model="fields.mname"
                                                 placeholder="Middle Name">
                                        </b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Suffix" label-position="on-border"
                                             :type="this.errors.suffix ? 'is-danger':''"
                                             :message="this.errors.suffix ? this.errors.suffix[0] : ''">
                                        <b-input v-model="fields.suffix"
                                                 placeholder="Suffix">
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <!-- <div class="columns">
                                <div class="column">
                                    <b-field label="Contact No." label-position="on-border"
                                             :type="this.errors.contact_no ? 'is-danger':''"
                                             :message="this.errors.contact_no ? this.errors.contact_no[0] : ''">
                                        <b-input v-model="fields.contact_no"
                                                 placeholder="Contact No.">
                                        </b-input>
                                    </b-field>
                                </div>
                            </div> -->



                            <div class="columns" v-if="global_id < 1">
                                <div class="column">
                                    <b-field label="Password" label-position="on-border"
                                             :type="this.errors.password ? 'is-danger':''"
                                             :message="this.errors.password ? this.errors.password[0] : ''">
                                        <b-input type="password" password-reveal v-model="fields.password"
                                                 placeholder="Password" required>
                                        </b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Confirm Password" label-position="on-border"
                                             :type="this.errors.password_confirmation ? 'is-danger':''"
                                             :message="this.errors.password_confirmation ? this.errors.password_confirmation[0] : ''">
                                        <b-input type="password" v-model="fields.password_confirmation"
                                                 placeholder="Confirm Password" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Email" label-position="on-border"
                                        :type="this.errors.email ? 'is-danger':''"
                                        :message="this.errors.email ? this.errors.email[0] : ''">
                                        <b-input type="email" v-model="fields.email"
                                            placeholder="Email" required>
                                        </b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Department" label-position="on-border" expanded
                                            :type="this.errors.department_id ? 'is-danger':''"
                                            :message="this.errors.department_id ? this.errors.department_id[0] : ''">
                                        <b-select v-model="fields.department_id" expanded>
                                            <option v-for="(item, index) in departments"
                                                :key="index"
                                                :value="item.department_id">{{ item.code }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Sex" label-position="on-border" expanded
                                             :type="this.errors.sex ? 'is-danger':''"
                                             :message="this.errors.sex ? this.errors.sex[0] : ''"
                                            >
                                        <b-select v-model="fields.sex" expanded>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </b-select>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="User Type" label-position="on-border" expanded
                                             :type="this.errors.role ? 'is-danger':''"
                                             :message="this.errors.role ? this.errors.role[0] : ''">
                                        <b-select v-model="fields.role" expanded
                                            @input="loadApprovingOfficers">
                                            <option value="ADMINISTRATOR">ADMINISTRATOR</option>
<!--                                            <option value="ADMINSTAFF">ADMINSTAFF</option>-->
                                            <option value="APPROVING OFFICER">APPROVING OFFICER</option>
                                            <option value="REQUESTING PARTY">REQUESTING PARTY</option>
                                            <option value="ATTENDEE">ATTENDEE</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>
                            <!-- <div class="columns" v-if="fields.role === 'ORGANIZER'">
                                <div class="column">
                                    <b-field label="Select Approving Officer"
                                             expanded
                                             label-position="on-border"
                                             :type="this.errors.ao_user_id ? 'is-danger':''"
                                             :message="this.errors.ao_user_id ? this.errors.ao_user_id[0] : ''">
                                        <b-select v-model="fields.ao_user_id"
                                                  expanded>
                                            <option v-for="(item, index) in approvingOfficers" :key="`ao${index}`"
                                                :value="item.user_id">
                                                {{ item.lname }}, {{ item.fname }} {{ item.mname }}
                                            </option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div> -->
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->










        <!--modal reset password-->
        <b-modal v-model="modalResetPassword" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal>

            <form @submit.prevent="resetPassword">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Change Password</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalResetPassword = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Password" label-position="on-border"
                                             :type="this.errors.password ? 'is-danger':''"
                                             :message="this.errors.password ? this.errors.password[0] : ''">
                                        <b-input type="password" v-model="fields.password" password-reveal
                                                 placeholder="Password" required>
                                        </b-input>
                                    </b-field>
                                    <b-field label="Confirm Password" label-position="on-border"
                                             :type="this.errors.password_confirmation ? 'is-danger':''"
                                             :message="this.errors.password_confirmation ? this.errors.password_confirmation[0] : ''">
                                        <b-input type="password" v-model="fields.password_confirmation"
                                                 password-reveal
                                                 placeholder="Confirm Password" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
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
            sortField: 'user_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 20,
            defaultSortDirection: 'asc',


            global_id : 0,

            search: {
                lname: '',
            },

            isModalCreate: false,
            modalResetPassword: false,

            fields: {
                user_id: null,
                username: null,
                lname: null, fname: null, mname: null, suffix: null,
                password: null, password_confirmation : null,
                sex : null, role: null, contact_no : null, department_id: null,
                ao_user_id: null
            },

            errors: {},
            departments: [],

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

            approvingOfficers: [],

        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `lname=${this.search.lname}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-users?${params}`)
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

        openModal(){
            this.isModalCreate=true;
            this.fields = {};
            this.errors = {};
        },



        submit: function(){
            //this.fields.department_id = this.fields.role === 'ADMINISTRATOR' ? 0 : this.fields.depid;

            if(this.global_id > 0){
                //update
                axios.put('/users/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.isModalCreate = false;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                })
            }else{
                //INSERT HERE
                axios.post('/users', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.isModalCreate = false;
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });
            }
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
            axios.delete('/users/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        clearFields(){
            this.fields.user_id = null
            this.fields.username = null;
            this.fields.lname = null;
            this.fields.fname = null;
            this.fields.mname = null;
            this.fields.suffix = null;
            this.fields.sex = null;
            this.fields.password = null;
            this.fields.password_confirmation = null;
            this.fields.role = null;
            this.fields.ao_user_id = null;
            this.fields.contact_no = null;
            this.fields.department_id = null
        },


        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.isModalCreate = true;

            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/users/'+data_id).then(res=>{
                this.fields = res.data;
            });
        },

        loadDepartments(){
            axios.get('/load-departments').then(res=>{
                this.departments = res.data
            })
        },


        //alert box ask for deletion
        confirmActivate(dataId) {
            this.$buefy.dialog.confirm({
                title: 'Activate?',
                type: 'is-info',
                message: 'Do you want to activate this account?',
                cancelText: 'Cancel',
                confirmText: 'Activate',
                onConfirm: () => this.submitActivate(dataId)
            });
        },
        //execute delete after confirming
        submitActivate(dataId) {
            axios.post('/user-activate/' + dataId).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


        openModalResetPassword(dataId){
            this.modalResetPassword = true;
            this.clearFields()
            this.errors = {};
            this.fields.user_id = dataId;
        },

        resetPassword(){
            axios.post('/reset-password/' + this.fields.user_id, this.fields).then(res=>{

                if(res.data.status === 'changed'){
                    this.$buefy.dialog.alert({
                        title: 'PASSWORD CHANGED',
                        type: 'is-success',
                        message: 'Password changed successfully.',
                        confirmText: 'OK',
                        onConfirm: () => {
                            this.modalResetPassword = false;
                            this.fields = {};
                            this.errors = {};
                            this.loadAsyncData()
                        }
                    });
                }

            }).catch(err=>{
                this.errors = err.response.data.errors;
            })
        },


    },

    mounted() {
        this.loadDepartments()
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
