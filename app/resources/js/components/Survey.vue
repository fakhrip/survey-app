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
                        id="inline-full-name" type="text" placeholder="New Survey">
                </div>
            </div>
            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4 text-lg">
                        Description
                    </label>
                </div>
                <div class="w-2/3">
                    <textarea v-model="surveyForm.description" cols="30" rows="10"
                        class="font-overpass-mono-bold resize-none text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-4 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
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
                    <v-date-picker
                        mode="range"
                        :value="null"
                        color="red"
                        is-dark
                        is-inline
                        />
                </div>
            </div>
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
                        choices: [],
                        isRequired: false,
                    }
                ]
            };
        },
        
        mounted() {
            
        }
    }
</script>