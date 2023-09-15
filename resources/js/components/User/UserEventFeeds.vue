<template>
    <div>


        <div class="container">
            <div class="columns">
                <div class="column">
                    <div class="event-feed" v-for="(event, index) in eventFeeds" :key="index">

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>

export default {

    data(){
        return {
            eventFeeds: [],
        }
    },

    methods: {
        loadEventFeeds(){
            axios.get('/load-event-feeds').then(res=>{
                this.eventFeeds = res.data
            })
        }
    },

    mounted() {
        this.loadEventFeeds()
    }
}
</script>
