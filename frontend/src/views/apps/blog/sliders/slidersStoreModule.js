
import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchSliders(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get("/api/blog/sliders", {
                      params: queryParams
                  })
                  .then(response => resolve(response))
                  .catch(error => reject(error));
          });
        },

        fetchSlider(ctx, id) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/blog/sliders/"+id.id)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
          },

        
        addSlider(ctx, sliderData){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/blog/sliders',  sliderData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        
        updateSlider(ctx, sliderData){
        
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/blog/sliders/${sliderData.id}`,  sliderData)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        }, 
        
        removeSlider(ctx, sliderId) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/blog/sliders/${sliderId}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        

    
    }
}
