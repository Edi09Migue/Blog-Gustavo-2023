import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {

    fetchCategorias (ctx, queryParams) {
      return new Promise((resolve, reject) => {
          
          axios
              .get("/api/blog/categorias-blog", { params: queryParams })
              
              .then(response => resolve(response))
              .catch(error => reject(error));
      });
    },

    addCategoria(ctx, categoriaData){
      return new Promise((resolve, reject) => {
          axios
              .post('/api/blog/categorias-blog',  categoriaData)
              .then(response => resolve(response))
              .catch(error => reject(error))
      })
    },
    
    updateCategoria(ctx, categoriaData){
    
      return new Promise((resolve, reject) => {
          axios
              .put(`/api/blog/categorias-blog/${categoriaData.id}`,  categoriaData)
              .then(response => resolve(response))
              .catch(error => reject(error))
      })
    },

    removeCategoria(ctx, categoriaId) {
      return new Promise((resolve, reject) => {
          axios
              .delete(`/api/blog/categorias-blog/${categoriaId}`)
              .then(response => resolve(response))
              .catch(error => reject(error));
      });
    },

  }
};
