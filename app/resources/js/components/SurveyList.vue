<template>
    <div class="flex w-full h-full m-4">
        <div class="font-normal text-3xl text-gray-700 m-auto"
            :class="[{ 'hidden' : surveyList.length > 0 },
                    { 'visible' : surveyList.length < 1 }]">
            <span>You have no survey, add one by clicking <span class="font-bold">Create new survey</span> button above</span>
        </div>

        <div class="flex w-full h-full"
            :class="[{ 'visible' : surveyList.length > 0 },
                    { 'hidden' : surveyList.length < 1 }]">
            <div v-for="(survey, index) in surveyList" v-bind:key="index" 
                class="w-full max-w-md m-auto flex-row h-auto mb-4">
                <div class="w-full rounded-sm bg-yellow-400 flex p-2">
                    <div class="w-1/2 flex-row">
                        <div class="font-bold text-2xl text-black flex">
                            <span>
                                {{ survey.title }}
                            </span>
                        </div>
                        <div class="font-normal text-xl text-black flex mb-2">
                            <span>
                                {{ survey.description }}
                            </span>
                        </div>
                        <div class="font-normal text-sm text-black flex">
                            <span>
                                From = {{ $moment(survey.duration.split("|")[0]).format('LL')  }}
                            </span>
                        </div>
                        <div class="font-normal text-sm text-black flex">
                            <span>
                                To = {{ $moment(survey.duration.split("|")[1]).format('LL') }}
                            </span>
                        </div>
                    </div>
                    <div class="w-1/2 flex-row">
                        <button type="button" class="btn btn-primary btn-block">View</button>
                        <button type="button" class="btn btn-danger btn-block">Delete</button>
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
