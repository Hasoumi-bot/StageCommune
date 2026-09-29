<script setup>
import router from '@/router'
import { ref, watchEffect } from 'vue'

const sidebarOuverture = ref(true)

function basculerSidebar() {
  sidebarOuverture.value = !sidebarOuverture.value
}

const darkTheme = ref(
  localStorage.getItem('theme') !== 'light'
)

watchEffect(() => {
  document.documentElement.className =
    darkTheme.value ? 'dark' : 'light'
})

function changerTheme() {
  darkTheme.value = !darkTheme.value

  localStorage.setItem(
    'theme',
    darkTheme.value ? 'dark' : 'light'
  )
}

function allerLogin() {
  router.push('/login')
}

function allerRecherche() {
  router.push('/')
}
</script>


<template>

  <div :class="['app', {
    dark: darkTheme,
    light: !darkTheme
  }]">

    <!-- =========================
         SIDEBAR
    ========================== -->

    <aside
      :class="[
        'sidebar',
        { ferme: !sidebarOuverture }
      ]"
    >

      <button
        class="btn-sidebar"
        @click="basculerSidebar"
      >
        {{ sidebarOuverture ? '<' : '>' }}
      </button>


      <!-- THEME -->

      <button
        class="btn-theme"
        @click="changerTheme"
      >
        <i
          :class="
            darkTheme
              ? 'bi bi-sun'
              : 'bi bi-moon'
          "
        ></i>
      </button>


      <h2>
        Gestion Cyclo-pousse
      </h2>


      <!-- MENU -->

      <nav>

        <button @click="allerRecherche">
          Recherche
        </button>

        <button @click="allerLogin">
          Connexion
        </button>

      </nav>


      <!-- CARTE -->

      <div class="carte">

        <h3>
          Carte des trajets
        </h3>

        <p>
          Voir les quartiers sur Google Maps.
        </p>

      </div>

    </aside>


    <!-- =========================
         PARTIE PRINCIPALE
    ========================== -->

    <main class="main">

      <!-- HEADER -->

      <header class="header">

        <span>
          Cyclo-Pousse
        </span>

        <div class="header-droite">

          <button
            class="btn-connexion"
            @click="allerLogin"
          >
            Connexion
          </button>

        </div>

      </header>


      <!-- =========================
           CONTENU DYNAMIQUE
      ========================== -->

      <section class="contenu">

        <RouterView />

      </section>

    </main>

  </div>

</template>