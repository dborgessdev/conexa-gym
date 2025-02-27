import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import axios from "axios";
import { createVuetify } from "vuetify";
import "vuetify/styles";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import 'material-symbols';

const vuetify = createVuetify({
  components,
  directives,
});

const app = createApp(App);

app.use(router);
app.use(vuetify);
app.mount("#app");

// Teste de conexão com o backend
axios
  .get("http://localhost:8000")
  .then((response) => console.log("Backend Conectado!", response))
  .catch((error) => console.error("Erro ao conectar:", error));
