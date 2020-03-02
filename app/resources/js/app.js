import Toasted from 'vue-toasted';
import VCalendar from 'v-calendar';
import Moment from 'moment';
import Axios from 'axios';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import JsonExcel from 'vue-json-excel';

require('./bootstrap');
window.Vue = require('vue');

Vue.use(Toasted);
Vue.prototype.$moment = Moment;
Vue.prototype.$axios = Axios;

Vue.toasted.register('showError',
    (payload) => {
        if(! payload.message) {
    	    return "Sorry error happened, please try again"
        }
        return payload.message;
    },
    {
      type: "error", 
      position: "bottom-center",
      duration : 2000
    }
)

Vue.toasted.register('showSuccess',
    (payload) => {
        if(! payload.message) {
    	    return "Request successfully processed"
        }
        return payload.message;
    },
    {
      type: "success",
      position: "bottom-center",
      duration : 2000
    }
)

Vue.use(VCalendar, {
    componentPrefix: 'vc',  // Use <vc-calendar /> instead of <v-calendar />
});

Vue.component(VueQrcode.name, VueQrcode);
Vue.component('downloadExcel', JsonExcel)

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const app = new Vue({
    el: '#app',
});
