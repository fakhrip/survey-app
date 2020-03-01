<template>
    <div class="flex w-full h-full">
        <div class="w-full max-w-md m-auto">
            <div class="w-full flex-row p-2">
                <div class="font-bold text-3xl text-black flex">
                    <span>
                        {{ currentSurvey.title }}
                    </span>
                </div>
                <div class="font-normal text-xl text-black flex mb-2">
                    <span>
                        {{ currentSurvey.description }}
                    </span>
                </div>
            </div>

            <div class="w-full rounded-full h-1 bg-yellow-400"/>

            <div class="w-auto flex-row m-auto p-2 pt-4"
                :class="[{ 'hidden' : !isFinished },
                        { 'visible' : isFinished }]">
                <span class="font-normal text-2xl text-black">
                    Thanks for responding to this survey
                </span>
            </div>

            <div class="w-auto flex-row m-auto p-2 pt-4"
                :class="[{ 'hidden' : !isExpired },
                        { 'visible' : isExpired }]">
                <span class="font-normal text-2xl text-black">
                    Sorry, whether the survey is not available yet or it has been ended
                </span>
            </div>

            <div class="w-full flex-row"
                :class="[{ 'visible' : !isFinished && !isExpired },
                        { 'hidden' : isFinished || isExpired }]">
                <div class="w-full flex-row">
                    <div v-for="(content, index) in contents" v-bind:key="index" 
                        class="w-full m-auto flex-row h-auto mb-4">
                        <div class="w-full flex-row rounded-t-md bg-gray-400 p-2 mt-4">
                            <div class="w-full flex">
                                <span class="font-normal text-xl text-black">
                                    {{ content.question }} {{ content.isRequired ? "(Required)" : "" }}
                                </span>
                            </div>
                        </div>

                        <div class="w-full flex rounded-b-sm bg-gray-500 p-2"
                            :class="[{ 'visible' : content.type == 0 },
                                    { 'hidden' : content.type != 0 }]">
                            <textarea v-model="answers[index].answer" cols="30" rows="3"
                                    class="resize-y resize-none text-lg bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                                    type="text" placeholder="Write your answer here"/>
                        </div>

                        <div class="w-full flex rounded-b-sm bg-gray-500 p-2"
                            :class="[{ 'visible' : content.type == 1 },
                                    { 'hidden' : content.type != 1 }]">
                            <vc-date-picker
                                v-model='answers[index].answer' 
                                color="red" is-dark
                                class="w-full flex"/>
                        </div>

                        <div class="w-full flex-row rounded-b-sm bg-gray-500 p-2"
                            :class="[{ 'visible' : content.type == 2 },
                                    { 'hidden' : content.type != 2 }]">
                            <div v-for="(choice, choiceIndex) in content.choices.split('|')" v-bind:key="choiceIndex">
                                <div class="w-full flex bg-gray-300 rounded-sm cursor-pointer p-2 mt-2 hover:bg-green-300"
                                    :class="[{ 'bg-green-500 text-white' : answers[index].answer == choice },
                                            { 'bg-gray-300 text-black' : answers[index].answer != choice }]"
                                    v-on:click="answers[index].answer = choice">
                                    <span class="text-lg font-normal">
                                        {{ choice }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full flex-row rounded-b-sm bg-gray-500 p-2"
                            :class="[{ 'visible' : content.type == 3 },
                                    { 'hidden' : content.type != 3 }]">
                            <div v-for="(choice, choiceIndex) in content.choices.split('|')" v-bind:key="choiceIndex">
                                <div class="w-full flex bg-gray-300 rounded-sm cursor-pointer p-2 mt-2 hover:bg-green-300"
                                    :class="[{ 'bg-green-500 text-white' : Array.isArray(answers[index].answer) ? answers[index].answer.includes(choice) : false },
                                            { 'bg-gray-300 text-black' : Array.isArray(answers[index].answer) ? !answers[index].answer.includes(choice) : true }]"
                                    v-on:click="pushChoice(choice, index)">
                                    <span class="text-lg font-normal">
                                        {{ choice }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary mt-4 btn-block"
                    v-on:click="finishSurvey()">
                    <span class="text-sm">Finish this survey</span>
                </button>
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
                currentSurvey: {}, 
                contents: [],  
                answers: [], 
                
                userRespond: {
                    answer_ids: '',
                    survey_id: '',
                },
                isFinished: false,
                isExpired: false,
            }
        },

        methods: {

            pushChoice: function($choice, $index) {

                const globe = this

                if(!Array.isArray(globe.answers[$index].answer)) {
                    globe.answers[$index].answer = [];

                    if(!globe.answers[$index].answer.includes($choice))
                        globe.answers[$index].answer.push($choice)
                    else 
                        globe.answers[$index].answer.splice(globe.answers[$index].answer.indexOf($choice), 1);
                } else {

                    if(!globe.answers[$index].answer.includes($choice))
                        globe.answers[$index].answer.push($choice)
                    else 
                        globe.answers[$index].answer.splice(globe.answers[$index].answer.indexOf($choice), 1);
                } 
            },

            finishSurvey: function() {

                const globe = this;

                for (let index = 0; index < globe.contents.length; index++) {
                    const content = globe.contents[index];
                    const answer = globe.answers[index];
                    
                    if(content.isRequired && answer.answer == "") {

                        globe.$toasted.global.showError({
                            message: "Answer all required questions"
                        });
                        return;
                    }
                }

                globe
                    .$axios.post('/api/addAnswers', globe.answers, {
                        headers: {
                            'Authorization': `Bearer ${globe.token}`
                        }
                    }).then(response => {

                        if(response.data.message === "success") {

                            globe.userRespond.answer_ids = response.data.answer_ids;
                            globe.userRespond.survey_id = globe.currentSurvey.id;
                            globe
                                .$axios.post('/api/addRespond', globe.userRespond, {
                                    headers: {
                                        'Authorization': `Bearer ${globe.token}`
                                    }
                                }).then(response => {

                                    if(response.data.message === "success") {

                                        globe.isFinished = true;
                                        globe.userRespond = response.data.respond;

                                    } else {
                                        globe.$toasted.global.showError({
                                            message: response.data.message
                                        });
                                    }
                                });

                        } else {
                            globe.$toasted.global.showError({
                                message: response.data.message
                            });
                        }
                    });
            }
        },
        
        mounted() {
            
            const globe = this;

            globe
                .$axios.get('/api/checkExistence/'+(window.location.href.substring(window.location.href.lastIndexOf('/') + 1)), {
                    headers: {
                        'Authorization': `Bearer ${globe.token}`
                    }
                }).then(response => {

                    if(response.data.message === "success") {

                        globe.isFinished = response.data.isFinished;

                        if(!globe.isFinished) {

                            globe
                                .$axios.get('/api/checkDate/'+(window.location.href.substring(window.location.href.lastIndexOf('/') + 1)), {
                                    headers: {
                                        'Authorization': `Bearer ${globe.token}`
                                    }
                                }).then(response => {

                                    if(response.data.message === "success") {
                                        
                                        globe.isExpired = response.data.isExpired; 

                                        if(!globe.isExpired) {

                                            globe
                                                .$axios.get('/api/getSurvey/'+(window.location.href.substring(window.location.href.lastIndexOf('/') + 1)), {
                                                    headers: {
                                                        'Authorization': `Bearer ${globe.token}`
                                                    } 
                                                }).then(response => {
                                
                                                    if(response.data.message === "success") {

                                                        globe.currentSurvey = response.data.survey;
                                                        
                                                        var length = globe.currentSurvey.content_ids.split('-').length;
                                                        for (let i = 0; i<length; i++) {

                                                            const element = globe.currentSurvey.content_ids.split('-')[i];
                                                            
                                                            globe
                                                                .$axios.get('/api/getContent/'+element, {
                                                                    headers: {
                                                                        'Authorization': `Bearer ${globe.token}`
                                                                    }
                                                                }).then(response => {

                                                                    if(response.data.message === "success") {

                                                                        globe.contents.push(response.data.content)

                                                                        globe.answers.push({
                                                                            answer: '',
                                                                            content_id: response.data.content.id,
                                                                        })

                                                                    } else {
                                                                        globe.$toasted.global.showError({
                                                                            message: response.data.message
                                                                        });
                                                                    }
                                                                });
                                                        }

                                                    } else {
                                                        globe.$toasted.global.showError({
                                                            message: response.data.message
                                                        });
                                                    }
                                                });
                                        }

                                    } else {
                                        globe.$toasted.global.showError({
                                            message: response.data.message
                                        });
                                    }
                                });

                        } else {

                            globe.userRespond = response.data.respond;
                            
                            globe
                                .$axios.get('/api/getSurvey/'+(window.location.href.substring(window.location.href.lastIndexOf('/') + 1)), {
                                    headers: {
                                        'Authorization': `Bearer ${globe.token}`
                                    } 
                                }).then(response => {
                
                                    if(response.data.message === "success") {

                                        globe.currentSurvey = response.data.survey;

                                    } else {
                                        globe.$toasted.global.showError({
                                            message: response.data.message
                                        });
                                    }
                                });
                        }

                    } else {
                        globe.$toasted.global.showError({
                            message: response.data.message
                        });
                    }
                });
        }
    }
</script>
