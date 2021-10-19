import Vue from "vue";

// axios
import axios from "axios";

const axiosIns = axios.create({
    // You can add your headers here
    // ================================
    baseURL: "http://produccion.local/"
    // timeout: 1000,
    // headers: {'X-Custom-Header': 'foobar'}
});

Vue.prototype.$http = axiosIns;

export default axiosIns;
