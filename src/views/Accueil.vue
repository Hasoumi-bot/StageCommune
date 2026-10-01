<script setup>
import { ref,watchEffect } from 'vue'

const depart = ref('')
const destination = ref('')
const date = ref('')

function Rechercher() {
  console.log("Départ :", depart.value)
  console.log("Destination :", destination.value)
  console.log("Date :", date.value)
}

function Connexion() {
  alert("Ouverture de la connexion")
}

const sidebarOuverture = ref(true)

function basculerSidebar() {
  sidebarOuverture.value = !sidebarOuverture.value
}

const darkTheme = ref(localStorage.getItem('theme') !== 'light')

watchEffect(() =>{
    document.documentElement.className = darkTheme.value ? 'dark' : 'light'
})

function changerTheme() {
  darkTheme.value = !darkTheme.value

  localStorage.setItem('theme', darkTheme.value ? 'dark' : 'light')
}
</script>

<template>

  <div :class="['app', { dark: darkTheme, light: !darkTheme}]">

    <aside :class="['sidebar', {ferme: !sidebarOuverture}]">

        <button class="btn-sidebar" @click="basculerSidebar">
            {{ sidebarOuverture ? '<' : '>' }}
        </button>

        <button class="btn-theme" @click="changerTheme">
            <i :class="darkTheme ? 'bi bi-sun' : 'bi bi-moon' "></i>
        </button>
        <h2> Gestion Cylo-pousse </h2>

        <nav>
            <button>Recherche</button>
            <router-link to="/Scann">Scann</router-link>
            <router-link to="/Login">Connexion</router-link>
        </nav>

        <div class="carte">
            <h3>Carte des trajets</h3>
            <p>Voir les quartiers sur Google Maps.</p>
        </div>

    </aside>

    <main class="main">

        <header class="header">

            <span>Recher un trajet</span>

            <button class="btn-connexion" @click="Connexion"> Connexion</button>

        </header>

        <section class="contenu">
            <!--div class="alerte">
                <strong>Serveur non disponible</strong>
                <p>Le backend n'est pas disponible</p>
            </div >

            <h4>CYCLO-POUSSE ANTSIRABE</h4>

            <H1> Où allez-vous? </H1>

            <div class="formulaire">
                <input v-model="depart" type="text" placeholder="Lieu de depart">
                <input v-model="destination" placeholder="Destination">
                <input v-model="date" type="date" >
                <button class="btn-rechercher" @click="Rechercher"> Rechercher </button>
            </div-->

            <RouterView />
        </section>

    </main>

  </div>
</template>

<style scoped>

</style>
