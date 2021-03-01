import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchConfigs(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/configs", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        }
    }
};
