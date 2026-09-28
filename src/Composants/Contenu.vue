<template>
<main class="main">

        

        <section class="contenu">
            <div class="alerte">
                <strong>Serveur non disponible</strong>
                <p>Le backend n'est pas disponible</p>
            </div>

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
</template>

<script setup>
import { ref } from 'vue'

//import Sidebar from './Composants/Sidebar.vue'

const depart = ref('')
const destination = ref('')
const date = ref('')

function Rechercher() {
    console.log("Départ :",depart.value)
    console.log("Destination :",destination.value)
    console.log("Date :",date.value)
}
</script>