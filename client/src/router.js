import VueRouter from "vue-router";

import Home from "./views/Home";
import Members from "./views/Members";
import Cells from "./views/Cells";

const router =  new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Home,
        },
        {
            path: '/members',
            component: Members,
        },
        {
            path: '/cells',
            component: Cells,
        }
    ]
});

export default router;
