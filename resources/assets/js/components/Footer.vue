<template>
    <div id='footer'>
        I am <kbd>zeus</kbd>.&nbsp;&nbsp;&nbsp;I am strong,very strong.
    </div>
</template>
<style>
    #footer {
       /* background-color:#ff0000;*/
       padding:0 3em;
       text-align:right;


    }
    #footer b{
        font-weight:800;
       font-size:15px;
    }
</style>
<script>

    export default{
        data(){
            return{
                //msg:'hello vue'
            }
        },
        components:{

        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
