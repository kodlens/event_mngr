<template>
    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8-widescreen is-10-desktop">

                    <div class="box">

                        <div class="table-box-title">EVENT DETAILS</div>
                        <hr>

                        <div class="columns">
                            <div class="column">
                                <b-field label="Event Date" expanded
                                    :type="this.errors.event_date ? 'is-danger':''"
                                    :message="this.errors.event_date ? this.errors.event_date[0] : ''">
                                    <b-datepicker
                                        icon="calendar-today"
                                        required
                                        v-model="fields.event_date"
                                        placeholder="Select date and time"
                                        horizontal-time-picker>
                                    </b-datepicker>
                                </b-field>
                            </div>

                            <div class="column">
                                <b-field label="Time From" expanded
                                    :type="this.errors.event_time_from ? 'is-danger':''"
                                    :message="this.errors.event_time_from ? this.errors.event_time_from[0] : ''">
                                    <b-timepicker
                                        icon="clock"
                                        required
                                        v-model="fields.event_time_from"
                                        placeholder="Select time from"
                                        horizontal-time-picker>
                                    </b-timepicker>
                                </b-field>
                            </div>

                            <div class="column">
                                <b-field label="Time To" expanded
                                    :type="this.errors.event_time_to ? 'is-danger':''"
                                    :message="this.errors.event_time_to ? this.errors.event_time_to[0] : ''">
                                    <b-timepicker
                                        icon="clock"
                                        required
                                        v-model="fields.event_time_to"
                                        placeholder="Select time to"
                                        horizontal-time-picker>
                                    </b-timepicker>
                                </b-field>
                            </div>


                            </div>


                            <div class="columns">
                            <div class="column">
                                <b-field label="Event Type" expanded
                                    :type="this.errors.event_type_id ? 'is-danger':''"
                                    :message="this.errors.event_type_id ? this.errors.event_type_id[0] : ''">
                                    <b-select
                                        expanded
                                        required
                                        v-model="fields.event_type_id"
                                        placeholder="Event Type">
                                        <option v-for="(item, ix) in eventTypes" 
                                            :value="item.event_type_id"
                                            :key="`evtype${ix}`">{{item.event_type}}</option>
                                    </b-select>
                                </b-field>
                            </div>

                            <div class="column">
                                <b-field label="Facility/Equipment" expanded
                                    :type="this.errors.event_venue_id ? 'is-danger':''"
                                    :message="this.errors.event_venue_id ? this.errors.event_venue_id[0] : ''">
                                    <b-select
                                        expanded
                                        required
                                        v-model="fields.event_venue_id"
                                        placeholder="Facility/Equipment">
                                        <option v-for="(item, ix) in venues" 
                                            :value="item.event_venue_id"
                                            :key="`evtype${ix}`">{{item.event_venue}}</option>
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
                                    <!-- <b-input type="textarea" v-model="fields.event_description" placeholder="Descirption" required></b-input> -->
                                    <quill-editor
                                        :content="content"
                                        :options="editorOption"
                                        @change="onEditorChange($event)"
                                    />
                                
                                </b-field>
                            </div>
                            </div>

                            <div class="columns">
                            <div class="column">
                                <p v-if="propId > 0" style="font-size: 10px; font-weight: bold; color: red;">To update the image, just attach new image and the system will automatically remove the old save image.</p>
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
                            </div>


                            <div class="columns">
                            <div class="column">
                                <b-field label="Need Approval for Attendee?">
                                    <b-radio-button v-model="fields.is_need_approval"
                                        :native-value="0"
                                        type="is-danger is-light is-outlined">
                                        <b-icon icon="close"></b-icon>
                                        <span>NO</span>
                                    </b-radio-button>

                                    <b-radio-button v-model="fields.is_need_approval"
                                        :native-value="1"
                                        type="is-success is-light is-outlined">
                                        <b-icon icon="check"></b-icon>
                                        <span>YES</span>
                                    </b-radio-button>

                                </b-field>
                            </div>
                            </div>
                            <hr>
                            <div class="buttons is-right">
                            <b-button :class="btnClass" 
                                icon-left="content-save-all-outline"
                                @click="submit">
                                <b>SAVE</b>
                            </b-button>
                        </div>

                    </div> <!--box-->
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
            editorOption: {
            // Some Quill options...
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        ['clean'],
                    ],
                },
            },
            content: null,

          
            
            fields: {
                event: null,
                event_description: null,
                content: null,
                dateAndTime: null,
                event_img: null,
                event_type_id: 0,
                is_need_approval: 0
            },
            errors: {},

            eventTypes: [],
            venues: [],

            btnClass: {
                'button': true,
                'is-outlined' : true,
                'is-primary': true,
                'is-loading': false
            }
        }
    },

    methods:{

        submit(){  
            this.btnClass['is-loading'] = true
            const timeFrom = new Date(this.fields.event_time_from);
            const timeTo = new Date(this.fields.event_time_to);


            const from = timeFrom.getHours().toString().padStart(2, "0") + ':' 
                + (timeFrom.getMinutes() ).toString().padStart(2, "0") + ':00'
            const to = timeTo.getHours().toString().padStart(2, "0") + ':' 
                + (timeTo.getMinutes() ).toString().padStart(2, "0") + ':00'


            console.log(from);


            let formData = new FormData();
            formData.append('event', this.fields.event ? this.fields.event : '');
            formData.append('event_description', this.fields.event_description ? this.fields.event_description : '');
            formData.append('content', this.fields.content ? this.fields.content : '');
            formData.append('event_date', this.fields.event_date ? this.$formatDate(this.fields.event_date) : '');
            formData.append('event_img', this.fields.event_img ? this.fields.event_img : '');
            formData.append('event_type_id', this.fields.event_type_id ? this.fields.event_type_id : '');
            formData.append('event_venue_id', this.fields.event_venue_id ? this.fields.event_venue_id : '');
            formData.append('event_time_from', from ? from : '');
            formData.append('event_time_to', to ? to : '');
            formData.append('is_need_approval', this.fields.is_need_approval ? this.fields.is_need_approval : '0');


            if(this.propId > 0){
                //update
                axios.post('/events-update/' + this.propId, formData).then(res=>{
                    this.btnClass['is-loading'] = false
       
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
                    this.btnClass['is-loading'] = false

                    if(err.response.status === 422){
                        this.errors = err.response.data.errors
                    }
                })
            }else{
                //insert
                axios.post('/events', formData).then(res=>{
                    this.btnClass['is-loading'] = false

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
                    this.btnClass['is-loading'] = false

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
            this.content =  this.propData.content
            this.fields.event_date =  new Date(this.propData.event_date)
            this.fields.image_path = this.propData.img_path
            this.fields.event_type_id = this.propData.event_type_id
            this.fields.event_time_from =  new Date('2022-01-01 ' + this.propData.event_time_from)
            this.fields.event_time_to =  new Date('2022-01-01 ' +this.propData.event_time_to)
            this.fields.event_venue_id =  this.propData.event_venue_id
        },



        // quill editor
        onEditorBlur(quill) {
            console.log('editor blur!', quill)
        },
        onEditorFocus(quill) {
            console.log('editor focus!', quill)
        },
        onEditorReady(quill) {
            console.log('editor ready!', quill)
        },
        onEditorChange({ quill, html, text }) {
            console.log('editor change!', quill, html, text)
            this.fields.content = html
        },



        loadEventTypes(){
            axios.get('/load-event-types').then(res=>{
                this.eventTypes = res.data
            })
        },
        loadEventVenues(){
            axios.get('/load-event-venues').then(res=>{
                this.venues = res.data
            })
        }


    },

    mounted(){
        this.loadEventTypes()
        this.loadEventVenues()

        if(this.propId > 0){
            this.getData()
        }
    }

}
</script>
