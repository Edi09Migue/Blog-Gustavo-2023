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

export const http = axios.create({
    baseURL: `http://controlelectoral.local/api/`,
    headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
        'Content-Type': 'application/json',
    }
})

// export const httpFrmData = axios.create({
//     baseURL: `http://controlelectoral.local/api/`,
//     headers: {
//         Authorization: `Bearer ${localStorage.getItem('token')}`,
//         "Content-Type": "multipart/form-data"
//     }
// })