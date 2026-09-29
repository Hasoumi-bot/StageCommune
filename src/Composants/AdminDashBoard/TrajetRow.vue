<script setup>
import { computed } from 'vue'

const props = defineProps({
    trajet: {
        type: Object,
        required: true
    },

    index: {
        type: Number,
        required: true
    },

    deleting: Boolean
})

const emit = defineEmits(['delete'])


const reservees = computed(() => {
    return props.trajet.placesTotal - props.trajet.places
})


const pct = computed(() => {

    if (props.trajet.placesTotal <= 0) {
        return 0
    }

    return (
        reservees.value /
        props.trajet.placesTotal
    ) * 100

})


const formattedDate = computed(() => {

    return new Date(
        props.trajet.date
    ).toLocaleDateString('fr-MG', {
        day: 'numeric',
        month: 'short'
    })

})


const initials = computed(() => {

    return props.trajet.conducteur
        ?.split(' ')
        .map(word => word[0])
        .join('')
        .slice(0, 2)
        .toUpperCase()

})


const progressColor = computed(() => {

    if (pct.value === 100) {
        return 'bg-orange-400'
    }

    if (pct.value > 50) {
        return 'bg-blue-400'
    }

    return 'bg-green-400'

})
</script>


<template>

    <div
        class="flex items-center gap-3 px-4 py-3.5
               border-b border-gray-50
               hover:bg-gray-50/70
               transition-all duration-300 group"
        :class="deleting
            ? 'opacity-0 scale-95 pointer-events-none'
            : 'opacity-100'"
    >

        <span
            class="text-xs font-bold text-gray-300
                   w-5 shrink-0 text-right"
        >
            {{ index + 1 }}
        </span>


        <div class="flex-1 min-w-0">

            <div class="flex items-center gap-1 mb-0.5">

                <span
                    class="text-sm font-bold
                           text-gray-900 truncate"
                >
                    {{ trajet.depart }}
                </span>

                <span class="text-gray-400">
                    →
                </span>

                <span
                    class="text-sm font-bold
                           text-gray-900 truncate"
                >
                    {{ trajet.arrivee }}
                </span>

            </div>


            <div
                class="flex items-center gap-1.5
                       text-xs text-gray-400"
            >

                <span>📅</span>

                <span>
                    {{ formattedDate }} · {{ trajet.heure }}
                </span>

            </div>

        </div>


        <div
            class="hidden sm:flex items-center
                   gap-2 shrink-0"
        >

            <div
                class="w-6 h-6 rounded-lg
                       bg-gradient-to-br
                       from-blue-400 to-blue-600
                       flex items-center justify-center
                       text-white text-[9px] font-bold"
            >
                {{ initials }}
            </div>

            <span
                class="text-xs font-medium
                       text-gray-600 truncate
                       max-w-[70px]"
            >
                {{ trajet.conducteur }}
            </span>

        </div>


        <div class="shrink-0 text-right">

            <p
                class="text-xs font-bold
                       text-gray-700"
            >
                {{ reservees }}/{{ trajet.placesTotal }}
            </p>

            <div
                class="w-14 h-1.5 bg-gray-100
                       rounded-full mt-1 overflow-hidden"
            >

                <div
                    class="h-full rounded-full
                           transition-all duration-500"
                    :class="progressColor"
                    :style="{ width: pct + '%' }"
                ></div>

            </div>

        </div>


        <div
            class="shrink-0 hidden sm:block
                   text-right"
        >

            <p
                class="text-xs font-bold
                       text-blue-600"
            >
                {{ Number(trajet.prix).toLocaleString('fr-MG') }}
                Ar
            </p>

        </div>


        <button
            @click="emit('delete', trajet)"
            class="p-2 rounded-xl
                   text-gray-200
                   hover:text-red-400
                   hover:bg-red-50
                   transition-all
                   duration-200
                   active:scale-95
                   shrink-0
                   opacity-0
                   group-hover:opacity-100"
        >

            🗑️

        </button>

    </div>

</template>