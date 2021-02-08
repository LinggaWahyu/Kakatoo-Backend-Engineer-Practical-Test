import Login from "../views/Login";
import Home from "../views/Home";

export default {
    mode: "history",
    linkActiveClass: "active",
    routes: [
        {
            path: "/",
            name: "login",
            component: Login
        },
        {
            path: "/home",
            name: "home",
            component: Home
        }
    ]
};
