import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchRoles(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/admin/roles', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchRole(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/admin/roles/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchPermisos(ctx) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/admin/permisos/dropdownOptions`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    validateUnique(ctx, value ) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/admin/roles/validate/${value.field}`,{value:value.value})
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addRole(ctx, roleData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/admin/roles', roleData.value)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    updateRole(ctx, roleData) {
      return new Promise((resolve, reject) => {
        axios
          .put(`/api/admin/roles/${roleData.value.id}`, roleData.value)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    removeRole(ctx, roleId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/admin/roles/${roleId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
