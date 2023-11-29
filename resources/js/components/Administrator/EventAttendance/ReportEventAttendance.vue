<template>
    <div>

        <div class="filter-control">

            <div class="columns">
                <div class="column">
                    <b-field label="Date Range">
                        <b-datepicker v-model="search.from"></b-datepicker>
                        <b-datepicker v-model="search.to"></b-datepicker>
                        <p class="controls">
                            <b-button 
                                @click="loadData"
                                class="is-primary" icon-left="magnify"></b-button>
                            <b-button 
                                @click="printMe"
                                class="is-info" icon-left="printer"></b-button>
                        </p>
                    </b-field>
                </div>
            </div>
            
        </div>

        <div class="print-page">
            <div class="has-text-weight-bold has-text-centered is-size-5">LIST OF EVENTS</div>
            <table class="table is-fullwidth">
                <tr>
                    <th>No.</th>
                    <th>Event Type</th>
                    <th>Event</th>
                    <th>Event Date</th>
                </tr>

                <tr v-for="(item, index) in data" :key="index">
                    <td>{{ index+=1 }}</td>
                    <td>{{ item.event_type.event_type }}</td>
                    <td>{{ item.event }}</td>
                    <td>{{ new Date(item.event_datetime).toLocaleString() }}</td>
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
            }
        }
    },

    methods: {
        loadData(){
            const from = this.search.from.getFullYear() + '-' 
                + (this.search.from.getMonth() + 1).toString().padStart(2, "0") + '-' 
                + (this.search.from.getDate()).toString().padStart(2,'0')

            const to = this.search.to.getFullYear() + '-' 
                + (this.search.to.getMonth() + 1).toString().padStart(2, "0") + '-' 
                + (this.search.to.getDate()).toString().padStart(2,'0')

            const params = [
                `from=${from}`,
                `to=${to}`,
            ].join('&')

            axios.get(`/load-report-event-lists?${params}`).then(res=>{
                this.data = res.data
               
            })
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