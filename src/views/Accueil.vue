<script setup>
import { ref } from 'vue'
import { RouterView, useRouter } from 'vue-router'

const router = useRouter()



const sidebarOuverture = ref(true)

function basculerSidebar() {
  sidebarOuverture.value = !sidebarOuverture.value
}



const darkTheme = ref(
  localStorage.getItem('theme') !== 'light'
)

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

function allerScanner() {
  router.push('/scanner')
}
</script>


<template>


  <div
    :class="[
      'app',
      {
        dark: darkTheme,
        light: !darkTheme
      }
    ]"
  >


    <aside
      :class="[
        'sidebar',
        {
          ferme: !sidebarOuverture
        }
      ]"
    >

  
      <button
        class="btn-sidebar"
        @click="basculerSidebar"
      >
        {{ sidebarOuverture ? '<' : '>' }}
      </button>

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

      <h2 v-if="sidebarOuverture">
        Gestion Cyclo-pousse
      </h2>


      <nav>

        <button
          @click="allerRecherche"
        >
          <i class="bi bi-search"></i>

          <span v-if="sidebarOuverture">
            Recherche
          </span>
        </button>


        <button
          @click="allerLogin"
        >
          <i class="bi bi-person"></i>

          <span v-if="sidebarOuverture">
            Connexion
          </span>
        </button>


        <button
          @click="allerScanner"
        >
          <i class="bi bi-qr-code-scan"></i>

          <span v-if="sidebarOuverture">
            Scanner
          </span>
        </button>

      </nav>



      <div
        v-if="sidebarOuverture"
        class="carte"
      >

        <h3>
          Carte des trajets
        </h3>

        <p>
          Voir les quartiers sur Google Maps.
        </p>

        <button class="btn-deconnexion">
          <i class="bi bi-box-arrow-right"></i>
          Déconnexion
        </button>

      </div>

    </aside>



    <main class="main">


      <header class="topbar">

        <div class="logo-section">

          <div class="logo-icon">
            <i class="bi bi-bicycle"></i>
          </div>

          <div class="logo-text">
            <strong>
              Cyclo-Pousse
            </strong>
          </div>

        </div>


        <div class="top-links">

          <button
            @click="allerLogin"
          >
            <i class="bi bi-person"></i>
            Connexion
          </button>

        </div>

      </header>



      <section class="contenu">

        <RouterView />

      </section>

    </main>

  </div>

</template>