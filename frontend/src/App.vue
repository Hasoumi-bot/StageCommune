<script setup>
  import { onMounted, ref } from 'vue'

  const taches = ref([])

  async function chargerTaches() {

    const reponse = await fetch('API.php')
    taches.value = await reponse.json()
    
  }
  onMounted(chargerTaches)

  const nouvelleTache = ref('')
  
  async function ajouterTache() {
    if(!nouvelleTache.value.trim()) return

     await fetch('API.php',{
     method: 'POST',
     headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      contenu: nouvelleTache.value
      })
    })

    nouvelleTache.value= ''
    await chargerTaches()
  }

  const indexModification = ref(null)

  function commencerModification(index){
    indexModification.value = index
    nouvelleTache.value = taches.value[index].contenu
  }
  
  async function modifierTache() {
    if(indexModification.value === null) return

    const id = taches.value[indexModification.value].id

    
    await fetch(`API.php?id=${id}`,{
      method: 'PUT',
      headers:{
        'Content-Type': 'application/json' 
      },
      body: JSON.stringify({
        contenu: nouvelleTache.value
      })
    })

    nouvelleTache.value = ''
    indexModification.value = null

    await chargerTaches()
  }


  async function SupprimerTache(id) {
    await fetch(`API.php?id=${id}`,{
      method: 'DELETE'
    })

      await chargerTaches()
    
  }

    
  // }

  // async function SupprimerTache(index) {
  //   await fetch('API.php?id=${id}', {methode: 'DELETE'})
  //   await chargerTaches()    
  // }

  // function ajouterTache(){
  //   if(nouvelleTache.value){
    //     // console.log(nouvelleTache.value)
    //     taches.value.push(nouvelleTache.value)
    
    //     nouvelleTache.value=''
    //      }
    // }
    
    // function modifierTache(index){
      //   indexModification.value = index
      //   nouvelleTache.value = taches.value[index]
      // }
      
      // function SupprimerTache(index){
        //   taches.value.splice(index, 1)
        // }
        
        // async function  ajouterTache() {
        //   if(!nouvelleTache.value) return
        
        //   await fetch('API.php',{
        //     method: 'POST',
        //     Headers: {'Content-Type : application/json'},
        //     body: JSON.stringify({ contenu : nouvelleTache.value})
        //   }
        // )
        
        // nouvelleTache.value=''
        // await chargerTaches()
          
        // }
        
        // async function modifierTache(index) {
        //   if(!indexModification) return
        
        //   await fetch('API.php',{
        //   method:'PUT',
        //   Headers:{'Content-Type : application/jdon'},
        //   body : JSON.stringify({contenu: nouvelleTache.value})
        //   })
  </script>

<template>
  <h1>Ma To-do List</h1>
  
  <input 
   type="text"
   placeholder="Entrez une tâche"
   v-model="nouvelleTache"
   >

  <button @click="ajouterTache">Ajouter</button>
  <button @click="modifierTache">Modifier</button>

  <ul>
    <li v-for="(tache,index) in taches" :key="tache.id">
      {{ tache.contenu }}
      <button @click="SupprimerTache(tache.id)">Supprimer</button>
      <button @click="commencerModification(index)">Modifier</button>
    </li>
  </ul>
</template>
 