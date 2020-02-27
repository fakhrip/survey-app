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

        data() {
            return {
            }
        },

        mounted() {
            
            const globe = this;

            globe.$axios.get('/api/getSurveyList', {
                    headers: {
                        'Authorization': `Bearer ${globe.token}`
                    }
                }).then(response => {
                if(response.data.message === "success") {
                    globe.ratingAsisten = response.data.ratingAsisten;
                    globe.gajiAsisten = response.data.gajiAsisten;
                } else {
                    globe.$toasted.global.showError({
                        message: response.data.message
                    });
                }
            });
        }
    }
</script>
