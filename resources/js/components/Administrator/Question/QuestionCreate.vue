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

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Input Type" label-position="on-border"
                                             :type="this.errors.input_type ? 'is-danger':''"
                                             :message="this.errors.input_type ? this.errors.input_type[0] : ''">
                                        <b-select v-model="fields.input_type"
                                                  placeholder="Question" required>
                                            <option value="TEXT">TEXT</option>
                                            <option value="RATING">RATING</option>
                                        </b-select>
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
                event: null,
                event_description: null,
                dateAndTime: null,
                event_img: null
            },
            errors: {},
        }
    },

    methods:{

        submit(){

            let formData = new FormData();
            formData.append('event', this.fields.event ? this.fields.event : '');
            formData.append('event_description', this.fields.event_description ? this.fields.event_description : '');
            formData.append('event_datetime', this.fields.dateAndTime ? this.$formatDateAndTime(this.fields.dateAndTime) : '');
            formData.append('event_img', this.fields.event_img ? this.fields.event_img : '');


            if(this.propId > 0){
                //update
                axios.post('/events-update', formData).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialg.alert({
                            title: 'Saved.',
                            message: 'Successfully saved.',
                            onConfirm: ()=>{
                                window.location = '/events';
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
                axios.post('/events', formData).then(res=>{

                    if(res.data.status === 'saved'){

                        this.$buefy.dialog.alert({
                            title: 'Saved.',
                            message: 'Successfully saved.',
                            onConfirm: ()=>{
                                window.location = '/events';
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
            this.fields.event =  this.propData.event
            this.fields.event_description =  this.propData.event_description
            this.fields.dateAndTime =  new Date(this.propData.event_datetime)
            this.fields.image_path = this.propData.img_path
        },


        emitBrowseEvent(row){
            console.log(row)
        }
    },

    mounted(){
        if(this.propId > 0){
            this.getData()
        }
    }

}
</script>
