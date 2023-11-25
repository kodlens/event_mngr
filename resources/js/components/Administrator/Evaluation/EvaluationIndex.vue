<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="box">

                        <div class="columns">
                            <div class="column">

                                <div class="is-flex is-justify-content-center mb-2"
                                    style="font-size: 20px; font-weight: bold;">EVALUATION</div>
                                <hr>
                                
                                
                                <b-field label="Select Event">
                                   <modal-browse-events
                                        :prop-name="search.event"
                                        @browseEvents="emitBrowseEvent"></modal-browse-events>
                                </b-field>
                            </div>
                        </div> <!--cols-->

                        <div class="columns">
                            <div class="column">

                                <div class="buttons is-right">
                                    <b-button class="is-small is-primary" label="GENERATE"
                                        icon-left="magnify" @click="loadReportEventEvaluations"></b-button>
                                </div>
                                
                            </div>
                        </div> <!--cols-->
                       
                

                        <div class="columns">
                            <div class="column">
                                <table class="table">
                                    <tr>
                                       
                                        <th>Question</th>
                                        <th>Rating</th>

                                    </tr>

                                    <tr v-for="(item, ix) in report" :key="ix">
                                        <td>{{  item.question }}</td>
                                        <td>{{  item.rating }}</td>
                                    </tr>
                                </table>
                            </div> <!--col--> 
                        </div> <!--cols-->

                    </div>
                </div>
            </div>
        </div> <!--section-->
        
    </div>
</template>

<script>

export default{
    data(){
        return {

            data: [],
           


            academicYears: [],
            report: [],

            search: {
                event_id: null,
                ayid: '',
                event: ''
            }
        }
    },

    methods: {

        loadReportEventEvaluations(){
            const params = [
                `ayid=${this.search.ayid}`,
                `eventid=${this.search.event_id}`
            ].join('&')
            axios.get(`/get-report-event-evaluations?${params}`).then(res=>{
                this.report = res.data
            })
        },

        emitBrowseEvent(row){
            this.search.event_id = row.event_id
            this.search.event = row.event
            this.search.ayid = row.academic_year_id
        }
    },

    mounted(){
    }
}
</script>