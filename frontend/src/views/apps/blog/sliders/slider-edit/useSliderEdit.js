
import {ref,watch}  from '@vue/composition-api'
import { useInputImageRenderer } from "@core/comp-functions/forms/form-utils";
import store from "@/store";
import router from '@/router'


export default function useSliderEdit(){

  const sliderData = ref(null)

  //Show
  store
    .dispatch("blog-sliders/fetchSlider", {
        // pasar un valor en un objeto
        id: router.currentRoute.params.id
    })
    .then(response => {
        sliderData.value = response.data.data;
        //se cargue la imagen desde el show para editar 
        sliderData.value.imagen = null;
        media.value = sliderData.value.imagenURL; 
    })
    .catch(error => {
        console.log("error");
        console.log(error);
        if (error.response.status === 404) {
            sliderData.value = undefined;
        }
    });

    // Imagen 1
    const media = ref(null);
    const refInputEl = ref(null);
    const previewEl = ref(null);
    const { inputImageRenderer } = useInputImageRenderer(
    refInputEl,
    base64 => {
        media.value = base64;
        sliderData.value.imagen = base64;
    }
  );

  return {
    sliderData,
    media,
    refInputEl,
    previewEl,
    inputImageRenderer,

  }


}