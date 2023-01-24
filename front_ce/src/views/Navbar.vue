<template>
<header v-if="userData">
    <nav class="top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 navbar-expand-lg bg-negro">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start ">
                <a class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-white" href="#">
                    Control Electoral Ec
                </a>
            </div>
            <div class="lg:flex flex-grow items-center bg-white lg:bg-opacity-0 lg:shadow-none hidden bg-negro" id="example-collapse-navbar">
                <!-- Left items -->
                <ul class="flex flex-col lg:flex-row list-none mr-auto">
                    <li class="flex items-center">
                        <a class="" href="#"> </a>
                    </li>
                </ul>
                <!-- Right item -->
                <ul class="flex flex-col lg:flex-row list-none lg:ml-auto items-center">
                    <!-- Pages 
                    <li class="inline-block relative">
                        <a class="lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold" href="#pablo" onclick="openDropdown(event,'demo-pages-dropdown')">
                            Demo Pages
                        </a>
                    </li>
                    <li class="flex items-center">
                        <router-link to="/home" class="lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
                            home
                        </router-link>
                    </li>-->
                    <!-- User options -->
                    <li class="flex items-center">
                        <a class="lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold" href="#">
                            <font-awesome-icon icon="fa-solid fa-circle-user fa-6x" class="text-xl" />
                            <span class="pl-2">
                                {{ userData ? userData.name : 'Nombre del usuario' }}
                            </span>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <a class="bg-white text-blueGray-700 active:bg-blueGray-50 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3 ease-linear transition-all duration-150" href="https://www.creative-tim.com/product/notus-js?ref=njs-index" target="_blank">
                            <i class="fas fa-arrow-alt-circle-down"></i>
                            Cerrar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
</template>
<script>
export default {
    components: {
        
    },
    computed: {
        userData(){
            console.log('this.$store.getters.getUser',this.$store.getters.getUser);
            return this.$store.getters.getUser;
        },
    }
}
</script>
