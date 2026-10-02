import { createRouter, createWebHistory } from 'vue-router'

import Accueil from '@/views/Accueil.vue'
import Recherche from '@/views/Recherche.vue'
import Login from '@/views/Login.vue'
import Scanner from '@/views/Scanner.vue'

const routes = [
  {
    path: '/',
    component: Accueil,

    children: [
      {
        path: '',
        name: 'Recherche',
        component: Recherche
      },
      {
        path: 'login',
        name: 'Login',
        component: Login
      },
      {
        path: 'scanner',
        name: 'Scanner',
        component: Scanner
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router

// import { createRouter, createWebHistory } from "vue-router";
// import Accueil from "@/views/Accueil.vue";
// import Scanner from "@/views/Scanner.vue";
// import path from "path";

// const routes = [{
//     path:"/",name:"Accueil",component:Accueil
// },{
//     path:"/Scanner",name:"Scanner",component:Scanner
// }]
// >>>>>>> 7089729e3dfd31ec4602dd0b55ecb25a21294010

// const router = createRouter({
//   history: createWebHistory(),
//   routes
// })

// export default router