<template>
  <v-container class="fill-height">
    <v-row justify="center">
      <v-col cols="12" sm="8" md="6" lg="4" class="mb-4">
        <v-card class="pa-5 rounded-xl shadow-card">
          <v-card-title class="text-center text-h4 mb-6">
            Rotina de Treinos do Aluno
          </v-card-title>

          <v-divider></v-divider>

          <v-row class="mt-4" justify="center">
            <template v-for="(treinos, dia) in rotinaTreinos" :key="dia">
              <v-col cols="12" class="mb-4">
                <v-row>
                  <v-col cols="12">
                    <p class="text-h6 font-weight-bold">{{ dia.charAt(0).toUpperCase() + dia.slice(1) }}</p>
                  </v-col>
                </v-row>
                <v-row v-if="treinos.length > 0">
                  <v-col v-for="(treino, index) in treinos" :key="index" cols="12">
                    <v-row>
                      <v-col cols="3" class="text-right">
                        <v-icon color="primary" @click="abrirModal(treino)">fitness_center</v-icon>
                      </v-col>
                      <v-col cols="9">
                        <p><strong>{{ treino.exercise_name }}</strong> - {{ treino.sets }} séries de {{ treino.repetitions }} repetições</p>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
                <v-row v-else>
                  <v-col cols="12">
                    <p class="text-muted">Nenhum treino cadastrado.</p>
                  </v-col>
                </v-row>
              </v-col>
            </template>
          </v-row>

          <v-divider></v-divider>

          <v-row class="mt-4" justify="center">
            <v-col cols="12">
              <v-btn block color="primary" to="/home" class="rounded-lg btn-hover">
                <v-icon left>home</v-icon> Home
              </v-btn>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>

    <!-- Modal de detalhes do treino -->
    <v-dialog v-model="modalVisivel" max-width="500px">
      <v-card>
        <v-card-title class="text-h5">Detalhes do Exercício</v-card-title>
        <v-card-text>
          <p><strong>Nome:</strong> {{ treinoSelecionado.exercise_name }}</p>
          <p><strong>Dia da Semana:</strong> {{ treinoSelecionado.day_of_week }}</p>
          <p><strong>Séries:</strong> {{ treinoSelecionado.sets }}</p>
          <p><strong>Repetições:</strong> {{ treinoSelecionado.repetitions }}</p>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="modalVisivel = false">Fechar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      userId: 3, // Troque para pegar o ID real do aluno autenticado
      rotinaTreinos: {
        segunda: [],
        terca: [],
        quarta: [],
        quinta: [],
        sexta: [],
        sabado: [],
        domingo: []
      },
      modalVisivel: false,
      treinoSelecionado: {}
    };
  },
  mounted() {
    this.carregarTreinos();
  },
  methods: {
    async carregarTreinos() {
      try {
        const response = await axios.get(`http://localhost:8000/treinos/get-trainig/${this.userId}`);
        this.rotinaTreinos = response.data.treinos || this.rotinaTreinos;
      } catch (error) {
        console.error("Erro ao buscar treinos:", error);
      }
    },
    abrirModal(treino) {
      this.treinoSelecionado = treino;
      this.modalVisivel = true;
    }
  }
};
</script>

<style scoped>
.v-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: linear-gradient(to right, #eef2f3, #d9e2ec);
  padding-right: 600px;
}

.shadow-card {
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  border-radius: 16px;
  width: 500px;
}

.v-btn {
  font-weight: bold;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: transform 0.3s ease-in-out;
  padding: 16px 0;
  font-size: 16px;
}

.v-btn:hover {
  transform: scale(1.05);
  filter: brightness(1.2);
}

.v-card {
  background-color: #ffffff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  width: 800px;
}

.v-card-title {
  color: #424242;
  text-align: center;
  padding-right: 15px;
}

.v-divider {
  margin: 16px 0;
}

.material-icons {
  font-size: 28px;
  margin-right: 10px;
}

.text-wrap {
  white-space: normal;
  word-break: break-word;
  text-align: center;
}

.btn-hover {
  transition: all 0.3s ease-in-out;
}
</style>
