<template>
    <div class="section">
        
        <div class="columns is-centered">
            <div class="column is-6">
                <div class="box">
                    <div class="has-text-weight-bold my-4">Verify Your Email Address</div>

                    <div>
                        Before using the account, email must verified first.
                    </div>
                    <b-button
                        type="is-primary"
                        :class="btnClass"
                        @click="requestSubmit">Click here to verify email</b-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default{
    data(){
        return {

            btnClass: {
                'is-loading': false,
                'is-outlined': true
            }
        }
    },

    methods: {
        requestSubmit(){
            this.btnClass['is-loading'] = true
            axios.post('/email/resend').then(res=>{
            this.btnClass['is-loading'] = false
                
            }).catch(err=>{
                this.btnClass['is-loading'] = false
            
            })
        }
    },

    mounted(){

    }
}
</script>