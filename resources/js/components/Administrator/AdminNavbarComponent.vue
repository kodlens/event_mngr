<template>
    <div>

        

        


    </div>
</template>

<script>

export default{
    data(){
        return {

            open: true,
            expandWithDelay: false
           
        }
    },

    methods: {
        logout(){
            axios.post('/logout').then(res=>{
                window.location = '/'
            }).catch(err=>{
            
            })
        }
    },

    mounted(){

    }
}
</script>
