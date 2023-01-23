import axios from "@axios";


export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchActas(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/control-electoral/actas", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        fetchActa(ctx, { id }) {
            console.log(id);
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/control-electoral/actas/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        removeActa(ctx, vehiculoId) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/control-electoral/actas/${vehiculoId}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        restoreItem(ctx, itemId) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/control-electoral/actas/${itemId}/restore`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },


        addActa(ctx, vehiculoData){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/control-electoral/actas',  vehiculoData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        }, 

        updateActa(ctx, vehiculoData){

            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/control-electoral/actas/${vehiculoData.id}`,  vehiculoData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        }, 
        

        validateUnique(ctx, value) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/control-electoral/actas/validate/${value.field}`, {
                        value: value.value
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        fetchParroquiasOption(ctx, params){
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/admin/parroquias/parroquiasOptionsActas',{
                        params: params
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

        fetchRecintosOption(ctx, params){
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/control-electoral/recintos/dropdownOptions',{
                        params: params
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

        fetchJuntasOption(ctx, params){
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/control-electoral/juntas/dropdownOptions',{
                        params: params
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

        fetchEstadosOptions(ctx, params){
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/control-electoral/actas/estadosOptions',{
                        params: params
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },




    }
}
