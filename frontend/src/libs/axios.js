import Vue from "vue";

// axios
import axios from "axios";

const axiosIns = axios.create({
    // You can add your headers here
    // ================================
    //baseURL: "http://tungurahua63.local/"
    baseURL: "https://api.todo63.com/"
    // timeout: 1000,
    // headers: {'X-Custom-Header': 'foobar'}
});

Vue.prototype.$http = axiosIns;

export default axiosIns;
