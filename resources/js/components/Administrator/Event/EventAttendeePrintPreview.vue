<template>
    <div>

        <div class="printarea">
            <div class="has-text-weight-bold has-text-centered">
                EVENT ATTENDANCE
            </div>
            <div class="has-text-centered">{{ propData.event }}</div>

            <div class="has-text-centered">{{ propData.venue.event_venue }}</div>

            <div class="report-table mt-4">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Attendee's Name</th>
                        <th>Date Request</th>
                        <th>Status</th>
                    </tr>
                    <tr v-for="(item, index) in propData.attendees"
                        :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.user.lname }}, {{ item.user.fname }} {{ item.user.mname }}</td>
                        <td>{{ new Date(item.date_request).toLocaleDateString() }}</td>
                        <td>
                            <span v-if="item.status === 1">APPROVED</span>
                            <span v-else>DISAPPROVED</span>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

</template>


<script>

export default{
    props: {
        propData: {
            type: Object,
            default: ()=>{}
        }
    },


    data(){
        return{

        }
    },


    mounted(){
        console.log(this.propData);
    }
}

</script>