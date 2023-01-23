(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./front_ce/src/axios.js":
/*!*******************************!*\
  !*** ./front_ce/src/axios.js ***!
  \*******************************/
/*! exports provided: http */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "http", function() { return http; });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
// import Vue from "vue";
 // window.axios =  axios
// axios.defaults.withCredentials = true
// axios.defaults.baseURL = 'http://controlelectoral.local/api/'
// axios.interceptors.request.use(function(config){
//     config.headers.common = {
//         Autorization:`Bearer ${localStorage.getItem('token')}`,
//         "Content-Type": "application/json",
//         Accept: "applicaction/json"
//     }
//     return config;
// })
// var token = 

var http = axios__WEBPACK_IMPORTED_MODULE_0___default.a.create({
  baseURL: "http://controlelectoral.local/api/"
}); // Vue.prototype.$http = http;
// export default http;
// export const httpFrmData = axios.create({
//     baseURL: `http://controlelectoral.local/api/`,
//     headers: {
//         Authorization: `Bearer ${localStorage.getItem('token')}`,
//         "Content-Type": "multipart/form-data"
//     }
// })

/***/ }),

/***/ "./front_ce/src/components/Alert.vue":
/*!*******************************************!*\
  !*** ./front_ce/src/components/Alert.vue ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Alert_vue_vue_type_template_id_41b477b2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Alert.vue?vue&type=template&id=41b477b2& */ "./front_ce/src/components/Alert.vue?vue&type=template&id=41b477b2&");
/* harmony import */ var _Alert_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Alert.vue?vue&type=script&lang=js& */ "./front_ce/src/components/Alert.vue?vue&type=script&lang=js&");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _Alert_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _Alert_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Alert_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Alert_vue_vue_type_template_id_41b477b2___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Alert_vue_vue_type_template_id_41b477b2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "front_ce/src/components/Alert.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./front_ce/src/components/Alert.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./front_ce/src/components/Alert.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Alert_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Alert.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./front_ce/src/components/Alert.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Alert_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./front_ce/src/components/Alert.vue?vue&type=template&id=41b477b2&":
/*!**************************************************************************!*\
  !*** ./front_ce/src/components/Alert.vue?vue&type=template&id=41b477b2& ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Alert_vue_vue_type_template_id_41b477b2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Alert.vue?vue&type=template&id=41b477b2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./front_ce/src/components/Alert.vue?vue&type=template&id=41b477b2&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Alert_vue_vue_type_template_id_41b477b2___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Alert_vue_vue_type_template_id_41b477b2___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./front_ce/src/views/Home.vue":
/*!*************************************!*\
  !*** ./front_ce/src/views/Home.vue ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Home_vue_vue_type_template_id_35b89cb8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Home.vue?vue&type=template&id=35b89cb8& */ "./front_ce/src/views/Home.vue?vue&type=template&id=35b89cb8&");
/* harmony import */ var _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Home.vue?vue&type=script&lang=js& */ "./front_ce/src/views/Home.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Home_vue_vue_type_template_id_35b89cb8___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Home_vue_vue_type_template_id_35b89cb8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "front_ce/src/views/Home.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./front_ce/src/views/Home.vue?vue&type=script&lang=js&":
/*!**************************************************************!*\
  !*** ./front_ce/src/views/Home.vue?vue&type=script&lang=js& ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./front_ce/src/views/Home.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./front_ce/src/views/Home.vue?vue&type=template&id=35b89cb8&":
/*!********************************************************************!*\
  !*** ./front_ce/src/views/Home.vue?vue&type=template&id=35b89cb8& ***!
  \********************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_35b89cb8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Home.vue?vue&type=template&id=35b89cb8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./front_ce/src/views/Home.vue?vue&type=template&id=35b89cb8&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_35b89cb8___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Home_vue_vue_type_template_id_35b89cb8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./front_ce/src/components/Alert.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./front_ce/src/components/Alert.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  components: {},
  props: {
    type: {
      type: String,
      requiere: true
    },
    description: {
      type: String,
      requiere: true
    }
  },
  data: function data() {
    return {
      color: ''
    };
  },
  computed: {
    title: function title() {
      var title = '';

      switch (this.type) {
        case 'error':
          this.color = 'error';
          title = 'Error';
          break;

        case 'info':
          this.color = 'info';
          title = 'Info';
          break;

        default:
          this.color = 'warning';
          title = 'Warning';
          break;
      }

      return title;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./front_ce/src/views/Home.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./front_ce/src/views/Home.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../axios */ "./front_ce/src/axios.js");
/* harmony import */ var _components_Alert_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/Alert.vue */ "./front_ce/src/components/Alert.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    Alert: _components_Alert_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  data: function data() {
    return {
      acta: {
        id: null,
        codigo: null,
        junta_id: null,
        votos_blancos: 0,
        votos_nulos: 0,
        votos_validos: 0,
        estado: 0,
        ingresada_por: true
      },
      candidatos_votos: [],
      image: null,
      processing: false,
      errorMessage: null,
      infoVotosValidos: null,
      candidatos: [],
      totalActa: 0,
      alert: true
    };
  },
  created: function created() {
    this.fetchJunta();
  },
  computed: {
    user: function user() {
      // return this.$store.getters.getUser
      var x = window.localStorage.getItem('user');
      return JSON.parse(x);
    },
    token: function token() {
      return window.localStorage.getItem('token');
    }
  },
  methods: {
    calcularTotalActa: function calcularTotalActa(value) {
      var total = 0;
      if (this.acta) total = this.acta.votos_blancos + this.acta.votos_nulos + this.acta.votos_validos;
      this.totalActa = parseInt(total);
    },
    calcularVotoCandidato: function calcularVotoCandidato(index) {
      var v_1 = this.candidatos_votos[index].v_1;
      var v_2 = this.candidatos_votos[index].v_2;
      var v_3 = this.candidatos_votos[index].v_3;
      var total = v_1 + v_2 + v_3;
      this.candidatos_votos[index].votos = parseInt(total);

      if (this.candidatos.length == index + 1) {
        var suma = this.candidatos_votos.reduce(function (total, valor) {
          return total + valor.votos;
        }, 0);
        this.infoVotosValidos = '';
        if (suma != this.totalActa) this.infoVotosValidos = 'Los votos válidos del acta no coinciden con la suma de los votos de los candidatos. Revisar';
      }
    },
    fetchJunta: function fetchJunta() {
      var _this = this;

      this.processing = true;
      _axios__WEBPACK_IMPORTED_MODULE_0__["http"].get("control-electoral/last-acta", {
        headers: {
          Authorization: "Bearer ".concat(this.token),
          'Content-Type': 'application/json'
        }
      }).then(function (response) {
        if (response.data.status) {
          _this.acta = response.data.acta;
          _this.candidatos = response.data.candidatos;
          var actaId = _this.acta.id;
          var procesadaPor = _this.user.id;
          _this.candidatos_votos = response.data.candidatos.map(function (candidato) {
            return {
              candidato_id: candidato.id,
              acta_id: actaId,
              v_1: 0,
              v_2: 0,
              v_3: 0,
              votos: 0,
              procesada_por: procesadaPor
            };
          });
        }

        _this.processing = false;
      })["catch"](function (error) {
        console.log(error);
        _this.errorMessage = error;
        _this.processing = false;
      });
    },
    addVoto: function addVoto(event) {
      var _this2 = this;

      // Verificar si todos esta bien
      var sumaVotos = this.candidatos_votos.reduce(function (total, valor) {
        return total + valor.votos;
      }, 0);
      var infromacion = '';
      if (sumaVotos != this.totalActa) infromacion = 'Si los votos válidos no coinciden con la suma de los votos de los candidatos, por favor hacer una captura, e informar al a una persona encargada.';
      this.$swal({
        title: 'Resumen',
        position: 'top-end',
        allowOutsideClick: false,
        text: 'POR FAVOR INFORMA ÉSTE PROBLEMA A UN ADMINISTRADOR',
        html: "<div class=\"text-orange-600\">\n                        <table class=\"w-full text-sm text-left\">\n                            <tr class=\"border-blanco dark:bg-blanco dark:border-gray-700 text-center\" colspan=\"2\">\n                                <th class=\"border border-curren text-lg\">ACTA ".concat(this.acta.codigo, "</th>\n                            </tr>\n                            <tr class=\"border-blanco dark:bg-blanco dark:border-gray-700\">\n                                <td class=\"border border-curren text-lg\">Votos blanco</td>\n                                <td class=\"border border-curren text-lg\">").concat(this.acta.votos_blancos, "</td>\n                            </tr>\n                            <tr class=\"border-blanco dark:bg-blanco dark:border-gray-700\">\n                                <td class=\"border border-curren text-lg\">Votos nulos</td>\n                                <td class=\"border border-curren text-lg\">").concat(this.acta.votos_nulos, "</td>\n                            </tr>\n                            <tr class=\"border-blanco dark:bg-blanco dark:border-gray-700\">\n                                <td class=\"border border-curren text-lg\">Votos nalidos</td>\n                                <td class=\"border border-curren text-lg\">").concat(this.acta.votos_validos, "</td>\n                            </tr>\n                            <tr class=\"border-blanco dark:bg-blanco dark:border-gray-700\">\n                                <td class=\"border border-curren text-lg\">Total votos de los candidatos</td>\n                                <td class=\"border border-curren text-lg\">").concat(this.acta.votos_validos, "</td>\n                            </tr>\n                        </table>\n                        <p class=\"text-sm text-justify text-blue-900\">\n                            ").concat(infromacion, "\n                        </p>\n                <div>"),
        confirmButtonText: 'Ok Guardar'
      }).then(function (result) {
        if (result.isConfirmed) {
          // Confirma y enviar a guarda
          _this2.save(event);
        } else if (result.isDenied) {
          _this2.$swal('Changes are not saved', '', 'info');
        }
      });
    },
    save: function save(event) {
      var _this3 = this;

      this.processing = true; // Eliminar datos innecesarios 

      delete this.acta.imagenURL;
      delete this.acta.media;
      this.candidatos_votos = this.candidatos_votos.map(function (item) {
        return {
          candidato_id: item.candidato_id,
          acta_id: item.acta_id,
          votos: item.votos,
          procesada_por: item.procesada_por
        };
      }); // Crear data para el put

      var data = {
        acta: this.acta,
        candidatos_votos: this.candidatos_votos
      }; // Envar a guardar

      _axios__WEBPACK_IMPORTED_MODULE_0__["http"].put("control-electoral/actas/".concat(this.acta.id), data, {
        headers: {
          Authorization: "Bearer ".concat(this.token),
          'Content-Type': 'application/json'
        }
      }).then(function (response) {
        if (response.data.status) {
          event.target.reset();

          _this3.fetchJunta();

          _this3.showSucces();

          _this3.totalActa = 0;
        } else {
          event.target.reset();

          _this3.showWarning(response.data.msg);
        }

        _this3.processing = false;
      })["catch"](function (error) {
        console.log(error);
        _this3.errorMessage = error;
        _this3.processing = false;
      });
    },
    showWarning: function showWarning(msg) {
      var _this4 = this;

      this.$swal({
        icon: 'warning',
        title: msg,
        allowOutsideClick: false,
        text: 'POR FAVOR INFORMA ÉSTE PROBLEMA A UN ADMINISTRADOR',
        footer: 'Por favor informa éste problema a un administrador ',
        confirmButtonText: 'Ok registrar otra acta'
      }).then(function (result) {
        if (result.isConfirmed) {
          _this4.$refs.frmVotos.reset();

          _this4.fetchRecintos();
        } else if (result.isDenied) {
          _this4.$swal('Changes are not saved', '', 'info');
        }
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./front_ce/src/components/Alert.vue?vue&type=template&id=41b477b2&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./front_ce/src/components/Alert.vue?vue&type=template&id=41b477b2& ***!
  \********************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      class:
        "bg-" +
        _vm.color +
        " border border-" +
        _vm.color +
        " text-" +
        _vm.color +
        "-700 px-4 py-3 rounded relative",
      attrs: { role: "alert" }
    },
    [
      _c("strong", { staticClass: "font-bold" }, [
        _vm._v(_vm._s(_vm.title) + "!")
      ]),
      _vm._v(" "),
      _c("span", { staticClass: "block sm:inline" }, [
        _vm._v(_vm._s(_vm.description))
      ]),
      _vm._v(" "),
      _c("span", { staticClass: "absolute top-0 bottom-0 right-0 px-4 py-3" }, [
        _c(
          "svg",
          {
            class: "fill-current h-6 w-6 text-" + _vm.color + "-500",
            attrs: {
              role: "button",
              xmlns: "http://www.w3.org/2000/svg",
              viewBox: "0 0 20 20"
            }
          },
          [
            _c("title", [_vm._v("Close")]),
            _c("path", {
              attrs: {
                d:
                  "M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"
              }
            })
          ]
        )
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./front_ce/src/views/Home.vue?vue&type=template&id=35b89cb8&":
/*!**************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./front_ce/src/views/Home.vue?vue&type=template&id=35b89cb8& ***!
  \**************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "grid place-items-center box-main " }, [
    _c("div", { staticClass: "container mx-auto" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "container max-auto " }, [
        _c(
          "div",
          {
            staticClass:
              "bg-blanco rounded overflow-hidden shadow-lg min-w-[80%]"
          },
          [
            _c("div", { staticClass: "pt-4 pb-10" }, [
              _c(
                "form",
                {
                  ref: "frmVotos",
                  staticClass: "w-full",
                  on: {
                    submit: function($event) {
                      $event.preventDefault()
                      return _vm.addVoto($event)
                    }
                  }
                },
                [
                  _c("div", { staticClass: "grid grid-cols-2 gap-4" }, [
                    _c(
                      "div",
                      { staticClass: "min-w-[50%] pl-2 flex items-center" },
                      [
                        _c(
                          "figure",
                          { staticClass: "max-w-lg m-auto w-full" },
                          [
                            _c("img", {
                              staticClass: "rounded-lg max-h-[500px]",
                              attrs: {
                                src: _vm.acta
                                  ? _vm.acta.imagenOriginalURL
                                  : "no-imagen-acta.jpg",
                                height: "224px",
                                alt: ""
                              }
                            }),
                            _vm._v(" "),
                            !_vm.acta.imagenOriginalURL
                              ? _c(
                                  "figcaption",
                                  {
                                    staticClass:
                                      "mt-2 text-sm text-center text-gray-500 dark:text-gray-400"
                                  },
                                  [_vm._v("Vista previa de la imagen del acta")]
                                )
                              : _vm._e()
                          ]
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "min-w-[50%] pr-2" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "text-negro underline font-bold decoration-negro"
                        },
                        [
                          _c("h2", [
                            _vm._v(
                              "\r\n                                        ACTA  "
                            ),
                            _vm.acta
                              ? _c("span", [_vm._v(_vm._s(_vm.acta.codigo))])
                              : _vm._e()
                          ])
                        ]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "container mx-auto" }, [
                        _c("div", { staticClass: "flex flex-wrap" }, [
                          _c(
                            "div",
                            {
                              staticClass:
                                "w-full sm:w-1/2 md:w-1/4 lg:w-1/4 xl:w-1/4 mb-4"
                            },
                            [
                              _c(
                                "label",
                                {
                                  staticClass:
                                    "block mb-2 text-sm font-medium text-gray-900 dark:text-negro",
                                  attrs: { for: "first_name" }
                                },
                                [_vm._v("Blancos")]
                              ),
                              _vm._v(" "),
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.acta.votos_blancos,
                                    expression: "acta.votos_blancos"
                                  }
                                ],
                                staticClass:
                                  "w-full border border-[#e0e0e0] bg-white px-2 py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md",
                                attrs: {
                                  oninput:
                                    "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*)\\./g, '$1');",
                                  min: "0",
                                  step: "1",
                                  type: "text",
                                  id: "first_name",
                                  placeholder: "0",
                                  required: ""
                                },
                                domProps: { value: _vm.acta.votos_blancos },
                                on: {
                                  input: [
                                    function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.acta,
                                        "votos_blancos",
                                        $event.target.value
                                      )
                                    },
                                    _vm.calcularTotalActa
                                  ]
                                }
                              })
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "w-full sm:w-1/2 md:w-1/4 lg:w-1/4 xl:w-1/4 mb-4"
                            },
                            [
                              _c(
                                "label",
                                {
                                  staticClass:
                                    "block mb-2 text-sm font-medium text-gray-900 dark:text-negro",
                                  attrs: { for: "last_name" }
                                },
                                [_vm._v("Nulos")]
                              ),
                              _vm._v(" "),
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.acta.votos_nulos,
                                    expression: "acta.votos_nulos"
                                  }
                                ],
                                staticClass:
                                  "w-full border border-[#e0e0e0] bg-white px-2 py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md",
                                attrs: {
                                  oninput:
                                    "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*)\\./g, '$1');",
                                  min: "0",
                                  step: "1",
                                  type: "text",
                                  id: "last_name",
                                  placeholder: "0",
                                  required: ""
                                },
                                domProps: { value: _vm.acta.votos_nulos },
                                on: {
                                  input: [
                                    function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.acta,
                                        "votos_nulos",
                                        $event.target.value
                                      )
                                    },
                                    _vm.calcularTotalActa
                                  ]
                                }
                              })
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "w-full sm:w-1/2 md:w-1/4 lg:w-1/4 xl:w-1/4 mb-4"
                            },
                            [
                              _c(
                                "label",
                                {
                                  staticClass:
                                    "block mb-2 text-sm font-medium text-gray-900 dark:text-negro",
                                  attrs: { for: "last_name" }
                                },
                                [_vm._v("Validos")]
                              ),
                              _vm._v(" "),
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.acta.votos_validos,
                                    expression: "acta.votos_validos"
                                  }
                                ],
                                staticClass:
                                  "w-full border border-[#e0e0e0] bg-white px-2 py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md",
                                attrs: {
                                  oninput:
                                    "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*)\\./g, '$1');",
                                  min: "0",
                                  step: "1",
                                  type: "text",
                                  id: "last_name",
                                  placeholder: "0",
                                  required: ""
                                },
                                domProps: { value: _vm.acta.votos_validos },
                                on: {
                                  input: [
                                    function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.acta,
                                        "votos_validos",
                                        $event.target.value
                                      )
                                    },
                                    _vm.calcularTotalActa
                                  ]
                                }
                              })
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "w-full sm:w-1/2 md:w-1/4 lg:w-1/4 xl:w-1/4 mb-4"
                            },
                            [
                              _c(
                                "label",
                                {
                                  staticClass:
                                    "block mb-2 text-sm font-medium text-gray-900 dark:text-negro",
                                  attrs: { for: "last_name" }
                                },
                                [_vm._v("TOTAL")]
                              ),
                              _vm._v(" "),
                              _c("input", {
                                staticClass:
                                  "w-full border border-[#e0e0e0] bg-white px-2 py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md",
                                attrs: {
                                  disabled: "",
                                  type: "text",
                                  id: "last_name",
                                  placeholder: "0",
                                  required: ""
                                },
                                domProps: { value: _vm.totalActa }
                              })
                            ]
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "grid" }, [
                        _c("div", { staticClass: "text-red-700" }, [
                          _vm.infoVotosValidos
                            ? _c(
                                "h3",
                                { staticClass: "text-red-700 text-sm" },
                                [_vm._v(_vm._s(_vm.infoVotosValidos))]
                              )
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        _c(
                          "table",
                          { staticClass: "w-full text-sm text-left" },
                          [
                            _vm._m(1),
                            _vm._v(" "),
                            _vm.candidatos_votos.length > 0
                              ? _c(
                                  "tbody",
                                  _vm._l(_vm.candidatos, function(
                                    candidato,
                                    index
                                  ) {
                                    return _c(
                                      "tr",
                                      {
                                        key: candidato.id,
                                        staticClass:
                                          "bg-white border-blanco dark:bg-blanco dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-blanco dark:hover:text-blanco"
                                      },
                                      [
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "border border-curren hover:text-blanco dark:hover:text-blanco"
                                          },
                                          [_vm._v(_vm._s(candidato.nombre))]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "border border-curren hover:text-blanco dark:hover:text-blanco"
                                          },
                                          [
                                            _vm._v(
                                              _vm._s(candidato.nombre_partido)
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "border border-curren w-8"
                                          },
                                          [
                                            _c("input", {
                                              directives: [
                                                {
                                                  name: "model",
                                                  rawName: "v-model",
                                                  value:
                                                    _vm.candidatos_votos[index]
                                                      .v_1,
                                                  expression:
                                                    "candidatos_votos[index].v_1"
                                                }
                                              ],
                                              staticClass:
                                                "w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md",
                                              attrs: {
                                                type: "text",
                                                min: "0",
                                                max: "1",
                                                oninput:
                                                  "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*)\\./g, '$1');",
                                                placeholder: "0"
                                              },
                                              domProps: {
                                                value:
                                                  _vm.candidatos_votos[index]
                                                    .v_1
                                              },
                                              on: {
                                                input: [
                                                  function($event) {
                                                    if (
                                                      $event.target.composing
                                                    ) {
                                                      return
                                                    }
                                                    _vm.$set(
                                                      _vm.candidatos_votos[
                                                        index
                                                      ],
                                                      "v_1",
                                                      $event.target.value
                                                    )
                                                  },
                                                  function($event) {
                                                    return _vm.calcularVotoCandidato(
                                                      index
                                                    )
                                                  }
                                                ]
                                              }
                                            })
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "border border-curren w-8"
                                          },
                                          [
                                            _c("input", {
                                              directives: [
                                                {
                                                  name: "model",
                                                  rawName: "v-model",
                                                  value:
                                                    _vm.candidatos_votos[index]
                                                      .v_2,
                                                  expression:
                                                    "candidatos_votos[index].v_2"
                                                }
                                              ],
                                              staticClass:
                                                "w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md",
                                              attrs: {
                                                type: "text",
                                                min: "0",
                                                max: "1",
                                                oninput:
                                                  "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*)\\./g, '$1');",
                                                placeholder: "0"
                                              },
                                              domProps: {
                                                value:
                                                  _vm.candidatos_votos[index]
                                                    .v_2
                                              },
                                              on: {
                                                input: [
                                                  function($event) {
                                                    if (
                                                      $event.target.composing
                                                    ) {
                                                      return
                                                    }
                                                    _vm.$set(
                                                      _vm.candidatos_votos[
                                                        index
                                                      ],
                                                      "v_2",
                                                      $event.target.value
                                                    )
                                                  },
                                                  function($event) {
                                                    return _vm.calcularVotoCandidato(
                                                      index
                                                    )
                                                  }
                                                ]
                                              }
                                            })
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          {
                                            staticClass:
                                              "border border-curren w-8"
                                          },
                                          [
                                            _c("input", {
                                              directives: [
                                                {
                                                  name: "model",
                                                  rawName: "v-model",
                                                  value:
                                                    _vm.candidatos_votos[index]
                                                      .v_3,
                                                  expression:
                                                    "candidatos_votos[index].v_3"
                                                }
                                              ],
                                              staticClass:
                                                "w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md",
                                              attrs: {
                                                type: "text",
                                                min: "0",
                                                max: "1",
                                                oninput:
                                                  "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\\..*)\\./g, '$1');",
                                                placeholder: "0"
                                              },
                                              domProps: {
                                                value:
                                                  _vm.candidatos_votos[index]
                                                    .v_3
                                              },
                                              on: {
                                                input: [
                                                  function($event) {
                                                    if (
                                                      $event.target.composing
                                                    ) {
                                                      return
                                                    }
                                                    _vm.$set(
                                                      _vm.candidatos_votos[
                                                        index
                                                      ],
                                                      "v_3",
                                                      $event.target.value
                                                    )
                                                  },
                                                  function($event) {
                                                    return _vm.calcularVotoCandidato(
                                                      index
                                                    )
                                                  }
                                                ]
                                              }
                                            })
                                          ]
                                        )
                                      ]
                                    )
                                  }),
                                  0
                                )
                              : _vm._e()
                          ]
                        )
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "min-w-[100%] p-4" },
                    [
                      _vm.acta.id
                        ? [
                            _c(
                              "button",
                              {
                                staticClass:
                                  "flex justify-center w-full border-solid border border-negro rounded-xl bg-negro",
                                attrs: { type: "submit" }
                              },
                              [
                                _c("span", { staticClass: "text-blanco" }, [
                                  _vm._v(" GUARDAR ")
                                ]),
                                _vm._v(" "),
                                _c("span", { staticClass: "pt-2" }, [
                                  _vm.processing
                                    ? _c(
                                        "svg",
                                        {
                                          staticClass:
                                            "h-6 w-6 text-white animate-spin",
                                          attrs: {
                                            xmlns: "http://www.w3.org/2000/svg",
                                            fill: "none",
                                            viewBox: "0 0 24 24",
                                            stroke: "currentColor"
                                          }
                                        },
                                        [
                                          _c("path", {
                                            attrs: {
                                              "stroke-linecap": "round",
                                              "stroke-linejoin": "round",
                                              "stroke-width": "2",
                                              d:
                                                "M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                            }
                                          })
                                        ]
                                      )
                                    : _vm._e()
                                ])
                              ]
                            )
                          ]
                        : [
                            _c("alert", {
                              attrs: {
                                type: "info",
                                description:
                                  "No existe ninguna acta para revisar los votos! Gracias por tu trabajo"
                              }
                            })
                          ]
                    ],
                    2
                  )
                ]
              )
            ])
          ]
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "container max-auto text-negro text-xl pt-[78px] pl-4" },
      [
        _c(
          "h1",
          { staticClass: "text-negro underline font-bold decoration-negro" },
          [_vm._v("\r\n                REGISTRO DE VOTOS\r\n            ")]
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "thead",
      { staticClass: "text-xs text-negro uppercase bg-plomo-light" },
      [
        _c("tr", { staticClass: "bg-plomo-light" }, [
          _c("th", { staticClass: "py-1" }, [_vm._v("Candidato")]),
          _vm._v(" "),
          _c("th", { staticClass: "py-1" }, [_vm._v("Partido político")]),
          _vm._v(" "),
          _c(
            "th",
            { staticClass: "py-1 text-center", attrs: { colspan: "3" } },
            [_vm._v("Votos")]
          )
        ])
      ]
    )
  }
]
render._withStripped = true



/***/ })

}]);