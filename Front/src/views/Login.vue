<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const API_URL = 'http://localhost/Stage%20commune%20L2/testVue/Back/Authent/API.php'

const mode = ref('connexion')

const nom = ref('')
const prenom = ref('')
const email = ref('')
const password = ref('')
const IdCommune = ref('')
const statut = ref('')
const telephone = ref('')
const erreur = ref('')

const afficherPassword = ref(false)
const souvenir = ref(false)

// Envoie une action à l'API PHP et renvoie la réponse JSON
async function appelerAPI(donnees) {
  const reponse = await fetch(API_URL, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(donnees)
  })
  return await reponse.json()
}

async function seConnecter() {
  erreur.value = ''

  if (!email.value || !password.value) {
    erreur.value = 'Veuillez remplir tous les champs'
    return
  }

  try {
    const resultat = await appelerAPI({
      action: 'connexion',
      email: email.value,
      motDePasse: password.value
    })

    if (resultat.success) {
      sessionStorage.setItem('connecte', 'true')
      sessionStorage.setItem('role', resultat.utilisateur.STATUTUTILISATEUR)
      router.push('/scanner')
    } else {
      erreur.value = resultat.message
    }
  } catch (e) {
    console.error('Détail de l\'erreur :', e)
    erreur.value = 'Erreur de connexion au serveur'
  }
}

async function inscription() {
  erreur.value = ''

  if (
    !IdCommune.value || !nom.value || !prenom.value ||
    !email.value || !password.value || !statut.value || !telephone.value
  ) {
    erreur.value = 'Veuillez remplir tous les champs'
    return
  }

  try {
    const resultat = await appelerAPI({
      action: 'inscription',
      IdCommune: IdCommune.value,
      Nom: nom.value,
      Prenom: prenom.value,
      email: email.value,
      motDePasse: password.value,
      statut: statut.value,
      telephone: telephone.value
    })

    if (resultat.success) {
      viderChamps()
      mode.value = 'connexion'
    } else {
      erreur.value = resultat.message
    }
  } catch (e) {
    console.error('Détail de l\'erreur :', e)
    erreur.value = 'Erreur de connexion au serveur'
  }
}

function viderChamps() {
  nom.value = ''
  prenom.value = ''
  email.value = ''
  password.value = ''
  IdCommune.value = ''
  statut.value = ''
  telephone.value = ''
  afficherPassword.value = false
}

function changerMode(nouveauMode) {
  mode.value = nouveauMode
  erreur.value = ''
  viderChamps()
}
</script>


<template>
  <div class="login-page">

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

            <label>Adresse e-mail</label>

            <div class="input-box">

              <span class="input-icon">✉</span>

              <input
                v-model="email"
                type="text"
                placeholder="ex: utilisateur@gmail.com"
              />

            </div>

          </div>


          <div class="form-group">

            <label>Mot de passe de votre compte</label>

            <div class="input-box">

              <span class="input-icon">
                <i class="bi bi-lock"></i>
              </span>

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
                <i
                  :class="
                    afficherPassword
                      ? 'bi bi-eye-slash'
                      : 'bi bi-eye'
                  "
                ></i>
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

            <!-- <button
              type="button"
              class="forgot"
            >
              Mot de passe oublié ?
            </button> -->

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
                v-model="IdCommune"
                type="text"
                placeholder="Ex 110"
              />

            </div>

          </div>


          <div class="form-group">

            <label>Statut</label>

            <div class="input-box">

              <span class="input-icon"></span>

              <select
                v-model="statut"
                class="choice"
              >
                <option value="">
                  Choisir un statut
                </option>

                <option value="admin">
                  Admin
                </option>

                <option value="controleur">
                  Contrôleur
                </option>

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
                v-model="prenom"
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

            <label>Téléphone</label>

            <div class="input-box">

              <span class="input-icon">☎</span>

              <input
                v-model="telephone"
                type="tel"
                placeholder="Entrer le numéro"
              />

            </div>

          </div>


          <div class="form-group">

            <label>Mot de passe</label>

            <div class="input-box">

              <span class="input-icon">
                <i class="bi bi-lock"></i>
              </span>

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
                <i
                  :class="
                    afficherPassword
                      ? 'bi bi-eye-slash'
                      : 'bi bi-eye'
                  "
                ></i>
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