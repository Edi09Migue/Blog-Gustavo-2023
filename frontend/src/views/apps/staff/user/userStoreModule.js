import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchUsers(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/usuarios", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        fetchUser(ctx, { id }) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/admin/usuarios/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        fetchLoggedUser(ctx) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/api/auth/user`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        fetchRoles(ctx) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/roles/dropdownOptions")
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        validateUnique(ctx, value) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/admin/usuarios/validate/${value.field}`, {
                        value: value.value
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        addUser(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/admin/usuarios", userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        updateUser(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(
                        `/api/admin/usuarios/${userData.value.id}`,
                        userData.value
                    )
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        updateProfile(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/admin/profile/update`, userData.value)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        updatePassword(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(
                        `/api/admin/usuario/${userData.id}/updatePassword`,
                        userData
                    )
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        updateUserPassword(ctx, userData) {
            return new Promise((resolve, reject) => {
                axios
                    .put(`/api/admin/profile/updatePassword`, userData)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        removeUser(ctx, userId) {
            return new Promise((resolve, reject) => {
                axios
                    .delete(`/api/admin/usuarios/${userId}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },
        importExcel(ctx, document) {
            return new Promise((resolve, reject) => {
                axios
                    .post(`/api/admin/usuarios/import`, document, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        }
    }
};
