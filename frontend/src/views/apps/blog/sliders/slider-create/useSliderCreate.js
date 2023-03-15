import {ref}  from '@vue/composition-api'
import { useInputImageRenderer } from "@core/comp-functions/forms/form-utils";
import store from "@/store";

export default function useSliderCreate(){

  const modeloSlider = {
    title:"",
    title_2:"",
    subtitle:"",
    descripcion:"",
    url:"",
    texto_boton:"",
    externo: false,
    orden: 0,
    visible: true,

    imagen: null,
  };

  const sliderData = ref(JSON.parse(JSON.stringify(modeloSlider)))

    // Imagen 1
    const media = ref(null);
    const refInputEl = ref(null);
    const previewEl = ref(null);

    sliderData.value.imagen = null;

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