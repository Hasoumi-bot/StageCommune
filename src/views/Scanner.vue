<template>
<qrcode-stream class="scanner"></qrcode-stream>
<p v-if="result">Resultat du scann: {{ result }}</p>
<div class="container-scanner">
    <qrcode-stream @detect="onDetect" @init="onInit"></qrcode-stream>
</div>
>>>>>>> 55fedad (Le scanner fonctionne)
</template>

<script setup>
import { ref } from 'vue';
import { QrcodeStream,setZXingModuleOverrides } from 'vue-qrcode-reader';
import wasmFile from '../../public/zxing_reader.wasm?url'
import path from 'path';

setZXingModuleOverrides({
    locateFile: (path,prefix)=>{
        if(path.endsWith('.wasm')) {return wasmFile}
        return prefix+path
    },
})

const result = ref("")

const onDetect = (detectedCodes)=>{
    result.value = detectedCodes[0].rawValue
    if(result.value.startsWith("http") || result.value.startsWith("https")){
        window.location.href = result.value
    }
    alert("detecté: "+ result.value)
    console.log(result.value)
}

const onInit = async (promise)=>{
    try{
        await promise
    }catch(err){
        if(err.name == "NotAllowedError"){
            alert("Il faut autoriser l' accès au camera")
        }
    }
}

</script>

<style>
.container-scanner{
    width: 200px;
    height: 200px;
}

</style>