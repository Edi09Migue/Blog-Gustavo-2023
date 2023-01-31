import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
	state: {
		userData:null,
		token:null,
	},
	mutations: {
		SET_USER_DATA(state, user){
			// console.log('SET_USER_DATA',user);
			state.userData = user
		},
		SET_TOKEN(state, token){
			// console.log('SET_TOKEN',token);
			state.token = token
		},
	},
	actions: {
		user(context, queryParams){
			axios
			.get("/user/")
			.then((response) => {
				context.commit('SET_USER_DATA',response.data.data);
			})
			.catch((error) => {
				console.log("error get user");
				console.log(error);
			});
		},
	},
	getters: {
		getUser: state => {
			return state.userData
		},
		getToken: state => {
			return state.token
		}
	}
})
