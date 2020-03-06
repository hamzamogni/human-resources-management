import VueRouter from "vue-router";

import Home from "./views/Home";
import Members from "./views/Members";
import Cells from "./views/Cells";
import Meetings from "./views/Meetings";

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
        },
        {
            path: "/meetings",
            component: Meetings
        }
    ]
});

export default router;
