<template>
    <div class="w-full h-full flex">
        <form class="w-full max-w-md m-auto">
            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4 text-lg">
                        Title
                    </label>
                </div>
                <div class="w-2/3">
                    <input v-model="surveyForm.title" 
                        class="bg-gray-200 appearance-none text-xl border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                        type="text" placeholder="New Survey">
                </div>
            </div>

            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4 text-lg">
                        Description
                    </label>
                </div>
                <div class="w-2/3">
                    <textarea v-model="surveyForm.description" cols="30" rows="3"
                        class="resize-none text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                        type="text" placeholder="This is a customable survey"/>
                </div>
            </div>

            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4 text-lg">
                        Duration
                    </label>
                </div>
                <div class="w-2/3">
                    <vc-date-picker
                        v-model='surveyForm.duration' mode="range" :min-date='new Date()' color="red" is-dark/>
                </div>
            </div>

            <form v-for="(content, index) in contents" v-bind:key="index" 
                class="w-full flex-row h-auto mb-4">
                <div class="w-full flex-row rounded-sm bg-gray-400 m-2">

                    <div class="flex items-center p-2">
                        <div class="w-1/3">
                            <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4">
                                Type
                            </label>
                        </div>
                        <div class="w-2/3">
                            <select v-model="contents[index].type" 
                                class="block resize-y resize-none text-lg bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500">
                                <option value="" disabled selected class="text-gray-400">Choose answer type</option>
                                <option value="0">Text</option>
                                <option value="1">Date</option>
                                <option value="2">Radio Option (Single choice)</option>
                                <option value="3">Checkbox Option (Multiple choices)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center p-2">
                        <div class="w-1/3">
                            <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4">
                                Question
                            </label>
                        </div>
                        <div class="w-2/3">
                            <textarea v-model="contents[index].question" cols="30" rows="3"
                                class="resize-y resize-none text-lg bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                                type="text" placeholder="Here comes the question, right ?"/>
                        </div>
                    </div>

                    <div class="flex-row w-full"
                        :class="[{ 'visible': contents[index].type == '2' || 
                                            contents[index].type == '3' },
                                { 'hidden': contents[index].type != '2' && 
                                            contents[index].type != '3' }]">
                        <div class="w-full flex">
                            <div class="w-full h-1 bg-gray-700 my-auto mx-4"/>
                            <span class="w-auto ml-auto pr-4 font-bold text-xl text-gray-700">Options</span>
                        </div>
                        <div v-for="(option, optionIndex) in contents[index].choices" v-bind:key="optionIndex" 
                            class="w-full flex h-auto">
                            <div class="flex items-center p-2">
                                <div class="w-1/3">
                                    <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4">
                                        No. {{ optionIndex+1 }}
                                    </label>
                                </div>
                                <div class="w-2/3">
                                    <textarea v-model="contents[index].choices[optionIndex]" cols="30" rows="3"
                                        class="resize-y resize-none text-lg bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                                        type="text" placeholder="This is example answer"/>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary ml-2 mb-2" v-on:click="
                            contents[index].choices.push('This is example answer')
                        ">Add new option</button>
                    </div>
                </div>
            </form>

            <button type="button" class="btn btn-primary btn-block m-2" v-on:click="
                contents.push({
                    id: 0,
                    type: '',
                    question: '',
                    right_answer: '',
                    choices: [
                        'This is example answer',
                    ],
                    isRequired: false,
                })
            ">Add new content</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                surveyForm: {
                    title: '',
                    description: '',
                    content_ids: '',
                    duration: '',
                },

                contents: [
                    {
                        id: 0,
                        type: '',
                        question: '',
                        right_answer: '',
                        choices: [
                            'This is example answer',
                        ],
                        isRequired: false,
                    }
                ]
            };
        },
        
        mounted() {
            
        }
    }
</script>