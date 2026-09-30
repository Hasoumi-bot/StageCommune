<script setup>
import { ref } from 'vue'

const depart = ref('')
const destination = ref('')
const date = ref('')

function Rechercher() {
  console.log("Départ :", depart.value)
  console.log("Destination :", destination.value)
  console.log("Date :", date.value)
}
</script>

<template>

  <div class="recherche-page">

    <div class="alerte">
      <strong>Serveur non disponible</strong>
      <p>Le backend n'est pas disponible</p>
    </div>

    <h4>CYCLO-POUSSE ANTSIRABE</h4>

    <h1>Où allez-vous ?</h1>

    <div class="formulaire">

      <input
        v-model="depart"
        type="text"
        placeholder="Lieu de départ"
      >

      <input
        v-model="destination"
        type="text"
        placeholder="Destination"
      >

      <input
        v-model="date"
        type="date"
      >

      <button
        class="btn-rechercher"
        @click="Rechercher"
      >
        Rechercher
      </button>

    </div>

  </div>

</template>