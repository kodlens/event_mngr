<template>
    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8-widescreen is-10-desktop">

                    <div class="box">

                        <div class="table-box-title">CREATE QUESTIONS</div>
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

                                <div class="column">
                                    <b-field label="Input Type" label-position="on-border"
                                        expanded
                                        :type="this.errors.input_type ? 'is-danger':''"
                                        :message="this.errors.input_type ? this.errors.input_type[0] : ''">
                                        <b-select v-model="fields.input_type"
                                            expanded
                                            placeholder="Question" required>
                                            <option value="TEXT">TEXT</option>
                                            <option value="RATING">RATING</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <modal-browse-events :prop-name="fields.event"
                                         @browseEvents="emitBrowseEvent($event)"></modal-browse-events>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Question" label-position="on-border"
                                        :type="this.errors.question ? 'is-danger':''"
                                        :message="this.errors.question ? this.errors.question[0] : ''">
                                        <b-input v-model="fields.question"
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
                event_id: null,
                event: null,
                question: null,
                input_type: null
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

        deleteDropFile(index) {
            this.fields.event_img = null
        },

        getData(){
            this.fields.event_id =  this.propData.event_id
            this.fields.question =  this.propData.question
            this.fields.input_type =  this.propData.input_type
        },


        emitBrowseEvent(row){
            this.fields.event_id = row.event_id
            this.fields.event = row.event
            this.fields.academic_year_id = row.academic_year_id
        }
    },

    mounted(){
        if(this.propId > 0){
            this.getData()
        }
    }

}
</script>
