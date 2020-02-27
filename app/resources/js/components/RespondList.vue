<template>
    <div class="flex w-full h-full m-4">
        <div class="w-auto h-auto flex">
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
