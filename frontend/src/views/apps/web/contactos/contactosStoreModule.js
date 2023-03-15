import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchContactos(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/web/contactos", {
                        params: queryParams
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        updateContacto(ctx, contactoData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(
                        `/api/web/contactos/${contactoData.id}`,
                        contactoData
                    )
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
    },
};
