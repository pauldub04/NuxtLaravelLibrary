export const state = () => ({
    apiToken: '',
    role: '',
    isAuth: false,
    email: '',
})

export const mutations = {
    setToken(state, obj) {
        state.apiToken = obj.token;
        state.role = obj.role;
        state.isAuth = true;
        state.email = obj.email;
    },
    setIsAuth(state) {
        state.isAuth = !state.isAuth;
    },
    logOut(state) {
        state.isAuth = false;
        state.apiToken = '';
        state.role = '';
    },
}

export const actions = {
    setToken(ctx, obj) {
        ctx.commit('setToken', obj);
    },
    setIsAuth(ctx) {
        ctx.commit('setIsAuth');
    },
    logOut(ctx) {
        ctx.commit('logOut');
    },
}

export const getters = {
    getToken: function (state) { return state.apiToken },
    getRole: function (state) { return state.role },
    getIsAuth: function (state) { return state.isAuth },
    getEmail: function (state) { return state.email },
}

//export default store