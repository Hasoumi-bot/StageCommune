<script setup>
import { ref, watch, onMounted } from 'vue'

const props = defineProps({
    label: String,
    value: {
        type: Number,
        default: 0
    },
    color: {
        type: String,
        default: 'blue'
    },
    delay: {
        type: Number,
        default: 0
    },
    loading: Boolean
})

const count = ref(0)
const mounted = ref(false)

const colors = {
    blue: {
        bg: 'bg-blue-50',
        icon: 'text-blue-500',
        val: 'text-blue-700',
        ring: 'ring-blue-100'
    },

    green: {
        bg: 'bg-green-50',
        icon: 'text-green-500',
        val: 'text-green-700',
        ring: 'ring-green-100'
    },

    violet: {
        bg: 'bg-violet-50',
        icon: 'text-violet-500',
        val: 'text-violet-700',
        ring: 'ring-violet-100'
    }
}

const currentColor = () => {
    return colors[props.color] || colors.blue
}


const animateCount = () => {

    if (!props.value) {
        count.value = 0
        return
    }

    let start = 0

    const step = Math.ceil(props.value / 40)

    const timer = setInterval(() => {

        start += step

        if (start >= props.value) {
            count.value = props.value
            clearInterval(timer)
        } else {
            count.value = start
        }

    }, 30)
}


watch(
    () => props.value,
    () => {
        animateCount()
    },
    { immediate: true }
)


onMounted(() => {

    setTimeout(() => {
        mounted.value = true
    }, props.delay)

})
</script>


<template>

    <div
        class="bg-white rounded-2xl border border-gray-100 p-4
               transition-all duration-500"
        :class="
            mounted
                ? 'opacity-100 translate-y-0'
                : 'opacity-0 translate-y-4'
        "
    >

        <div
            class="w-10 h-10 rounded-xl ring-1
                   flex items-center justify-center mb-3"
            :class="[
                currentColor().bg,
                currentColor().ring,
                currentColor().icon
            ]"
        >

            <span class="text-lg">
                ●
            </span>

        </div>


        <div
            v-if="loading"
            class="h-7 w-12 bg-gray-100 rounded-lg
                   animate-pulse mb-0.5"
        ></div>

        <p
            v-else
            class="text-2xl font-extrabold mb-0.5"
            :class="currentColor().val"
        >
            {{ count.toLocaleString() }}
        </p>


        <p class="text-xs text-gray-500 font-medium leading-tight">
            {{ label }}
        </p>

    </div>

</template>
