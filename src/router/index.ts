import { createRouter, createWebHistory } from "vue-router";
import Accueil from "@/views/Accueil.vue";
import Scanner from "@/views/Scanner.vue";
import path from "path";

const routes = [{
    path:"/",name:"Accueil",component:Accueil
},{
    path:"/Scanner",name:"Scanner",component:Scanner
}]

const router = createRouter({
    history: createWebHistory(), routes
})

export default router