<script setup>
import { ref, computed, onMounted } from 'vue'
/*
import StatCard from '../components/StatCard.vue'
import ModalConfirm from '../components/ModalConfirm.vue'
import TrajetRow from '../components/TrajetRow.vue'
import SkeletonRow from '../components/SkeletonRow.vue'
*/
import StatCard from './StatCard.vue'
import ModalConfirm from './ModalConfirm.vue'
import TrajetRow from './TrajetRow.vue'
import SkeletonRow from './SkeletonRow.vue'

const trajets = ref([])

const stats = ref(null)

const fetching = ref(true)

const confirm = ref(null)

const deletingId = ref(null)

const apiErr = ref('')

const search = ref('')

const mounted = ref(false)



const demoData = {

    stats: {
        utilisateurs: 125,
        trajetsActifs: 18,
        reservations: 76
    },

    trajets: [

        {
            id: 1,
            depart: 'Antananarivo',
            arrivee: 'Antsirabe',
            conducteur: 'Jean Rakoto',
            date: '2026-09-26',
            heure: '08:30',
            placesTotal: 20,
            places: 8,
            prix: 25000
        },

        {
            id: 2,
            depart: 'Antananarivo',
            arrivee: 'Toamasina',
            conducteur: 'Paul Randria',
            date: '2026-09-27',
            heure: '07:00',
            placesTotal: 15,
            places: 10,
            prix: 45000
        },

        {
            id: 3,
            depart: 'Antsirabe',
            arrivee: 'Fianarantsoa',
            conducteur: 'Marc Rakoto',
            date: '2026-09-28',
            heure: '09:00',
            placesTotal: 10,
            places: 2,
            prix: 30000
        },

        {
            id: 4,
            depart: 'Antananarivo',
            arrivee: 'Mahajanga',
            conducteur: 'Hery Andria',
            date: '2026-09-29',
            heure: '06:30',
            placesTotal: 20,
            places: 20,
            prix: 55000
        }

    ]

}


const fetchData = async () => {

    fetching.value = true

    apiErr.value = ''

    try {


        await new Promise(resolve =>
            setTimeout(resolve, 800)
        )

        trajets.value = demoData.trajets

        stats.value = demoData.stats

    }

    catch (err) {

        apiErr.value = err.message

    }

    finally {

        fetching.value = false

    }

}




const filtered = computed(() => {

    return trajets.value.filter(trajet => {

        const texte = search.value.toLowerCase()

        return [
            trajet.depart,
            trajet.arrivee,
            trajet.conducteur
        ].some(value =>
            value?.toLowerCase().includes(texte)
        )

    })

})



const openDeleteModal = (trajet) => {

    confirm.value = trajet

}


const closeModal = () => {

    confirm.value = null

}


const deleteTrajet = async () => {

    const id = confirm.value.id

    deletingId.value = id

    confirm.value = null


    try {

        await new Promise(resolve =>
            setTimeout(resolve, 500)
        )


        trajets.value =
            trajets.value.filter(
                trajet => trajet.id !== id
            )


        if (stats.value) {

            stats.value.trajetsActifs =
                Math.max(
                    0,
                    stats.value.trajetsActifs - 1
                )

        }

    }

    catch (err) {

        apiErr.value = err.message

    }

    finally {

        deletingId.value = null

    }

}


onMounted(() => {

    fetchData()

    setTimeout(() => {

        mounted.value = true

    }, 60)

})
</script>


<template>

    <ModalConfirm
        v-if="confirm"
        :trajet="confirm"
        @close="closeModal"
        @confirm="deleteTrajet"
    />


    <div class="px-4 py-5 max-w-2xl mx-auto">



        <div
            class="mb-6 transition-all duration-500"
            :class="
                mounted
                    ? 'opacity-100 translate-y-0'
                    : 'opacity-0 translate-y-4'
            "
        >

            <p
                class="text-xs text-gray-400
                       uppercase tracking-widest
                       font-medium mb-1"
            >
                Administration
            </p>

            <h1
                class="text-2xl font-extrabold
                       text-gray-900 tracking-tight"
            >
                Tableau de bord
            </h1>

        </div>


        <div
            v-if="apiErr"
            class="bg-red-50 border border-red-200
                   rounded-xl px-4 py-3 mb-5
                   text-sm text-red-600
                   font-medium
                   flex items-center
                   justify-between"
        >

            <span>
                {{ apiErr }}
            </span>

            <button
                @click="fetchData"
                class="text-xs font-bold
                       text-red-700
                       hover:underline ml-3"
            >
                Réessayer
            </button>

        </div>


        <div
            class="grid grid-cols-3 gap-3 mb-6"
        >

            <StatCard
                label="Utilisateurs"
                :value="stats?.utilisateurs ?? 0"
                color="blue"
                :delay="100"
                :loading="fetching"
            />

            <StatCard
                label="Trajets actifs"
                :value="stats?.trajetsActifs ?? 0"
                color="green"
                :delay="180"
                :loading="fetching"
            />

            <StatCard
                label="Réservations"
                :value="stats?.reservations ?? 0"
                color="violet"
                :delay="260"
                :loading="fetching"
            />

        </div>


        <div
            class="bg-white rounded-2xl
                   border border-gray-100
                   overflow-hidden
                   transition-all duration-500"
        >



            <div
                class="px-4 py-4
                       border-b border-gray-100
                       flex items-center
                       justify-between gap-3"
            >

                <div>

                    <h2
                        class="text-sm font-extrabold
                               text-gray-800"
                    >
                        Trajets récents
                    </h2>

                    <p
                        class="text-xs text-gray-400
                               mt-0.5"
                    >

                        <span v-if="fetching">
                            …
                        </span>

                        <span v-else>
                            {{ trajets.length }}
                            trajet{{ trajets.length > 1 ? 's' : '' }}
                            au total
                        </span>

                    </p>

                </div>



                <div
                    class="flex items-center gap-2
                           bg-gray-50
                           border border-gray-200
                           rounded-xl px-3 py-2
                           focus-within:border-blue-400
                           transition-all
                           flex-1 max-w-[180px]"
                >

                    <span class="text-gray-400">
                        🔍
                    </span>

                    <input
                        v-model="search"
                        type="text"
                        placeholder="Filtrer…"
                        class="flex-1 text-xs
                               bg-transparent
                               text-gray-700
                               placeholder-gray-300
                               focus:outline-none
                               min-w-0"
                    >

                </div>



                <button
                    @click="fetchData"
                    :disabled="fetching"
                    class="p-2 rounded-xl
                           text-gray-400
                           hover:text-blue-500
                           hover:bg-blue-50
                           transition-all
                           disabled:opacity-40"
                    title="Rafraîchir"
                >

                    ↻

                </button>

            </div>



            <div v-if="fetching">

                <SkeletonRow
                    v-for="i in 4"
                    :key="i"
                />

            </div>



            <div
                v-else-if="filtered.length > 0"
            >

                <TrajetRow
                    v-for="(trajet, index) in filtered"
                    :key="trajet.id"
                    :trajet="trajet"
                    :index="index"
                    :deleting="
                        deletingId === trajet.id
                    "
                    @delete="openDeleteModal"
                />

            </div>



            <div
                v-else
                class="px-4 py-12 text-center"
            >

                <p class="text-sm text-gray-400">

                    {{
                        search
                            ? `Aucun résultat pour « ${search} »`
                            : 'Aucun trajet disponible'
                    }}

                </p>

                <button
                    v-if="search"
                    @click="search = ''"
                    class="mt-2 text-xs
                           text-blue-500
                           font-semibold
                           hover:underline"
                >
                    Effacer le filtre
                </button>

            </div>



            <div
                v-if="!fetching"
                class="px-4 py-3
                       border-t border-gray-100
                       bg-gray-50/50"
            >

                <p
                    class="text-xs text-gray-400
                           text-center"
                >

                    {{ filtered.length }}

                    trajet{{
                        filtered.length > 1
                            ? 's'
                            : ''
                    }}

                    affiché{{
                        filtered.length > 1
                            ? 's'
                            : ''
                    }}

                </p>

            </div>

        </div>


        <div
            v-if="!fetching && trajets.length > 0"
            class="mt-4 bg-white
                   rounded-2xl
                   border border-gray-100
                   p-4"
        >

            <h2
                class="text-sm font-extrabold
                       text-gray-800 mb-3"
            >
                Derniers trajets publiés
            </h2>


            <div class="flex flex-col gap-2.5">

                <div
                    v-for="(trajet, index) in trajets.slice(0, 4)"
                    :key="trajet.id"
                    class="flex items-start gap-3"
                >

                    <div
                        class="w-2 h-2 rounded-full
                               mt-1.5 shrink-0"
                        :class="
                            index === 0
                                ? 'bg-green-400'
                                : index === 1
                                    ? 'bg-blue-400'
                                    : 'bg-gray-300'
                        "
                    ></div>


                    <div
                        class="flex-1 min-w-0"
                    >

                        <p
                            class="text-xs font-medium
                                   text-gray-700
                                   leading-relaxed"
                        >

                            Trajet publié par

                            <span class="font-semibold">
                                {{ trajet.conducteur }}
                            </span>

                            — {{ trajet.depart }}
                            →
                            {{ trajet.arrivee }}

                        </p>

                        <p
                            class="text-xs text-gray-400"
                        >
                            {{ trajet.date }}
                            à
                            {{ trajet.heure }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <div class="h-4"></div>

    </div>

</template>