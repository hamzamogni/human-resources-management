import Vue from 'vue'
import Vuex from 'vuex'
import cells from "./modules/cells";
import members from "./modules/members";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        cells,
        members
    },
})