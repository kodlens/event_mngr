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
                                <b-field label="Date From" expanded
                                    :type="this.errors.event_date_from ? 'is-danger':''"
                                    :message="this.errors.event_date_from ? this.errors.event_date_from[0] : ''">
                                    <b-datepicker
                                        icon="calendar-today"
                                        required
                                        :min-date="minDate"
                                        editable
                                        v-model="fields.event_date_from"
                                        placeholder="Select date"
                                        horizontal-time-picker>
                                    </b-datepicker>
                                </b-field>
                            </div>

                            <div class="column">
                                <b-field label="Date To" expanded
                                         :type="this.errors.event_date_to ? 'is-danger':''"
                                         :message="this.errors.event_date_to ? this.errors.event_date_to[0] : ''">
                                    <b-datepicker
                                        icon="calendar-today"
                                        required
                                        :min-date="fromStartDate"
                                        editable
                                        v-model="fields.event_date_to"
                                        placeholder="Select date"
                                        horizontal-time-picker>
                                    </b-datepicker>
                                </b-field>
                            </div>

                            <div class="column">
                                <b-field label="From" expanded
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
                                <b-field label="Until" expanded
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
                                    <b-field label="Select Approving Officer"
                                        expanded
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
                                            :content="event_content"
                                            :options="editorOption"
                                            @change="onEditorChange($event)"
                                        />

                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <p v-if="propId > 0" style="font-size: 10px; font-weight: bold; color: rgb(44, 44, 44);">To update the image, just attach new image and the system will automatically remove the old save image.</p>
                                    <b-field label="Event Image (Landscape is recommended for better view)"
                                        :type="this.errors.event_img ? 'is-danger':''"
                                        :message="this.errors.event_img ? this.errors.event_img[0] : ''">
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
                            <hr>
                            <div class="columns">
                                <div class="column">
                                    <p v-if="propId > 0" style="font-size: 10px; font-weight: bold; color: rgb(44, 44, 44);">
                                        To update the file, just attach new file and the system will automatically remove the old file.</p>
                                    <b-field label="File Attachment" 
                                        :type="this.errors.file_attachments ? 'is-danger':''"
                                        :message="this.errors.file_attachments ? this.errors.file_attachments[0] : ''"></b-field>

                                    <div class="mb-2" v-for="(file, index) in fields.file_attachments" :key="`file${index}`">
                                        <div class="columns">
                                            <div class="column">
                                                <b-field class="file is-primary" :class="{'has-name': !!file.event_file_path}">
                                                    <b-upload v-model="file.event_file_path" class="file-label">
                                                        <span class="file-cta">
                                                            <b-icon class="file-icon" icon="upload"></b-icon>
                                                            <span class="file-label">Click to upload</span>
                                                        </span>
                                                        <span class="file-name" v-if="file.event_file_path">
                                                            {{ file.event_file_path.name }}
                                                        </span>
                                                    </b-upload>
                                                </b-field>
                                            </div>
                                            <div class="column">
                                                <b-input type="input" v-model="file.event_filename" placeholder="File Name"></b-input>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="buttons mt-2">
                                        <b-button size="is-small" @click="addFile" label="New File"></b-button>
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
            event_content: null,

            approvingOfficers: [],

            fields: {
                event: null,
                event_description: null,
                event_content: null,
                dateAndTime: null,
                event_date_from: new Date(),
                event_date_to: new Date(),
                event_img: null,
                file_attachments: [],
                event_type_id: 0,
                is_need_approval: 0,

            },
            errors: {},

            eventTypes: [],
            venues: [],

            btnClass: {
                'button': true,
                'is-outlined' : true,
                'is-primary': true,
                'is-loading': false
            },

            minDate: new Date(new Date().setTime(new Date().getTime() - ((24*60*60*1000) * 1))),

            
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
            formData.append('event_content', this.fields.event_content ? this.fields.event_content : '');
            formData.append('event_date_from', this.fields.event_date_from ? this.$formatDate(this.fields.event_date_from) : '');
            formData.append('event_date_to', this.fields.event_date_to ? this.$formatDate(this.fields.event_date_to) : '');

            formData.append('event_img', this.fields.event_img ? this.fields.event_img : '');
            //formData.append('file', this.fields.file ? this.fields.file : '');
            //doc attachment
            if(this.fields.file_attachments){
                this.fields.file_attachments.forEach((doc, index) =>{
                    formData.append(`file_attachments[${index}][event_id]`, doc.event_id);
                    formData.append(`file_attachments[${index}][event_file_path]`, doc.event_file_path);
                    formData.append(`file_attachments[${index}][event_filename]`, doc.event_filename);
                });
            }

            formData.append('event_type_id', this.fields.event_type_id ? this.fields.event_type_id : '');
            formData.append('event_venue_id', this.fields.event_venue_id ? this.fields.event_venue_id : '');
            formData.append('event_time_from', from ? from : '');
            formData.append('event_time_to', to ? to : '');
            formData.append('is_need_approval', this.fields.is_need_approval ? this.fields.is_need_approval : '0');
            formData.append('ao_user_id', this.fields.ao_user_id ? this.fields.ao_user_id : '0');

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
            console.log(this.propData.event_content);

            this.fields.event =  this.propData.event
            this.event_content =  this.propData.event_content
            this.fields.event_date =  new Date(this.propData.event_date)
            this.fields.event_date_to =  new Date(this.propData.event_date_to)

            this.fields.image_path = this.propData.img_path
            this.fields.event_type_id = this.propData.event_type_id
            this.fields.event_time_from =  new Date('2022-01-01 ' + this.propData.event_time_from)
            this.fields.event_time_to =  new Date('2022-01-01 ' +this.propData.event_time_to)
            this.fields.event_venue_id =  this.propData.event_venue_id

            this.fields.file_attachments = this.propData.file_attachments
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
            this.fields.event_content = html
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
        },
        loadApprovingOfficers(){
            console.log('call approving');
            axios.get('/load-approving-officers/').then(res=> {
                this.approvingOfficers = res.data
            });
        },



        addFile(){
            this.fields.file_attachments.push({
                event_id: 0,
                event_filename: '',
                event_file_path: {}
            })
        }


    },

    mounted(){
        this.loadEventTypes()
        this.loadEventVenues()
        this.loadApprovingOfficers()

        if(this.propId > 0){
            this.getData()
        }
    },

    computed: {
        fromStartDate(){
            return this.fields.event_date
        }
    }

}
</script>
