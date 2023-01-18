<template>
    <div class="continer sm:mx-auto">
        <!-- nombre -->
        <div class="mb-2 flex bg-blanco w-full">
            <label for="nombre" class="py-2 w-[20%] pl-2 text-plomo">Nombre s: </label>
            <input class="w-[80%] bg-with pl-2 border-solid border-b-1 border-slate-500  py-2 outline-none" v-model="contactoData.nombre" type="text" name="nombre" required/>
        </div>
        <!-- teléfono -->
        <div class="mb-2 flex bg-blanco w-full">
            <label for="nombre" class="py-2 w-[20%] pl-2 text-plomo">Teléfono : </label>
            <input class="w-[80%] bg-with pl-2 border-solid border-b-1 border-slate-500 py-2  outline-none" v-model="contactoData.telefono" type="text" name="telefono" maxlength="10"/>
        </div>
        <!-- email -->
        <div class="mb-2 flex bg-blanco w-full">
            <label for="nombre" class="py-2 w-[35%] pl-2 text-plomo">Correo electrónico : </label>
            <input class="w-[65%] bg-with pl-2  border-solid border-b-1 border-slate-500 py-2  outline-none" v-model="contactoData.email" type="email" name="email" required/>
        </div>
        <!-- mensaje -->
        <div class="mb-2 flex bg-blanco w-full">
            <label for="nombre" class="py-2 w-[20%] pl-2 text-plomo">Mensaje : </label>
            <textarea class="w-[80%] bg-with pl-2  border-solid border-b-1 border-slate-500 py-2  outline-none" v-model="contactoData.mensaje" id="" rows="1" required/>
        </div>
        <!-- no soy un robot -->
        <div class="mt-3">
            <div id="capcha" class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6Ldm1k8eAAAAAJzlmuGXNZ7qgmflWFA_53LpOGyS"></div>
            <div>
                {{msgValidation}}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        contactoData: {
            type: Object,
            default() {
                return [];
            },
        },
        msgValidation: {
            type: String,
            default() {
                return '';
            },
        },
    },
}
</script>