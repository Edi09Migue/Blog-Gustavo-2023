import axios from "@axios";


export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchRecintos(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/control-electoral/recintos", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        fetchRecinto(ctx, { id }) {
            console.log(id);
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/control-electoral/recintos/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        removeRecinto(ctx, vehiculoId) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/control-electoral/recintos/${vehiculoId}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        restoreItem(ctx, itemId) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/control-electoral/recintos/${itemId}/restore`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },


        addRecinto(ctx, vehiculoData){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/control-electoral/recintos',  vehiculoData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        }, 

        updateRecinto(ctx, vehiculoData){

            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/control-electoral/recintos/${vehiculoData.id}`,  vehiculoData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        }, 
        

        validateUnique(ctx, value) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/control-electoral/recintos/validate/${value.field}`, {
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




    }
}
