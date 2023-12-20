<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-12">
                    <div class="box">
                        
                        <b-tabs v-model="activeTab">
                            <b-tab-item label="Events">
                                <event-main-list :prop-user="propUser"></event-main-list>
                            </b-tab-item>

                            <b-tab-item label="Archive Events" v-if="['ADMINISTRATOR'].includes(propUser.role)">
                                <event-archive-list :prop-user="propUser" ></event-archive-list>
                            </b-tab-item>

                            <!--  :prop-user="propUser" -->
                        </b-tabs>

                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->
    </div>
</template>

<script>

export default{


    props: {
        propUser:{
            type: Object,
            default: function () {
                return {
                    // default properties for the object
                };
            }
        },
    },


    data() {
        return{
            activeTab: 0,

        }

    },

    methods: {
       
    },

    mounted() {
    }


}


</script>


<style scoped>


</style>
