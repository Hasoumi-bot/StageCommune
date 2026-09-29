<template>

        

        <section class="contenu w-full">
            <!--div class="alerte">
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
            </div-->
            <RouterView />
        </section>

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

<style>
.contenu{
    width: 100%;
}
</style>