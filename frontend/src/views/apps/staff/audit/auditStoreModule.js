import axios from "@axios";

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        fetchAudits(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/audits", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        fetchEntidadesOptions(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/audit_entidades/dropdownOptions", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        fetchAccionesOptions(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/audit_acciones/dropdownOptions", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        fetchUsuariosAuditOptions(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get("/api/admin/audit_usuarios/dropdownOptions", { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

        generarReportes(ctx, reportFilters) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/api/admin/audit/reportes", reportFilters, {
                        responseType: "blob"
                    })
                    .then(response => resolve(response))
                    .catch(error => reject(error));
            });
        },

    }
};
