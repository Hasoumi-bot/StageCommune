import { createRouter, createWebHistory } from 'vue-router'

import Accueil from '@/views/Accueil.vue'
import Recherche from '@/views/Recherche.vue'
import Login from '@/views/Login.vue'

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
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router