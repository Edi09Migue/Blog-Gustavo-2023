import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchPermissions(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/permisos", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        validateUnique(ctx, value) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/admin/permisos/validate/${value.field}`, {
                        value: value.value
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        addPermission(ctx, permissionData) {
            console.log('storeAdd');
            console.log(permissionData);
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/admin/permisos", permissionData)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        updatePermission(ctx, permissionData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(
                        `/api/admin/permisos/${permissionData.id}`,
                        permissionData
                    )
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        removePermission(ctx, permissionId) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/admin/permisos/${permissionId}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        }
    }
};
