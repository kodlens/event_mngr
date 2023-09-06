<template>
    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8-widescreen is-10-desktop">

                    <div class="box">

                        <div style="font-weight: bold; margin-bottom: 15px; font-size: 24px;">POST EVENT</div>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Event Date & Time" expanded
                                        :type="this.errors.datetime_event ? 'is-danger':''"
                                        :message="this.errors.datetime_event ? this.errors.datetime_event[0] : ''">
                                        <el-date-picker
                                            required
                                            v-model="fields.datetime_event"
                                            type="datetime"
                                            placeholder="Select date and time">
                                        </el-date-picker>
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

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Event Image">
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
                                            {{fields.event_img.name}}
                                            <button class="delete is-small"
                                                type="button"
                                                @click="deleteDropFile(0)">
                                            </button>
                                        </span>
                                    </div>
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

    data(){
        return{
            fields: {
                event: null,
                event_description: null,
                datetime_event: null,
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
            formData.append('datetime_event', this.fields.datetime_event ? this.fields.datetime_event : '');
            formData.append('event_img', this.fields.event_img ? this.fields.event_img : '');


            axios.post('/events', formData).then(res=>{
                
            }).catch(err=>{
                if(err.response.status == 422){
                    this.errors = err.response.data.errors
                }
            })
        },

        deleteDropFile(index) {
            this.fields.event_img.splice(index, 1)
        }
    }
}
</script>
