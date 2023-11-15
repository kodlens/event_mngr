<template>
    <section class="section">
        <div class="columns">
            <div class="column is-8 is-offset-2">
                <form @submit.prevent="submit">

                    <div class="box">
                        <div class="has-text-weight-bold mb-2">
                            REGISTER HERE
                        </div>

                        <div class="columns">
                                <div class="column">
                                    <b-field label="Username"
                                        :type="this.errors.username ? 'is-danger':''"
                                        :message="this.errors.username ? this.errors.username[0] : ''">
                                        <b-input type="text" v-model="fields.username" icon="account"></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Password"
                                        :type="this.errors.password ? 'is-danger':''"
                                        :message="this.errors.password ? this.errors.password[0] : ''">
                                        <b-input type="password"  v-model="fields.password" icon="lock" password-reveal></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Re-type Password">
                                        <b-input type="password" icon="lock" v-model="fields.password_confirmation" password-reveal></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Email"
                                             :type="this.errors.email ? 'is-danger':''"
                                             :message="this.errors.email ? this.errors.email[0] : ''">
                                        <b-input type="email" v-model="fields.email" icon="email"></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Contact No."
                                             :type="this.errors.contact_no ? 'is-danger':''"
                                             :message="this.errors.contact_no ? this.errors.contact_no[0] : ''">
                                        <b-input type="text" v-model="fields.contact_no" icon=""></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Last Name"
                                             :type="this.errors.lname ? 'is-danger':''"
                                             :message="this.errors.lname ? this.errors.lname[0] : ''" >
                                        <b-input icon="account" placeholder="First Lastname" v-model="fields.lname" type="text"></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="First Name"
                                             :type="this.errors.fname ? 'is-danger':''"
                                             :message="this.errors.fname ? this.errors.fname[0] : ''">
                                        <b-input icon="account" v-model="fields.fname" placeholder="First Name" type="text"></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Middle Name">
                                        <b-input v-model="fields.mname" type="text" placeholder="Middle Name"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Suffix">
                                        <b-input type="text" v-model="fields.suffix" placeholder="Suffix"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Sex" expanded
                                             :type="this.errors.sex ? 'is-danger':''"
                                             :message="this.errors.sex ? this.errors.sex[0] : ''">
                                        <b-select placeholder="Sex" v-model="fields.sex" icon="account" expanded>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            

                            <div class="buttons is-right">
                                <button class="button is-info">
                                    <b-icon class="mr-2" icon="content-save"></b-icon>
                                    REGISTER</button>
                            </div>
                        
                    </div> <!--box-->

                </form>
            </div><!--column-->
        </div><!--cols-->
    </section>
</template>

<script>
export default {

    data(){
        return{

            fields: {},
            errors: {},

        }
    },
    methods: {
    

        submit(){
            axios.post('/register-page', this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: "SAVED!",
                        message: 'Register successfully',
                        type: 'is-success',
                        onConfirm: ()=>  window.location = '/'
                    });
                }

            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
            });
        },

    },
    mounted() {
   
    }
}
</script>

<style scoped>


    .panel > .panel-heading{
        background-color: #4a5568;
        color:white;
    }

/*    dere lang kubia ang panel color*/
</style>
