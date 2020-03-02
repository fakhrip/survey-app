<template>
    <div class="flex w-full h-full">
        <div class="w-1/2 h-full flex">
            <div class="w-full max-w-md m-auto">
                <button type="button" class="btn btn-primary btn-block m-2">Edit this survey</button>

                <div class="w-full flex-row m-2">
                    <div class="w-full flex rounded-sm bg-gray-200">
                        <div class="w-2/3 flex p-2">
                            <span class="font-bold text-2xl m-auto">
                                https://{{ domain }}/survey/{{ currentSurvey.slug }}
                            </span>
                        </div>
                        <div class="w-1/3 flex">
                            <qrcode :value="'https://'+domain+'/survey/'+currentSurvey.slug" class="w-full"
                                :options="{ 
                                    color: {
                                        light: '#edf2f7'
                                    }
                                }"></qrcode>
                        </div>
                    </div>

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
                </div>
            </div>
        </div>
        <div class="w-1/2 h-full flex">
            <div class="w-full max-w-md m-auto">
                <div class="w-full rounded-full h-1 bg-gray-600"/>

                <div class="w-full flex p-2">
                    <span class="font-normal text-xl italic m-auto">
                        There are {{ respondList.length }} responds
                    </span>
                </div>

                <div class="w-full rounded-full h-1 bg-gray-600"/>

                <div class="w-full flex-row mt-4">
                    <div v-for="(respond, index) in respondList" v-bind:key="index" 
                        class="w-full max-w-md m-auto flex-row h-auto pb-4">
                        <div class="w-full rounded-sm bg-yellow-400 flex p-2">
                            <div class="w-1/2 flex-row">
                                <div class="font-bold text-2xl text-black flex">
                                    <span>
                                        {{ respond.name }}
                                    </span>
                                </div>
                                <div class="font-normal text-xl text-black flex mb-2">
                                    <span>
                                        {{ respond.email }}
                                    </span>
                                </div>
                                <div class="font-normal text-lg text-black flex mb-2">
                                    <span>
                                        {{ respond.ip_address }}
                                    </span>
                                </div>
                                <div class="font-normal text-sm text-black flex">
                                    <span>
                                        Responded at {{ $moment(respond.created_at).format('LL')  }}
                                    </span>
                                </div>
                            </div>
                            <div class="w-1/2 flex-row">
                                <button type="button" class="btn btn-secondary btn-block mt-2">Download Response</button>
                            </div>
                        </div>
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
                currentSurvey: {}, 
                contents: [],  
                answers: [], 
                respondList: [],

                domain: window.location.hostname,
            }
        },

        methods: {

            pushChoice: function($choice, $index) {

                const globe = this;

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
        },
        
        mounted() {

            const globe = this;

            globe
                .$axios.get('/api/getRespondList/'+(window.location.href.substring(window.location.href.lastIndexOf('/') + 1)), {
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

            globe
                .$axios.get('/api/getSurvey/'+(window.location.href.substring(window.location.href.lastIndexOf('/') + 1)), {
                    headers: {
                        'Authorization': `Bearer ${globe.token}`
                    } 
                }).then(response => {

                    if(response.data.message === "success") {
                        
                        globe.isExpired = response.data.isExpired; 

                        if(!globe.isExpired) {

                            globe.currentSurvey = response.data.survey;
                            globe.contents = response.data.contents;
                            
                            for (let i = 0; i<globe.contents.length; i++) {

                                globe.answers.push({
                                    answer: '',
                                    content_id: globe.contents[i].id,
                                })
                            }
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
