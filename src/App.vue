<script setup>

//import Sidebar from './Composants/Sidebar.vue'
import Profile from './Composants/Profile.vue';
import Contenu from './Composants/Contenu.vue';

import Sidebar from './Composants/Sidebar.vue';

import AdminDashboard from './Composants/AdminDashBoard/AdminDashboard.vue';
</script>

<template>

  <div class="app">
            <Sidebar />

    <main class="main">
        <Profile />
        <Contenu />
    </main>

  </div>
</template>

<style scoped>
.main {
  flex: 1;
  display: flex;
  flex-direction: column;
  width: 100%;
  min-width: 0;
  min-height: 100vh;
  background: #141719;
}
.app{
    width: 100%;
    display: flex;
}
</style>
