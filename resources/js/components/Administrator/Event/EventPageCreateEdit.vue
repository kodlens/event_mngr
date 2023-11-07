<template>
    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8-widescreen is-10-desktop">

                    <div class="box">

                        <div class="table-box-title">POST EVENTS</div>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="columns">

                                <div class="column">
                                    <b-field label="Event Date & Time" expanded
                                        :type="this.errors.event_datetime ? 'is-danger':''"
                                        :message="this.errors.event_datetime ? this.errors.event_datetime[0] : ''">
                                        <b-datetimepicker
                                            icon="calendar-today"
                                            required
                                            v-model="fields.dateAndTime"
                                            placeholder="Select date and time"
                                            horizontal-time-picker>
                                        </b-datetimepicker>
                                    </b-field>
                                </div>


                                <div class="column">
                                    <b-field label="Event Type" expanded
                                        :type="this.errors.event_type ? 'is-danger':''"
                                        :message="this.errors.event_type ? this.errors.event_type[0] : ''">
                                        <b-select
                                            expanded
                                            required
                                            v-model="fields.event_type"
                                            placeholder="Event Type">
                                            <option value="WHOLEDAY">WHOLEDAY</option>
                                            <option value="HALFDAY">HALFDAY</option>
                                        </b-select>
                                    </b-field>
                                </div>

                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Event Title"
                                        :type="this.errors.event ? 'is-danger':''"
                                        :message="this.errors.event ? this.errors.event[0] : ''">
                                        <b-input type="text" v-model="fields.event" placeholder="Event" required></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Description"
                                        :type="this.errors.event_description ? 'is-danger':''"
                                        :message="this.errors.event_description ? this.errors.event_description[0] : ''">
                                        <b-input type="textarea" v-model="fields.event_description" placeholder="Descirption" required></b-input>
                                    </b-field>
                                </div>
                            </div>

                            <!-- <div class="columns">
                                <div class="column">
                                    <b-field label="Event Image (Landscape is recommended for better view)">
                                        <b-upload v-model="fields.event_img"
                                                drag-drop>
                                            <section class="section">
                                                <div class="content has-text-centered">
                                                    <p>
                                                        <b-icon
                                                            icon="upload"
                                                            size="is-large">
                                                        </b-icon>
                                                    </p>
                                                    <p>Drop your files here or click to upload</p>
                                                </div>
                                            </section>
                                        </b-upload>
                                    </b-field>

                                    <div v-if="fields.event_img" class="tags">
                                        <span class="tag is-primary">
                                            {{ fields.event_img.name }}
                                            <button class="delete is-small"
                                                type="button"
                                                @click="deleteDropFile(0)">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                            </div> -->

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
            //formData.append('event_img', this.fields.event_img ? this.fields.event_img : '');
            formData.append('event_type', this.fields.event_type ? this.fields.event_type : '');


            if(this.propId > 0){
                //update
                axios.post('/events-update/' + this.propId, formData).then(res=>{
       
                    if (res.data.status === 'updated'){
                       
                        this.$buefy.dialog.alert({
                            title: 'Saved.',
                            message: 'Successfully updated.',
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
            this.fields.event_type = this.propData.event_type

        }
    },

    mounted(){
        if(this.propId > 0){
            this.getData()
        }
    }

}
</script>
