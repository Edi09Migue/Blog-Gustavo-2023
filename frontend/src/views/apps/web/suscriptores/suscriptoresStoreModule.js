import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {

    fetchSuscriptores (ctx, queryParams) {
      return new Promise((resolve, reject) => {
          
          axios
              .get("/api/web/suscriptores", {
                params: queryParams
              })
              .then(response => resolve(response))
              .catch(error => reject(error));
      });
    },

    addSuscriptor(ctx, suscriptorData){
      return new Promise((resolve, reject) => {
          axios
              .post('/api/web/suscriptores',  suscriptorData)
              .then(response => resolve(response))
              .catch(error => reject(error))
      })
    },
    
    removeSuscriptor(ctx, suscriptorId) {
      return new Promise((resolve, reject) => {
          axios
              .delete(`/api/web/suscriptores/${suscriptorId}`)
              .then(response => resolve(response))
              .catch(error => reject(error));
      });
    },

  }
};
