import {createStore} from "vuex";
import Auth from "./Auth";

const store = createStore({
    modules: {
        auth: Auth,
    }
});

export default store;
