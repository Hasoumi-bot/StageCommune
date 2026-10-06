import path from "path";
import { createRouter, createWebHistory } from "vue-router";
import AdminDashboard from "@/Composants/AdminDashBoard/AdminDashboard.vue";
//import MyRider from "@/Composants/Rides/MyRider.vue";
import MyRider from "@/Composants/Rides/MyRider.vue";

const routes = [{path:"/", name:"Accueil", component:AdminDashboard},
                {path:"/trajet", name:"Trajet", component:MyRider}
]  

const router = createRouter({
    history:createWebHistory(), routes
})

export default router