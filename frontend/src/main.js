import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import axios from "axios";

createApp(App).mount('#app')

// Teste de conexão com o backend
axios.get("http://localhost:8000")
  .then(response => console.log("Backend Conectado!", response))
  .catch(error => console.error("Erro ao conectar:", error));