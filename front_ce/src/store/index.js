import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
	state: {
		userData:null,
	},
	mutations: {
		SET_USER_DATA(state, user){
			console.log('SET_USER_DATA',user);
			state.userData = user
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
			console.log('getUser',state)
			return state.userData
		}
	}
})
