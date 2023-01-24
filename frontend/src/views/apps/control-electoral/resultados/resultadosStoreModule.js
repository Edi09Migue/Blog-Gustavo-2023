import axios from "@axios";


export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchTotalesPorCandidato(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/control-electoral/resultados/totales-por-candidato", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        fetchTotalesPorCandidatoParroquia(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/control-electoral/resultados/totales-por-candidato-parroquia", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        
        fetchTotalesPorTipoVoto(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/control-electoral/resultados/totales-por-tipo-voto", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        
        fetchTotalesEscrutados(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/control-electoral/resultados/totales-escrutados", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        fetchParroquiasOption(ctx, params){
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/admin/parroquias/dropdownOptions',{
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

        fetchEstadosOptions(ctx, params) {
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/control-electoral/actas/estadosOptions', {
                        params: params
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

    }
}
