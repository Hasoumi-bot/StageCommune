<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const mode = ref('connexion')

const email = ref('')
const password = ref('')
const nom = ref('')
const erreur = ref('')
const afficherPassword = ref(false)
const souvenir = ref(false)

async function seConnecter() {
  erreur.value = ''

  if (!email.value || !password.value){
    erreur.value = 'Veuillez remplir tous les champs'
    return
  }

  try{
    const reponse = await fetch('http://localhost/gestioncyclocua2026/API.php',{
      method : 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body : JSON.stringify({
        action : 'connexion',
        email : email.value,
        motDePasse: password.value
      })
    })

    const resultat = await reponse.json()

    if(resultat.success){
      sessionStorage.setItem('connecte', 'true')

      sessionStorage.setItem(
        'role',
        resultat.utilisateur.STATUTUTITILISATEUR
      )

      if(resultat.utilisateur.STATUTUTITILISATEUR === 'admin'){
        router.push('scanner')
      }else{
        router.push('scanner')
      }
    }else{
      erreur.value = resultat.message
    }
  }catch(e) {
    erreur.value = 'Erreur de connexion au serveur'
  }
}


function inscription() {
  erreur.value = ''

  if (!nom.value || !email.value || !password.value) {
    erreur.value = 'Veuillez remplir tous les champs'
    return
  }

  erreur.value = 'L’inscription sera disponible prochainement.'
}

function changerMode(nouveauMode) {
  mode.value = nouveauMode
  erreur.value = ''
}
</script>

<template>
  <div class="login-page">

    <!-- BARRE DU HAUT -->
    <!--header class="topbar">
=======
    <header class="topbar">

      <div class="logo-section">
        <div class="logo-icon"><i :class=" 'bi bi-bicycle'"></i></div>

        <div class="logo-text">
          <strong>Cyclo-Pousse</strong>
        </div>
      </div>

      <div class="top-links">
        <button
          :class="{ active: mode === 'connexion' }"
          @click="changerMode('connexion')"
        >
          Connexion
        </button>

        <button
          :class="{ active: mode === 'inscription' }"
          @click="changerMode('inscription')"
        >
          Inscription
        </button>
      </div>

    </header-->


    <!-- CONTENU -->
    <main class="main-content">

      <div class="login-card">

        <div class="welcome">
          <span>BIENVENUE</span>

          <h1>
            {{ mode === 'connexion'
              ? 'Connexion à Cyclo-Pousse'
              : 'Créer un compte'
            }}
          </h1>
        </div>


        <!-- ONGLETS -->
        <div class="tabs">

          <button
            :class="{ selected: mode === 'connexion' }"
            @click="changerMode('connexion')"
          >
            Connexion
          </button>

          <button
            :class="{ selected: mode === 'inscription' }"
            @click="changerMode('inscription')"
          >
            Inscription
          </button>

        </div>


        <!-- CONNEXION -->
        <form
          v-if="mode === 'connexion'"
          @submit.prevent="seConnecter"
        >

          <div class="form-group">

            <label>Nom d'utilisateur</label>

            <div class="input-box">

              <span class="input-icon">✉</span>

              <input
                v-model="email"
                type="text"
                placeholder="admin ou user"
              />

            </div>

          </div>


          <div class="form-group">

            <label>Mot de passe</label>

            <div class="input-box">

              <span :class="'bi bi-cadena'"></span>

              <input
                v-model="password"
                :type="afficherPassword ? 'text' : 'password'"
                placeholder="••••••••"
              />

          <button
            type="button"
            class="eye-button"
            @click="afficherPassword = !afficherPassword"
          >
          <i :class="afficherPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
          </button>

            </div>

          </div>


          <div class="options">

            <label class="remember">

              <input
                v-model="souvenir"
                type="checkbox"
              />

              <span>Se souvenir de moi</span>

            </label>

            <button
              type="button"
              class="forgot"
            >
              Mot de passe oublié ?
            </button>

          </div>


          <p
            v-if="erreur"
            class="error"
          >
            {{ erreur }}
          </p>


          <button
            type="submit"
            class="login-button"
          >
            Se connecter
          </button>


          <p class="bottom-text">
            Pas encore de compte ?
            <button
              type="button"
              @click="changerMode('inscription')"
            >
              S'inscrire
            </button>
          </p>

        </form>


        <!-- INSCRIPTION -->
        <form
          v-else
          @submit.prevent="inscription"
        >


          <div class="form-group">

            <label>Code postal</label>

            <div class="input-box">

              <span class="input-icon"></span>

              <input
                type="text"
                placeholder="Ex 110"
              />

            </div>
          </div>


          <div class="form-group">

            <label>Statut</label>

            <div class="input-box">

              <span class="input-icon"></span>

              <select class="choice">
                <option value="">Choisir un statut</option>
                <option value="admin">Admin</option>
                <option value="controleur">Contrôleur</option>
              </select>

            </div>
          </div>


          <div class="form-group">

            <label>Nom</label>

            <div class="input-box">

              <span class="input-icon">👤</span>

              <input
                v-model="nom"
                type="text"
                placeholder="Votre nom"
              />

            </div>

          </div>

          <div class="form-group">

          <label>Prénom(s)</label>

            <div class="input-box">

              <span class="input-icon">👤</span>

              <input
                type="text"
                placeholder="Votre prénom(s)"
              />

            </div>
          </div>


          <div class="form-group">

            <label>Email</label>

            <div class="input-box">

              <span class="input-icon">✉</span>

              <input
                v-model="email"
                type="email"
                placeholder="ton@email.com"
              />

            </div>

          </div>


          <div class="form-group">

            <label>Téléphone </label>

            <div class="input-box">

              <span class="input-icon">☎</span>

              <input
                v-model="telephone"
                type="email"
                placeholder="Entrer le numéro"
              />

            </div>

          </div>


          <div class="form-group">

            <label>Mot de passe</label>

            <div class="input-box">

              <span class="input-icon">🔒</span>

              <input
                v-model="password"
                :type="afficherPassword ? 'text' : 'password'"
                placeholder="••••••••"
              />

              <button
                type="button"
                class="eye-button"
                @click="afficherPassword = !afficherPassword"
              >
                {{ afficherPassword ? '🙈' : '👁' }}
              </button>

            </div>

          </div>


          <p
            v-if="erreur"
            class="error"
          >
            {{ erreur }}
          </p>


          <button
            type="submit"
            class="login-button"
          >
            S'inscrire
          </button>


          <p class="bottom-text">

            Déjà un compte ?

            <button
              type="button"
              @click="changerMode('connexion')"
            >
              Se connecter
            </button>

          </p>

        </form>

      </div>

    </main>

  </div>
</template>


<style scoped>

</style>