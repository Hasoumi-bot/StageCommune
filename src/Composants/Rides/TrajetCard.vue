<script setup>
import { computed } from 'vue'
//import { openGoogleMaps } from './Layout.vue'
/*
import {
  IcoArrow,
  IcoTrash,
  IcoCalendar
} from './Icons.vue'
*/
const props = defineProps({
  trajet: {
    type: Object,
    required: true
  },
  deleting: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['delete'])

const fmtDate = (d) => {
  return new Date(d).toLocaleDateString('fr-MG', {
    weekday: 'short',
    day: 'numeric',
    month: 'long'
  })
}

const isPast = (date, heure) => {
  return new Date(`${date}T${heure}`) < new Date()
}

const past = computed(() => {
  return isPast(props.trajet.date, props.trajet.heure)
})

const reservees = computed(() => {
  return props.trajet.placesReservees ??
    (props.trajet.placesTotal - props.trajet.places)
})

const pct = computed(() => {
  return props.trajet.placesTotal > 0
    ? (reservees.value / props.trajet.placesTotal) * 100
    : 0
})

const restantes = computed(() => {
  return props.trajet.placesTotal - reservees.value
})

const progressClass = computed(() => {
  if (pct.value === 100) return 'bg-orange-400'
  if (pct.value > 50) return 'bg-blue-400'
  return 'bg-green-400'
})
</script>

<template>
  <div
    class="bg-white rounded-2xl border border-gray-100 p-4
           hover:border-blue-100 hover:shadow-sm transition-all duration-300"
    :class="deleting
      ? 'opacity-0 scale-95 pointer-events-none'
      : 'opacity-100'"
  >

    <!-- Trajet -->
    <div class="flex items-start justify-between mb-3">

      <div>
        <div class="flex items-center gap-1 mb-0.5">
          <span class="font-extrabold text-gray-900">
            {{ trajet.depart }}
          </span>

          <IcoArrow />

          <span class="font-extrabold text-gray-900">
            {{ trajet.arrivee }}
          </span>
        </div>

        <div class="flex items-center gap-1.5 text-xs text-gray-400">
          <IcoCalendar />

          <span>
            {{ fmtDate(trajet.date) }} · {{ trajet.heure }}
          </span>

          <span
            v-if="past"
            class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-medium"
          >
            Passé
          </span>
        </div>
      </div>

      <!-- Boutons -->
      <div class="flex items-center gap-1 shrink-0">

        <!-- Google Maps -->
        <button
          @click="openGoogleMaps(trajet.depart, trajet.arrivee)"
          class="p-2 rounded-xl text-blue-400
                 hover:text-blue-600 hover:bg-blue-50
                 transition-all active:scale-95"
          title="Voir sur Google Maps"
        >
          <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.8"
            class="w-4 h-4"
          >
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
        </button>

        <!-- Supprimer -->
        <button
          v-if="!past"
          @click="emit('delete')"
          class="p-2 rounded-xl text-gray-300
                 hover:text-red-400 hover:bg-red-50
                 transition-all active:scale-95"
        >
          <IcoTrash />
        </button>

      </div>
    </div>

    <!-- Progression -->
    <div class="mb-3">

      <div class="flex items-center justify-between text-xs mb-1.5">
        <span class="text-gray-500 font-medium">
          Places réservées
        </span>

        <span class="font-bold text-gray-800">
          {{ reservees }} / {{ trajet.placesTotal }}
        </span>
      </div>

      <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
        <div
          class="h-full rounded-full transition-all duration-500"
          :class="progressClass"
          :style="{ width: `${pct}%` }"
        />
      </div>

      <p class="text-xs text-gray-400 mt-1">
        {{ restantes }}
        place{{ restantes > 1 ? 's' : '' }}
        restante{{ restantes > 1 ? 's' : '' }}
      </p>

    </div>

    <!-- Prix -->
    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
      <span class="text-xs text-gray-400">
        Prix / place
      </span>

      <span class="text-base font-extrabold text-blue-600">
        {{ Number(trajet.prix).toLocaleString('fr-MG') }} Ar
      </span>
    </div>

  </div>
</template>