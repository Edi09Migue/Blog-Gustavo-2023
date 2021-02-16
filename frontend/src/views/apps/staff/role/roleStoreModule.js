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
    fetchPermisos(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/admin/permisos`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addRole(ctx, roleData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/admin/roles', { role: roleData })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
