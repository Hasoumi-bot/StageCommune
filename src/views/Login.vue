
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

function seConnecter() {
  erreur.value = ''

  // ADMIN
  if (email.value === 'adrianotrabe@gmail.com' && password.value === 'Adrianot152327') {
    sessionStorage.setItem('connecte', 'true')
    sessionStorage.setItem('role', 'admin')

    router.push('/')
    return
  }

  // UTILISATEUR
  if (email.value === 'user' && password.value === '1234') {
    sessionStorage.setItem('connecte', 'true')
    sessionStorage.setItem('role', 'utilisateur')

    router.push('/utilisateur')
    return
  }

  erreur.value = "Nom d'utilisateur ou mot de passe incorrect"
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
    <header class="topbar">

      <div class="logo-section">
        <div class="logo-icon">🚲</div>

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

    </header>


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

* {
  box-sizing: border-box;
}

.login-page {
  min-height: 100vh;
  background: #15161a;
  color: white;
  font-family: Arial, Helvetica, sans-serif;
}


/* =========================
   BARRE DU HAUT
========================= */

.topbar {
  height: 72px;
  background: #101114;
  border-bottom: 1px solid #292a2e;

  display: flex;
  align-items: center;
  justify-content: space-between;

  padding: 0 32px;
}

.logo-section {
  display: flex;
  align-items: center;
  gap: 12px;
}

.logo-icon {
  width: 38px;
  height: 38px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: #1683ff;
  border-radius: 8px;

  font-size: 21px;
}

.logo-text {
  font-size: 18px;
  color: white;
}


/* =========================
   LIENS DU HAUT
========================= */

.top-links {
  display: flex;
  gap: 8px;
}

.top-links button {
  border: none;
  background: transparent;

  color: #aaa;

  padding: 11px 18px;
  border-radius: 7px;

  cursor: pointer;
  font-weight: 600;
}

.top-links button:hover {
  color: white;
}

.top-links button.active {
  background: #0757c9;
  color: white;
}


/* =========================
   CONTENU
========================= */

.main-content {
  min-height: calc(100vh - 72px);

  display: flex;
  justify-content: center;
  align-items: center;

  padding: 40px 20px;
}


/* =========================
   CARTE
========================= */

.login-card {
  width: 390px;

  background: #101114;

  border: 1px solid #303136;

  border-radius: 22px;

  padding: 30px;

  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.35);
}


/* =========================
   TITRE
========================= */

.welcome span {
  color: #a8a8a8;

  font-size: 11px;

  font-weight: bold;

  letter-spacing: 1px;
}

.welcome h1 {
  margin: 10px 0 22px;

  font-size: 23px;

  line-height: 1.3;
}


/* =========================
   ONGLETS
========================= */

.tabs {
  display: flex;

  background: #17181c;

  border-radius: 12px;

  padding: 4px;

  margin-bottom: 28px;
}

.tabs button {
  width: 50%;

  border: none;

  background: transparent;

  color: #aaa;

  padding: 11px;

  border-radius: 9px;

  cursor: pointer;

  font-size: 14px;
}

.tabs button.selected {
  background: #111216;

  color: #1683ff;

  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}


/* =========================
   FORMULAIRE
========================= */

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;

  margin-bottom: 8px;

  font-size: 14px;

  font-weight: 600;
}

.input-box {
  height: 43px;

  display: flex;
  align-items: center;

  background: #101114;

  border: 1px solid #3a3b40;

  border-radius: 10px;

  padding: 0 12px;

  transition: 0.2s;
}

.input-box:focus-within {
  border-color: #1683ff;
  box-shadow: 0 0 0 2px rgba(22, 131, 255, 0.1);
}

.input-icon {
  width: 25px;

  color: #777;

  font-size: 15px;
}

.input-box input {
  flex: 1;

  border: none;
  outline: none;

  background: transparent;

  color: white;

  font-size: 14px;
}

.input-box input::placeholder {
  color: #707178;
}

.eye-button {
  border: none;

  background: transparent;

  color: #888;

  cursor: pointer;

  font-size: 15px;
}


/* =========================
   OPTIONS
========================= */

.options {
  display: flex;

  justify-content: space-between;

  align-items: center;

  margin: 5px 0 20px;

  font-size: 12px;
}

.remember {
  display: flex;

  align-items: center;

  gap: 7px;

  color: #999;
}

.remember input {
  accent-color: #1683ff;
}

.forgot {
  border: none;

  background: transparent;

  color: #1683ff;

  cursor: pointer;

  font-size: 12px;
}


/* =========================
   ERREUR
========================= */

.error {
  background: rgba(220, 50, 50, 0.12);

  border: 1px solid rgba(220, 50, 50, 0.3);

  color: #ff7070;

  padding: 10px;

  border-radius: 8px;

  font-size: 13px;

  margin-bottom: 15px;

  text-align: center;
}


/* =========================
   BOUTON CONNEXION
========================= */

.login-button {
  width: 100%;

  height: 48px;

  border: none;

  border-radius: 10px;

  background: #0757c9;

  color: white;

  font-size: 14px;

  font-weight: bold;

  cursor: pointer;

  transition: 0.2s;
}

.login-button:hover {
  background: #0869ed;

  transform: translateY(-1px);
}


/* =========================
   TEXTE BAS
========================= */

.bottom-text {
  text-align: center;

  color: #999;

  font-size: 12px;

  margin-top: 20px;
}

.bottom-text button {
  border: none;

  background: transparent;

  color: #1683ff;

  cursor: pointer;

  font-weight: bold;

  font-size: 12px;
}

.bottom-text button:hover {
  text-decoration: underline;
}


/* =========================
   MOBILE
========================= */

@media (max-width: 600px) {

  .topbar {
    padding: 0 15px;
  }

  .logo-text {
    font-size: 16px;
  }

  .top-links button {
    padding: 9px 10px;
  }

  .login-card {
    width: 100%;

    max-width: 390px;

    padding: 25px 20px;
  }

}

</style>