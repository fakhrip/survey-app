<template>
    <div class="flex w-full h-full m-4">
        <div class="font-normal text-3xl text-gray-700 m-auto"
            :class="[{ 'hidden' : respondList.length > 0 },
                    { 'visible' : respondList.length < 1 }]">
            <span>You haven't responded to any survey</span>
        </div>

        <div class="flex-row w-full h-full"
            :class="[{ 'visible' : respondList.length > 0 },
                    { 'hidden' : respondList.length < 1 }]">
            <div v-for="(respond, index) in respondList" v-bind:key="index" 
                class="w-full max-w-md m-auto flex-row h-auto pb-4">
                <div class="w-full rounded-sm bg-yellow-400 flex-row p-2">
                    <div class="font-bold text-2xl text-black flex">
                        <span>
                            {{ respond.title }}
                        </span>
                    </div>
                    <div class="font-normal text-xl text-black flex mb-2">
                        <span>
                            {{ respond.description }}
                        </span>
                    </div>
                    <div class="font-normal text-sm text-black flex">
                        <span>
                            Responded at {{ $moment(respond.created_at).format('LL')  }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'token',
        ],

        data() {
            return {
                respondList: [],
            }
        },
        
        mounted() {
            
            const globe = this;

            globe
                .$axios.get('/api/getRespondList', {
                    headers: {
                        'Authorization': `Bearer ${globe.token}`
                    }
                }).then(response => {

                    if(response.data.message === "success") {
                        globe.respondList = response.data.respondList;
                    } else {
                        globe.$toasted.global.showError({
                            message: response.data.message
                        });
                    }
                });
        }
    }
</script>
