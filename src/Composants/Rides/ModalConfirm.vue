<script setup>
const props = defineProps({
  trajet: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['close', 'confirm'])

const fmtDate = (d) => {
  return new Date(d).toLocaleDateString('fr-MG', {
    weekday: 'short',
    day: 'numeric',
    month: 'long'
  })
}
</script>

<template>
  <div
    class="fixed inset-0 bg-black/40 z-50
           flex items-end sm:items-center justify-center p-4"
  >

    <div class="bg-white rounded-3xl w-full max-w-sm p-6 shadow-2xl">

      <div
        class="w-12 h-12 rounded-2xl bg-red-100
               flex items-center justify-center mb-4 mx-auto"
      >
        <svg
          viewBox="0 0 24 24"
          fill="none"
          stroke="#EF4444"
          stroke-width="1.8"
          class="w-6 h-6"
        >
          <polyline points="3 6 5 6 21 6"/>
          <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
          <path d="M10 11v6M14 11v6"/>
          <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
        </svg>
      </div>

      <h2 class="text-lg font-extrabold text-gray-900 text-center mb-1">
        Annuler ce trajet ?
      </h2>

      <p class="text-sm text-gray-500 text-center mb-1">
        {{ trajet.depart }} → {{ trajet.arrivee }}
      </p>

      <p class="text-xs text-gray-400 text-center mb-5">
        {{ fmtDate(trajet.date) }} à {{ trajet.heure }}
      </p>

      <div
        v-if="trajet.placesReservees > 0"
        class="bg-orange-50 border border-orange-100
               rounded-xl px-4 py-3 mb-5"
      >
        <p class="text-xs text-orange-700 font-medium text-center">
          ⚠️ {{ trajet.placesReservees }}
          passager{{ trajet.placesReservees > 1 ? 's ont' : ' a' }}
          déjà réservé. Ils seront notifiés.
        </p>
      </div>

      <div class="flex gap-3">

        <button
          @click="emit('close')"
          class="flex-1 py-3 rounded-2xl border border-gray-200
                 text-sm font-semibold text-gray-600
                 hover:bg-gray-50 transition-colors"
        >
          Garder
        </button>

        <button
          @click="emit('confirm')"
          class="flex-1 py-3 rounded-2xl bg-red-500 text-white
                 text-sm font-semibold hover:bg-red-600
                 active:scale-95 transition-all shadow-sm"
        >
          Annuler le trajet
        </button>

      </div>

    </div>
  </div>
</template>