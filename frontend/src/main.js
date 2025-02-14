import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import axios from "axios";
import { createVuetify } from "vuetify";
import "vuetify/styles"; // Importando estilos padrão do Vuetify

const vuetify = createVuetify(); // Criando a instância do Vuetify

const app = createApp(App);

app.use(router); 
app.use(vuetify); // Registrando o Vuetify na aplicação
app.mount("#app");

// Teste de conexão com o backend
axios
  .get("http://localhost:8000")
  .then((response) => console.log("Backend Conectado!", response))
  .catch((error) => console.error("Erro ao conectar:", error));
