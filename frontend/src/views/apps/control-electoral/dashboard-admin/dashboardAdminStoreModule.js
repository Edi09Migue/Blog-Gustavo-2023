import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchCounters(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/control-electoral/counters", {
                        params: queryParams
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

       
    }
};
