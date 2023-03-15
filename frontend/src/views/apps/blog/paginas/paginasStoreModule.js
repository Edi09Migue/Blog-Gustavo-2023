
import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchPaginas(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get("/api/blog/paginas", {
                      params: queryParams
                  })
                  .then(response => resolve(response))
                  .catch(error => reject(error));
          });
        },

        fetchPagina(ctx, id) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/blog/paginas/"+id.id)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
          },

        
        addPagina(ctx, paginaData){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/blog/paginas',  paginaData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        
        updatePagina(ctx, paginaData){
        
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/blog/paginas/${paginaData.id}`,  paginaData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        }, 
        
        removePagina(ctx, paginaId) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/blog/paginas/${paginaId}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        
        fetchCategoriasOptions( ){
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/blog/categorias-blog/dropdownOptions')
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        }, 

        validateUnique(ctx, value) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/blog/paginas/validate/${value.field}`, {
                        value: value.value
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
  

       
    
    }
}
