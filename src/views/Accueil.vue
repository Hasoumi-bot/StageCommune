<script setup>
import { ref } from 'vue'

const depart = ref('')
const destination = ref('')
const date = ref('')

function Rechercher() {
    console.log("Départ :",depart.value)
    console.log("Destination :",destination.value)
    console.log("Date :",date.value)
}

function Connexion(){
    alert("Ouverture de la connexion")
}

const sidebarOuverture = ref(true)

function basculerSidebar() {
    sidebarOuverture.value = !sidebarOuverture.value
}

</script>

<template>

  <div class="app">

    <aside :class="['sidebar', {ferme: !sidebarOuverture}]">

        <button class="btn-sidebar" @click="basculerSidebar">
            {{ sidebarOuverture ? '<' : '>' }}
        </button>

        <h2> Gestion Cylo-pousse </h2>

        <nav>
            <button>Recherche</button>
            <button>Connexion</button>
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
            <div class="alerte">
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
            </div>
        </section>

    </main>

  </div>
</template>

<style scoped>

</style>
