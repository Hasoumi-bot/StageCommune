<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'

//import Layout from '../components/Layout.vue'


import TrajetCard from './TrajetCard.vue'

import ModalConfirm from './ModalConfirm.vue'
//import { apiTrajets } from '../services/api'

/*import {
  IcoCar,
  IcoPublish,
  IcoSpin
} from '../components/Icons.vue'*/


/* =========================
   ROUTER
========================= */

const router = useRouter()


/* =========================
   ÉTAT
========================= */

const trajets = ref([])
const fetching = ref(true)

const confirm = ref(null)
const deletingId = ref(null)

const toast = ref({
  msg: '',
  type: 'ok'
})

const mounted = ref(false)


/* =========================
   OUTILS
========================= */

const isPast = (date, heure) => {
  return new Date(`${date}T${heure}`) < new Date()
}


/* =========================
   TOAST
========================= */

const showToast = (msg, type = 'ok') => {

  toast.value = {
    msg,
    type
  }

  setTimeout(() => {
    toast.value = {
      msg: '',
      type: 'ok'
    }
  }, 3500)
}


/* =========================
   RÉCUPÉRER MES TRAJETS
========================= */

const fetchMesTrajets = async () => {

  fetching.value = true

  try {

    const data = await apiTrajets.getMesTrajets()

    trajets.value = data.trajets

  } catch (err) {

    showToast(err.message, 'err')

  } finally {

    fetching.value = false

  }
}


/* =========================
   SUPPRESSION
========================= */

const handleDeleteConfirm = async () => {

  const id = confirm.value.id
  const trajet = confirm.value

  deletingId.value = id
  confirm.value = null

  showToast('🔄 Annulation en cours…', 'ok')

  try {

    await apiTrajets.delete(id)

    setTimeout(() => {

      trajets.value = trajets.value.filter(
        t => t.id !== id
      )

      deletingId.value = null

      showToast(
        `✅ Trajet ${trajet.depart} → ${trajet.arrivee} annulé`,
        'ok'
      )

    }, 350)

  } catch (err) {

    showToast(err.message, 'err')

    deletingId.value = null

  }
}


/* =========================
   TRAJETS À VENIR
========================= */

const actifs = computed(() => {

  return trajets.value.filter(
    t => !isPast(t.date, t.heure)
  )

})


/* =========================
   HISTORIQUE
========================= */

const passes = computed(() => {

  return trajets.value.filter(
    t => isPast(t.date, t.heure)
  )

})


/* =========================
   MONTAGE
========================= */

onMounted(() => {

  fetchMesTrajets()

  setTimeout(() => {
    mounted.value = true
  }, 60)

})
</script>


<template>

  <Layout title="Mes trajets">

    <!-- Toast -->

    <div
      v-if="toast.msg"
      class="fixed top-4 left-1/2
             -translate-x-1/2 z-50
             px-5 py-3 rounded-2xl
             shadow-xl text-sm font-semibold
             text-white animate-fade-in
             whitespace-nowrap"
      :class="toast.type === 'ok'
        ? 'bg-green-500'
        : 'bg-red-500'"
    >
      {{ toast.msg }}
    </div>


    <!-- Modal -->

    <ModalConfirm
      v-if="confirm"
      :trajet="confirm"
      @close="confirm = null"
      @confirm="handleDeleteConfirm"
    />


    <div class="px-4 py-5 max-w-lg mx-auto">

      <!-- HEADER -->

      <div
        class="flex items-center justify-between mb-6
               transition-all duration-500"
        :class="mounted
          ? 'opacity-100 translate-y-0'
          : 'opacity-0 translate-y-4'"
      >

        <div>

          <p
            class="text-xs text-gray-400 uppercase
                   tracking-widest font-medium mb-1"
          >
            Conducteur
          </p>

          <h1
            class="text-2xl font-extrabold
                   text-gray-900 tracking-tight"
          >
            Mes trajets
          </h1>

        </div>


        <!-- Nouveau trajet -->

        <button
          @click="router.push('/publier')"
          class="flex items-center gap-2
                 px-4 py-2.5 bg-blue-500 text-white
                 text-sm font-bold rounded-xl
                 hover:bg-blue-600 active:scale-95
                 transition-all
                 shadow-sm shadow-blue-200"
        >
          <IcoPublish />

          <span>Nouveau</span>
        </button>

      </div>


      <!-- CHARGEMENT -->

      <div
        v-if="fetching"
        class="flex justify-center py-12 text-blue-400"
      >
        <IcoSpin />
      </div>


      <!-- AUCUN TRAJET -->

      <div
        v-else-if="trajets.length === 0"
        class="bg-white rounded-2xl
               border border-dashed border-gray-200
               p-12 text-center"
      >

        <div
          class="text-gray-300 flex
                 justify-center mb-3"
        >
          <IcoCar />
        </div>

        <p class="text-sm text-gray-400 mb-4">
          Aucun trajet publié
        </p>

        <button
          @click="router.push('/publier')"
          class="px-5 py-2.5
                 bg-blue-500 text-white
                 text-sm font-bold rounded-xl
                 hover:bg-blue-600
                 transition-colors"
        >
          Publier un trajet
        </button>

      </div>


      <!-- TRAJETS À VENIR -->

      <template v-if="!fetching && actifs.length > 0">

        <p
          class="text-xs font-bold text-gray-500
                 uppercase tracking-wider mb-3"
        >
          À venir · {{ actifs.length }}
        </p>


        <div class="flex flex-col gap-3 mb-6">

          <div
            v-for="(trajet, index) in actifs"
            :key="trajet.id"
            class="transition-all duration-500"
            :class="mounted
              ? 'opacity-100 translate-y-0'
              : 'opacity-0 translate-y-4'"
            :style="{
              transitionDelay: `${120 + index * 70}ms`
            }"
          >

            <TrajetCard
              :trajet="trajet"
              :deleting="deletingId === trajet.id"
              @delete="confirm = trajet"
            />

          </div>

        </div>

      </template>


      <!-- HISTORIQUE -->

      <template v-if="!fetching && passes.length > 0">

        <p
          class="text-xs font-bold text-gray-400
                 uppercase tracking-wider mb-3"
        >
          Historique · {{ passes.length }}
        </p>


        <div class="flex flex-col gap-3">

          <div
            v-for="(trajet, index) in passes"
            :key="trajet.id"
            class="transition-all duration-500"
            :class="mounted
              ? 'opacity-100 translate-y-0'
              : 'opacity-0 translate-y-4'"
            :style="{
              transitionDelay: `${200 + index * 70}ms`
            }"
          >

            <TrajetCard
              :trajet="trajet"
              :deleting="deletingId === trajet.id"
              @delete="confirm = trajet"
            />

          </div>

        </div>

      </template>


      <div class="h-4" />

    </div>

  </Layout>

</template>