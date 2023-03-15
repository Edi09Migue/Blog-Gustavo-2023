
import {ref,watch}  from '@vue/composition-api'
import { useInputImageRenderer } from "@core/comp-functions/forms/form-utils";
import store from "@/store";
import router from '@/router'


export default function usePaginaEdit(){

  const paginaData = ref(null)

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

  //Show
  store
    .dispatch("blog-paginas/fetchPagina", {
        // pasar un valor en un objeto
        id: router.currentRoute.params.id
    })
    .then(response => {
        paginaData.value = response.data.data;
        //se cargue la imagen desde el show para editar 
        paginaData.value.imagen = null;
        media.value = paginaData.value.imagenURL;

        paginaData.value.categorias = paginaData.value.categorias.map(
            p => p.id
        );
    })
    .catch(error => {
        console.log("error");
        console.log(error);
        if (error.response.status === 404) {
            paginaData.value = undefined;
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