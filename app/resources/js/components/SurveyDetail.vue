<template>
    <div class="flex w-full h-full">
        <div class="w-full max-w-md m-auto">
            <button type="button" class="btn btn-primary btn-block m-2" v-on:click="saveSurvey()">Edit this survey</button>

            <div class="w-full ">
            
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'token',
        ],
        
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
