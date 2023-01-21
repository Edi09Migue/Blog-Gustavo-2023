import Vue from "vue";
import axios from "axios"

// window.axios =  axios
// axios.defaults.withCredentials = true
// axios.defaults.baseURL = 'http://controlelectoral.local/api/'
// axios.interceptors.request.use(function(config){
//     config.headers.common = {
//         Autorization:`Bearer ${localStorage.getItem('token')}`,
//         "Content-Type": "application/json",
//         Accept: "applicaction/json"
//     }
//     return config;
// })

 const http = axios.create({
    baseURL: `http://controlelectoral.local/api/`,
    headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
        'Content-Type': 'application/json',
    }
})

Vue.prototype.$http = http;

export default http;
// export const httpFrmData = axios.create({
//     baseURL: `http://controlelectoral.local/api/`,
//     headers: {
//         Authorization: `Bearer ${localStorage.getItem('token')}`,
//         "Content-Type": "multipart/form-data"
//     }
// })