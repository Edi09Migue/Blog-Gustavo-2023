import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        //Rutas Paises
        fetchPaises(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/paises", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        fetchPaisesOptions(ctx) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/paises/dropdownOptions")
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        //Rutas Provincias
        fetchProvincias(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/provincias", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        fetchProvincia(ctx, { id }) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/admin/provincias/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        fetchProvinciasOptions(ctx) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/provincias/dropdownOptions")
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        updateProvincia(ctx, provinciaData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(
                        `/api/admin/provincias/${provinciaData.value.id}`,
                        provinciaData.value
                    )
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        }
    },
    //Rutas Cantones
    fetchCantones(ctx, queryParams) {
        return new Promise((resolve, reject) => {
            axios
                .get("/api/admin/cantones", { params: queryParams })
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    fetchCanton(ctx, { id }) {
        return new Promise((resolve, reject) => {
            axios
                .get(`/api/admin/cantones/${id}`)
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    fetchCantonesOptions(ctx) {
        return new Promise((resolve, reject) => {
            axios
                .get("/api/admin/cantones/dropdownOptions")
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    updateCanton(ctx, cantonData) {
        return new Promise((resolve, reject) => {
            axios
                .put(
                    `/api/admin/cantones/${cantonData.value.id}`,
                    cantonData.value
                )
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    removeCanton(ctx, cantonId) {
        return new Promise((resolve, reject) => {
            axios
                .delete(`/api/admin/cantones/${cantonId}`)
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    //Rutas Parroquias
    fetchParroquias(ctx, queryParams) {
        return new Promise((resolve, reject) => {
            axios
                .get("/api/admin/parroquias", { params: queryParams })
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    fetchParroquia(ctx, { id }) {
        return new Promise((resolve, reject) => {
            axios
                .get(`/api/admin/parroquias/${id}`)
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    fetchParroquiasOptions(ctx) {
        return new Promise((resolve, reject) => {
            axios
                .get("/api/admin/parroquias/dropdownOptions")
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    updateParroquia(ctx, parroquiaData) {
        return new Promise((resolve, reject) => {
            axios
                .put(
                    `/api/admin/parroquias/${parroquiaData.value.id}`,
                    parroquiaData.value
                )
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    },
    removeParroquia(ctx, parroquiaId) {
        return new Promise((resolve, reject) => {
            axios
                .delete(`/api/admin/parroquias/${parroquiaId}`)
                .then(response => resolve(response))
                .catch(error => reject(error));
        });
    }
};
