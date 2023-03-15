import {ref,computed,watch}  from '@vue/composition-api'
import { useUtils as useI18nUtils } from "@core/libs/i18n";
import store from "@/store";
// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import router from '@/router'

export default function useContactosList(){
	const { t } = useI18nUtils();
	const perPage = ref(5);
	const perPageOptions = [5, 10, 15, 20];
	const searchQuery = ref("");
	const sortBy = ref("id");
	const refContactosListTable = ref(null);
	const totalContactos = ref(0);
	const currentPage = ref(1);
	const isSortDirDesc = ref(true);
	const toast = useToast();
	const isContactoFormActive = ref(false);
	const errorServer = ref(null);

	const blankContactoData = {
		nombre:'',
		telefono:'',
		email:'',
		mensaje:'',
		estado:false,
	};

  	const contactoData = ref(JSON.parse(JSON.stringify(blankContactoData)));

	const dataMeta = computed(() => {
		const localItemsCount = refContactosListTable.value
			?  refContactosListTable.value.localItems.length
			: 0;
		return {
			from:
			perPage.value * (currentPage.value - 1) +
			(localItemsCount ? 1 : 0),
			to: perPage.value * (currentPage.value - 1) + localItemsCount,
			of: totalContactos.value
		};
	});

  	// Table Handlers
  	const tableColumns = [
		{ key: "nombre", sortable: false, label: t("Name") },
		{ key: "telefono", sortable: true, label: t("Phone") },
		{ key: "email", sortable: true, label: t("Email") },
		{ key: "mensaje", sortable: true, label: t("Message"), },
		{ key: "estado", sortable: true, label: "Atendido", },
		{ key: "actions", label: t("Actions") }
  	];

	const refetchData = () => {
		refContactosListTable.value.refresh()
	}

	watch([currentPage, perPage, searchQuery], () => {
		refetchData()
	})

  	const fetchContactos = (ctx, callback) => {
    	store
			.dispatch("web-contactos/fetchContactos", {
				q: searchQuery.value,
				perPage: perPage.value,
				page: currentPage.value,
				sortBy: sortBy.value,
				sortDesc: isSortDirDesc.value,
				id: router.currentRoute.query.id,
			})
			.then(response => {
				const { items, total } = response.data;
				callback(items);
				totalContactos.value = total;
			})
			.catch((error) => {
				toast({
					component: ToastificationContent,
					props: {
						title:
						"Error obteniendo contactos",
						icon: "AlertTriangleIcon",
						variant: "danger"
					}
				});
    		});
  	};

	const handleEditClick = data => {
		errorServer.value = null;
		contactoData.value = data;
		isContactoFormActive.value = true;
	};

  	const editContacto = (contactoData) => {
     	store.dispatch('web-contactos/updateContacto',contactoData)
     	.then(response=>{
         if(response.data.status){
            refetchData()
            isContactoFormActive.value = false;
             toast({
                 component: ToastificationContent,
                 props: {
                 title: "¡Editado correctamente!",
                     text: response.data.msg,
                     icon: "CheckIcon",
                     variant: "success"
                 }
             });
         }else{
          	errorServer.value = response.data.msg
         }
		}).catch(error=>{
			console.log('error: ', error)
		})
  	}
	
	// update estato
	const selected = ref(null);

	watch([selected], () => {
		updateStatus(selected)
	})

	const updateStatus = (item) => {
		store.dispatch('web-contactos/updateContacto',{
			id:item.value.id,
			nombre:item.value.nombre,
			telefono:item.value.telefono,
			email:item.value.email,
			mensaje:item.value.mensaje,
			estado:item.value.estado ? false : true,
			updateEstado:true
		})
     	.then(response=>{
         if(response.data.status){
            refetchData()
             toast({
                 component: ToastificationContent,
                 props: {
                 title: "¡Atendido correctamente!",
                     text: response.data.msg,
                     icon: "CheckIcon",
                     variant: "success"
                 }
             });
         }else{
          	errorServer.value = response.data.msg
         }
		}).catch(error=>{
			console.log('error: ', error)
		})
	}

	return {
		fetchContactos,
		tableColumns,
		perPage,
		currentPage,
		totalContactos,
		dataMeta,
		perPageOptions,
		searchQuery,
		sortBy,
		isSortDirDesc,
		refContactosListTable,
		refetchData,
		// frorm
		isContactoFormActive,
		handleEditClick,
		editContacto,
		contactoData,
		errorServer,
		// update status
        updateStatus,
		selected
	}
}