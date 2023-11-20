<template>
    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6">

                    <div class="box">

                        <div class="table-box-title">CREATE/EDIT QUESTION</div>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Order No." label-position="on-border"
                                        expanded
                                        :type="this.errors.order_no ? 'is-danger':''"
                                        :message="this.errors.order_no ? this.errors.order_no[0] : ''">
                                        <b-numberinput v-model="fields.order_no"
                                            placeholder="Order No."
                                            :controls="false"></b-numberinput>
                                    </b-field>
                                </div>

                               
                            </div>

                        
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Question" label-position="on-border"
                                        :type="this.errors.question ? 'is-danger':''"
                                        :message="this.errors.question ? this.errors.question[0] : ''">
                                        <b-input type="textarea" v-model="fields.question"
                                            placeholder="Question" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>



                            <hr>
                            <div class="buttons is-right">
                                <button class="button is-outlined is-primary">
                                    <b-icon icon="content-save-all-outline"></b-icon>
                                    <b>SAVE</b>
                                </button>
                            </div>
                        </form> <!--form-->
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

export default {

    props: {
        propId: {
            type: Number,
            default: 0
        },

        propData: {
            type: Object,
            default: {}
        }
    },

    data(){
        return{
            fields: {
                order_no: null,
                question: null,
                
            },
            errors: {},
        }
    },

    methods:{

        submit(){

            if(this.propId > 0){
                //update
                axios.post('/questions/' + this.propId, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialg.alert({
                            title: 'Saved.',
                            message: 'Successfully saved.',
                            onConfirm: ()=>{
                                window.location = '/questions';
                            }
                        })

                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors
                    }
                })
            }else{
                //insert
                axios.post('/questions', this.fields).then(res=>{

                    if(res.data.status === 'saved'){

                        this.$buefy.dialog.alert({
                            title: 'Saved.',
                            message: 'Successfully saved.',
                            onConfirm: ()=>{
                                window.location = '/questions';
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors
                    }
                })
            }

        },


        getData(){
            this.fields.question =  this.propData.question
        },


        emitBrowseEvent(row){
            this.fields.event = row.event
        }
    },

    mounted(){
        if(this.propId > 0){
            this.getData()
        }
    }

}
</script>
