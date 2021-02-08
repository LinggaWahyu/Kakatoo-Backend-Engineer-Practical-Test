import Login from "../views/Login";
import Home from "../views/competitor/Home";
import HomeTrainer from "../views/trainer/Home";
import HomeBoard from "../views/board/Home";
import HomeExpert from "../views/expert/Home";
import EditActivity from "../views/expert/Edit";
import CreateActivity from "../views/expert/Create";

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
            path: "/competitor/home",
            name: "home",
            component: Home
        },
        {
            path: "/trainer/home",
            name: "trainer.home",
            component: HomeTrainer
        },
        {
            path: "/board/home",
            name: "board.home",
            component: HomeBoard
        },
        {
            path: "/expert/home",
            name: "expert.home",
            component: HomeExpert
        },
        {
            path: "/expert/activity/:id/edit",
            name: "activity.edit",
            component: EditActivity
        },
        {
            path: "/expert/activity/create",
            name: "activity.create",
            component: CreateActivity
        }
    ]
};
