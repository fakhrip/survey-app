<template>
    <div class="flex w-full h-full m-4">
        <div class="font-normal text-3xl text-gray-700 m-auto"
            :class="[{ 'hidden' : surveyList.length > 0 },
                    { 'visible' : surveyList.length < 1 }]">
            <span>You have no survey, add one by clicking <span class="font-bold">Create new survey</span> button above</span>
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
                surveyList: [],
            }
        },

        mounted() {
            
            const globe = this;

            globe
                .$axios.get('/api/getSurveyList', {
                    headers: {
                        'Authorization': `Bearer ${globe.token}`
                    }
                }).then(response => {

                    if(response.data.message === "success") {
                        globe.surveyList = response.data.surveyList;
                    } else {
                        globe.$toasted.global.showError({
                            message: response.data.message
                        });
                    }
                });
        }
    }
</script>
