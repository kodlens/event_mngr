<template>
    <div>

        <div class="filter-control">

            <div class="columns">
                <div class="column">
                    <b-field label="Select Event">
                        <modal-browse-events @browseEvents="emitBrowseEvent"
                            :prop-name="event.event"></modal-browse-events>
 
                        <b-button 
                            @click="printMe"
                            class="is-info" icon-left="printer"></b-button>
                    </b-field>
                </div>
            </div>
            
        </div>

        <div class="print-page">
            <div class="has-text-weight-bold has-text-centered is-size-5">ATTENDANCES</div>
            <div class="has-text-weight-bold has-text-centered is-size-5">{{ event.event}}</div>

            <table class="table is-fullwidth is-narrow">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Sex</th>
                    <th>IN/OUT AM</th>
                    <th>IN/OUT PM</th>
                </tr>

                <tr v-for="(item, index) in data.event_attendances" :key="index">
                    <td>{{ index+=1 }}</td>
                    <td>{{ item.user.lname }}, {{ item.user.fname }} {{ item.user.mname }}</td>
                    <td>{{ item.user.sex }}</td>
                    <td>
                        <b>IN: </b> <span v-if="item.in_am">
                            {{ new Date(item.in_am).toLocaleString() }}
                        </span>
                        <br>
                        <b>OUT: </b><span v-if="item.out_am">
                            {{ new Date(item.out_am).toLocaleString() }}
                        </span>
                    </td>
                    <td>
                        <b>IN: </b><span v-if="item.in_pm">
                            {{ new Date(item.in_pm).toLocaleString() }}
                        </span>
                        <br>
                        <b>OUT: </b><span v-if="item.out_pm">
                            {{ new Date(item.out_pm).toLocaleString() }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>

export default{
    data(){
        return {
            data: [],

            search: {
                from: new Date(),
                to: new Date()
            },

            event: {
                event: '',
                event_id: null
            }
        }
    },

    methods: {
        loadData(){
            // const from = this.search.from.getFullYear() + '-' 
            //     + (this.search.from.getMonth() + 1).toString().padStart(2, "0") + '-' 
            //     + (this.search.from.getDate()).toString().padStart(2,'0')

            // const to = this.search.to.getFullYear() + '-' 
            //     + (this.search.to.getMonth() + 1).toString().padStart(2, "0") + '-' 
            //     + (this.search.to.getDate()).toString().padStart(2,'0')

            const params = [
                `event=${this.event.event_id}`,
              
            ].join('&')

            axios.get(`/load-report-event-attendances?${params}`).then(res=>{
                this.data = res.data
               
            })
        },


        emitBrowseEvent(row){
            this.event.event = row.event
            this.event.event_id = row.event_id
            this.loadData()
        },

        printMe(){
            window.print()
        }
    },

    mounted(){
    }
}
</script>

<style scoped>


.print-page{
    width: 816px;
    background-color: white;
}


</style>