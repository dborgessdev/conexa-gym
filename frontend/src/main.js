import { createApp } from "vue";
import router from "./router";
import App from "./App.vue";
import axios from "axios";

const app = createApp(App);

app.use(router); // O router deve ser usado antes da montagem da aplicação
app.mount("#app");

// Teste de conexão com o backend
axios
  .get("http://localhost:8000")
  .then((response) => console.log("Backend Conectado!", response))
  .catch((error) => console.error("Erro ao conectar:", error));
