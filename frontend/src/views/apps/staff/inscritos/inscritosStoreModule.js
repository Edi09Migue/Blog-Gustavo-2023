import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchInscritos(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/inscritos", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        validateUnique(ctx, value) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/admin/inscritos/validate/${value.field}`, {
                        value: value.value
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        addInscrito(ctx, inscritoData) {
            console.log('storeAdd');
            console.log(inscritoData);
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/admin/inscritos", inscritoData)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        updateInscrito(ctx, inscritoData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(
                        `/api/admin/inscritos/${inscritoData.id}`,
                        inscritoData
                    )
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        removeInscrito(ctx, inscritoId) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/admin/inscritos/${inscritoId}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        fetchCandidatosOptions(ctx) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/users/dropdownOptions")
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        fetchParroquiasOptions(ctx) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/parroquias/dropdownOptions?con_inscritos=true")
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        fetchCantonesOptions(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/cantones/dropdownOptions", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        generarReportes(ctx, reportFilters) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/admin/inscritos/reportes", reportFilters, {
                        responseType: 'blob',
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        }
    }
};
