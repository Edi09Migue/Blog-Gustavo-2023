import {ref}  from '@vue/composition-api'
import { useInputImageRenderer } from "@core/comp-functions/forms/form-utils";
import store from "@/store";

export default function usePaginaCreate(){

  const modeloPagina = {
    titulo:"",
    slug:"",
    contenido: "",
    fecha: new Date(),
    user_id: "",
    estado: "",
    categorias: [],
    
    imagen: null,
  };

  const paginaData = ref(JSON.parse(JSON.stringify(modeloPagina)))

  const categoriasOptions = ref([]);
  store
    .dispatch("blog-paginas/fetchCategoriasOptions", {
  })
  .then(response => {
    categoriasOptions.value = response.data; 
  })
  .catch(() => {
    toast({
        component: ToastificationContent,
        props: {
            title: "Error obteniendo categorías",
            icon: "AlertTriangleIcon",
            variant: "danger"
        }
    });
  });
    // Imagen 1
    const media = ref(null);
    const refInputEl = ref(null);
    const previewEl = ref(null);

    paginaData.value.imagen = null;

    const { inputImageRenderer } = useInputImageRenderer(
    refInputEl,
    base64 => {
        media.value = base64;
        paginaData.value.imagen = base64;
    }
  );



  return {
    paginaData,
    categoriasOptions,

    media,
    refInputEl,
    previewEl,
    inputImageRenderer,
  }
}